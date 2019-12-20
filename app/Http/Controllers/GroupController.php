<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Group, Applicant, Loan, Setting, Schedule, Employee, Transaction};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class GroupController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    //
    public function groups($value='')
    {
    	# code...
    	//$groups = Group::get();

        //$groups = Group::leftJoin('employees','employees.id','=','groups.employee_id')->get(['employees.name AS officer','groups.*']);
        $groups = DB::select('SELECT groups.*,(SELECT COUNT(id) FROM applicants WHERE applicants.group_id = groups.id) as members, employees.name AS officer FROM groups LEFT JOIN employees ON groups.employee_id = employees.id ORDER BY groups.id');

    	$data = array('groups'=>$groups);

    	return view('groups', $data);
    }

    public function group($id='')
    {
        # code...
        $group = Group::leftJoin('employees','employees.id','=','groups.employee_id')->where('groups.id',$id)->get(['employees.name AS officer','groups.*'])->first();

        //$member = Applicant::leftjoin('groups','groups.id','applicants.group_id')->where('applicants.id',$id)->get(['applicants.*','groups.name AS group'])->first();

        $group_members = Applicant::where('group_id',$id)->get();

        $data = array('group'=>$group,'members'=>$group_members);

        return view('group', $data);
    }

    public function register_group($value='')
    {
    	# code...
    	$employees = Employee::get();

    	$data = array('employees'=>$employees); // return messages if there are no employees

    	return view('new_group', $data);
    }

    public function edit($id='')
    {
        $group = Group::find($id);

        $employees = Employee::get();

        $data = array('group'=>$group, 'employees'=>$employees);
       
        return view('edit_group', $data);
    }

    public function save(Request $request)
    {
    	$request->validate([
            'groupname' => 'required',
            'frequency' => 'required',
            'dateofcreation' => 'required'
        ]);

        $group = new Group;

        if(isset($request->id)) // If id is given update the existing record
        {
            if(Group::find($request->id))
            {
                $group = Group::find($request->id);
            }else{
                throw new Exception("Out of Range");
            }
        }

        $group->group_no = $request->group_no;
        $group->name = $request->groupname;
        $group->employee_id = $request->officer;
        $group->meeting_day = $request->meeting_day;
        $group->meeting_frequency = $request->frequency;
        $group->location  = $request->location;
        $group->activity = $request->activity;
        $group->creation_date = $request->dateofcreation;
        $group->is_active = $request->is_active;        

        $group->save();
        
        return redirect('/group/details/'.$group->id)->with('status','Group Saved Successfully');
    }


    public function group_portfolio()
    {
        $group_portfolio = DB::select('SELECT groups.id,groups.group_no,groups.name, groups.is_active,
            SUM(loan_repayments.principal) total_principal,
            (SUM(loan_repayments.principal) - SUM(loan_repayments.principal_repaid)) total_p_bal, 
            SUM(loan_repayments.interest) total_interest, 
            (SUM(loan_repayments.interest) - SUM(loan_repayments.interest_repaid)) total_i_bal 
        FROM groups INNER JOIN applicants ON groups.id = applicants.group_id INNER JOIN loans ON applicants.id = loans.applicant_id INNER JOIN loan_repayments ON loans.id = loan_repayments.loan_id 
        GROUP BY groups.group_no, groups.name, groups.is_active, groups.id');

        $group_sums = DB::select('SELECT
            SUM(loan_repayments.principal) total_principal,
            (SUM(loan_repayments.principal) - SUM(loan_repayments.principal_repaid)) total_p_bal, 
            SUM(loan_repayments.interest) total_interest, 
            (SUM(loan_repayments.interest) - SUM(loan_repayments.interest_repaid)) total_i_bal 
        FROM groups INNER JOIN applicants ON groups.id = applicants.group_id INNER JOIN loans ON applicants.id = loans.applicant_id INNER JOIN loan_repayments ON loans.id = loan_repayments.loan_id ');


        $data = array('group_portfolio' => $group_portfolio, 'group_sums' => $group_sums);

        return view('group_portfolio', $data);
    }
}
