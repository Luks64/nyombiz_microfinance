<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Applicant, Loan, Setting, Schedule, LoanRepayment, Transaction, Group, Employee};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
// use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

use App\Events\LoanInArrears;

// set_time_limit(6000);

class ReportsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function annual($year='')
    {
    	$annual_loans = DB::select('SELECT YEAR(loan_repayments.created_at) as loan_year,
            SUM(loan_repayments.principal) total_principal,
            (SUM(loan_repayments.principal) - SUM(loan_repayments.principal_repaid)) total_p_bal, 
            SUM(loan_repayments.interest) total_interest, 
            (SUM(loan_repayments.interest) - SUM(loan_repayments.interest_repaid)) total_i_bal 
        FROM loans INNER JOIN loan_repayments ON loans.id = loan_repayments.loan_id 
        GROUP BY loan_year');

        $group_sums = DB::select('SELECT 
            SUM(loan_repayments.principal) total_principal,
            (SUM(loan_repayments.principal) - SUM(loan_repayments.principal_repaid)) total_p_bal, 
            SUM(loan_repayments.interest) total_interest, 
            (SUM(loan_repayments.interest) - SUM(loan_repayments.interest_repaid)) total_i_bal 
        FROM loans INNER JOIN loan_repayments ON loans.id = loan_repayments.loan_id ');

    	$data = array('annual_loans'=>$annual_loans, 'group_sums' => $group_sums);
        return view('report_by_year',$data);
    }

    public function by_months($year='')
    {
    	$monthly_loans = DB::select('SELECT MONTH(loan_repayments.created_at) as loan_months,
            SUM(loan_repayments.principal) total_principal,
            (SUM(loan_repayments.principal) - SUM(loan_repayments.principal_repaid)) total_p_bal, 
            SUM(loan_repayments.interest) total_interest, 
            (SUM(loan_repayments.interest) - SUM(loan_repayments.interest_repaid)) total_i_bal 
        FROM loans INNER JOIN loan_repayments ON loans.id = loan_repayments.loan_id 
        GROUP BY loan_months');

        $group_sums = DB::select('SELECT 
            SUM(loan_repayments.principal) total_principal,
            (SUM(loan_repayments.principal) - SUM(loan_repayments.principal_repaid)) total_p_bal, 
            SUM(loan_repayments.interest) total_interest, 
            (SUM(loan_repayments.interest) - SUM(loan_repayments.interest_repaid)) total_i_bal 
        FROM loans INNER JOIN loan_repayments ON loans.id = loan_repayments.loan_id');

        $years = DB::select('SELECT DISTINCT YEAR(created_at) AS years FROM loan_repayments ORDER BY years DESC');

    	$data = array('monthly_loans'=>$monthly_loans, 'group_sums' => $group_sums, 'years' => $years);
        return view('report_by_month',$data);
    }


    public function by_weeks($year='')
    {
    	$weekly_loans = DB::select('SELECT CONCAT(YEAR(loan_repayments.date_repaid), "/", WEEK(date_repaid)) as year_week,
            SUM(loan_repayments.principal) total_principal,
            (SUM(loan_repayments.principal) - SUM(loan_repayments.principal_repaid)) total_p_bal, 
            SUM(loan_repayments.interest) total_interest, 
            (SUM(loan_repayments.interest) - SUM(loan_repayments.interest_repaid)) total_i_bal 
        FROM loans INNER JOIN loan_repayments ON loans.id = loan_repayments.loan_id WHERE loan_repayments.date_repaid IS NOT NULL
        GROUP BY year_week ');

        $group_sums = DB::select('SELECT 
            SUM(loan_repayments.principal) total_principal,
            (SUM(loan_repayments.principal) - SUM(loan_repayments.principal_repaid)) total_p_bal, 
            SUM(loan_repayments.interest) total_interest, 
            (SUM(loan_repayments.interest) - SUM(loan_repayments.interest_repaid)) total_i_bal 
        FROM loans INNER JOIN loan_repayments ON loans.id = loan_repayments.loan_id WHERE loan_repayments.date_repaid IS NOT NULL');

        $years = DB::select('SELECT DISTINCT YEAR(created_at) AS years FROM loan_repayments ORDER BY years DESC');

    	$data = array('weekly_loans'=>$weekly_loans, 'group_sums' => $group_sums, 'years' => $years);
        return view('report_by_week',$data);
    }


    public function this_week()
    {
    	$this_week_loans = DB::select('SELECT loan_repayments.date_repaid as loan_days,
            SUM(loan_repayments.principal) total_principal,
            (SUM(loan_repayments.principal) - SUM(loan_repayments.principal_repaid)) total_p_bal, 
            SUM(loan_repayments.interest) total_interest, 
            (SUM(loan_repayments.interest) - SUM(loan_repayments.interest_repaid)) total_i_bal 
        FROM loans INNER JOIN loan_repayments ON loans.id = loan_repayments.loan_id WHERE YEARWEEK(loan_repayments.date_repaid, 1) = YEARWEEK(CURDATE(), 1)
        GROUP BY loan_days');

        $group_sums = DB::select('SELECT 
            SUM(loan_repayments.principal) total_principal,
            (SUM(loan_repayments.principal) - SUM(loan_repayments.principal_repaid)) total_p_bal, 
            SUM(loan_repayments.interest) total_interest, 
            (SUM(loan_repayments.interest) - SUM(loan_repayments.interest_repaid)) total_i_bal 
        FROM loans INNER JOIN loan_repayments ON loans.id = loan_repayments.loan_id WHERE YEARWEEK(loan_repayments.date_repaid, 1) = YEARWEEK(CURDATE(), 1)');

    	$data = array('this_week_loans'=>$this_week_loans, 'group_sums' => $group_sums);
        return view('report_this_week',$data);
    }


    public function par($value='') //Portfolio at Risk
    {
        $parsum_above_30 = DB::select('SELECT loans.id, SUM(loan_repayments.principal) principal, SUM(loan_repayments.principal - loan_repayments.principal_repaid) pdue FROM loans LEFT JOIN loan_repayments ON loans.id = loan_repayments.loan_id WHERE DATEDIFF(NOW(),loans.date_of_completion) > 30 AND loans.status = 0 GROUP BY loans.id');

        $parsum_below_30 = DB::select('SELECT loans.id, SUM(loan_repayments.principal) principal, SUM(loan_repayments.principal - loan_repayments.principal_repaid) pdue FROM loans LEFT JOIN loan_repayments ON loans.id = loan_repayments.loan_id WHERE (DATEDIFF(NOW(),loans.date_of_completion) BETWEEN 0 AND 30) AND loans.status = 0 GROUP BY loans.id');

        $parcount_above_30 = DB::select('SELECT COUNT(loans.id) loans FROM loans WHERE (DATEDIFF(NOW(),loans.date_of_completion) > 30) AND loans.status = 0');

        $parcount_below_30 = DB::select('SELECT COUNT(loans.id) loans FROM loans WHERE (DATEDIFF(NOW(),loans.date_of_completion) BETWEEN 0 AND 30) AND loans.status = 0');

        $data = array('parsum_above_30'=>$parsum_above_30, 'parsum_below_30' => $parsum_below_30, 'parcount_above_30'=>$parcount_above_30, 'parcount_below_30' => $parcount_below_30);

        return view('portfolio_analysis', $data);
    }

    public function collectsheet(Request $request)
    {
        
        $loans = DB::select('SELECT loans.*, applicants.first_name, applicants.last_name, groups.name as grp_name, (SELECT SUM(principal - principal_repaid + interest - interest_repaid) FROM loan_repayments WHERE loan_id = loans.id AND YEARWEEK(due_date,1) = YEARWEEK(CURDATE(), 1)) as installment, (SELECT SUM(principal - principal_repaid + interest - interest_repaid) FROM loan_repayments WHERE loan_id = loans.id) as outstanding FROM loans LEFT JOIN applicants ON loans.applicant_id = applicants.id LEFT JOIN groups ON applicants.group_id = groups.id WHERE loans.status = 0');

        if($request->group_id)
        {
            $loans = DB::select('SELECT loans.*, applicants.first_name, applicants.last_name, groups.name as grp_name, (SELECT SUM(principal - principal_repaid + interest - interest_repaid) FROM loan_repayments WHERE loan_id = loans.id AND YEARWEEK(due_date,1) = YEARWEEK(CURDATE(), 1)) as installment, (SELECT SUM(principal - principal_repaid + interest - interest_repaid) FROM loan_repayments WHERE loan_id = loans.id) as outstanding FROM loans LEFT JOIN applicants ON loans.applicant_id = applicants.id LEFT JOIN groups ON applicants.group_id = groups.id WHERE loans.status = 0 AND groups.id = ?',[$request->group_id]);
        }

        // return $loans;

        $groups = Group::get();

        $data = array('loans' => $loans, 'groups' => $groups);

        return view('collectionsheet', $data);
    }
}