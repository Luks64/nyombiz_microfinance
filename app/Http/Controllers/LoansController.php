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

class LoansController extends Controller
{
    use \Mpociot\Reanimate\ReanimateModels;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($value=''){

        $total_loans = Loan::get()->count();

        $employees = Employee::get()->count();

        $groups = Group::get()->count();

        $members = Applicant::get()->count();

        $total_interest_due = LoanRepayment::get()->sum('interest') - LoanRepayment::get()->sum('interest_repaid');

        $principal_out = Loan::get()->sum('amount_given');

        $principal_in = LoanRepayment::get()->sum('principal_repaid');

        $net_given_out = Loan::get()->sum('net_given') - $principal_in;// net given minus total repaid
      
        return view('index')->with('principal_out', $principal_out)->with('principal_in', $principal_in)->with('total_loans', $total_loans)->with('employees',$employees)->with('members',$members)->with('groups',$groups)->with('total_interest_due',$total_interest_due)->with('net_given_out',$net_given_out);
    }
    /**
     * Show the New Member Form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function new_applicant($value=''){
    //     # code...
    //     $groups = Group::get();

    //     $data = array('groups'=>$groups);

    //     return view('new_applicant', $data);
    // }
    public function edit_applicant($id){
        # code...

    }
    /**
     * Called when the Next button on the above form is clicked.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function register_applicant(Request $request){

        $id = '';

	    //return redirect('/loan/new')->with('success', 'Applicant Created');
        return redirect('member/details/'.$id)->with('success', 'Applicant Created');
        // return redirect('/loan/new');
    }
    public function update_applicant(Request $request){

        $id = '';

        // Store a piece of data in the session...
        session(['user_id' => $id]);

        return redirect('/loan/edit/'.$id)->with('success', 'Applicant Edited');
        // return redirect('/loan/new');
    }
    /**
     * Show the New Loan From after clicking next.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function new_loan($id=''){
        
        session(['user_id' => $id]);

        $applicant = Applicant::find($id);

        return view('new_loan',['applicant'=>$applicant]);
    }
    public function edit_loan($id){
        # code...
        $loan = Loan::find($id);

        $data = ['loan' => $loan];

        return view('edit_loan', $data);
    }
    /**
     * Called when the Save button on the above form is clicked.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add_loan_to_user(Request $request){
        $loan = new Loan;

        $request->validate([
            //'amountappliedfor' => 'bail|required|numeric|max:1000000000',
            'amountgiven' => 'bail|required|numeric|max:1000000000|gte:netgiven',
            'netgiven' => 'bail|required|numeric|max:1000000000',
            'period' => 'bail|required|numeric|max:16',
            'interest' => 'bail|required|numeric',
            'dateofissue' => 'bail|required|date',
            'datewhenaquired' => 'bail|required|date',
            'security1' => 'required',
            'security1_value' => 'required',            
            'paymentmode' => 'required',
            'interestmethod' => 'required'
        ]);

    	$applicant_id = $request->session()->get('user_id');
    	$loan->applicant_id = $applicant_id;
    	//$loan->amount_applied_for = $request->amountappliedfor;
        $loan->amount_applied_for = $request->amountgiven;
        $loan->amount_given = $request->amountgiven;
    	$loan->net_given = $request->netgiven;
    	$loan->period_in_months = $request->period;
    	$loan->interest = $request->interest;
        $loan->due_loan = $request->interest + $request->amountgiven;
    	$loan->purpose = $request->purpose;
    	$loan->date_when_required = $request->datewhenaquired;
    	$loan->date_of_issue = $request->dateofissue;
    	$loan->security1 = $request->security1;
    	$loan->security1_value = $request->security1_value;
    	$loan->security2 = $request->security2;
    	$loan->security2_value = $request->security2_value;
    	$loan->security3 = $request->security3;
    	$loan->security3_value = $request->security3_value;
    	$loan->guarantor1_name = $request->guarantor1_name;
    	$loan->guarantor1_phone = $request->guarantor1_phone;
    	$loan->guarantor2_name = $request->guarantor2_name;
    	$loan->guarantor2_phone = $request->guarantor2_phone;
    	$loan->payment_mode = $request->paymentmode;
        $loan->interest_method = $request->interestmethod;
        $date_of_completion = $this->determine_date_of_completion($request->dateofissue, $request->period, $request->paymentmode);
        $loan->date_of_completion = $date_of_completion;

    	$loan->save();

        $id = $loan->id;

        $loan_repayment = new LoanRepayment;

        if($loan->interest_method == 'flat'){
            if($loan->payment_mode == 'monthly'){
                $no_of_payments = $loan->period_in_months;

                $principal__per_payment = $loan->amount_given / $no_of_payments;

                $interest__per_payment = $loan->interest / $no_of_payments;

                $amount_per_payment = $principal__per_payment + $interest__per_payment;

                for ($i = 1; $i <= $no_of_payments; $i++) { 
                    # code...
                    $balance_per_payment = $loan->amount_given + $loan->interest - $amount_per_payment * $i;

                    $due_date = new \DateTime($loan->date_of_issue);

                    $due_date = $due_date->modify('+'.$i.' months');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    // $loan_repayment->save();
                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                }
            }
            
            if($request->paymentmode == 'weekly'){

                $no_of_payments = $request->period * 4;

                $principal__per_payment = $request->amountgiven / $no_of_payments;

                $interest__per_payment = $request->interest / $no_of_payments;

                $amount_per_payment = $principal__per_payment + $interest__per_payment;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...
                    $balance_per_payment = $request->amountgiven + $request->interest - $amount_per_payment * $i;

                    $due_date = new \DateTime($request->dateofissue);

                    $due_date = $due_date->modify('+'.$i.' weeks');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }    
            }

            if($request->paymentmode == 'daily'){

                $no_of_payments = $request->period * 30;

                $principal__per_payment = $request->amountgiven / $no_of_payments;

                $interest__per_payment = $request->interest / $no_of_payments;

                $amount_per_payment = $principal__per_payment + $interest__per_payment;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...
                    $balance_per_payment = $request->amountgiven + $request->interest - $amount_per_payment * $i;

                    $due_date = new \DateTime($request->dateofissue);

                    $due_date = $due_date->modify('+'.$i.' days');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            } 
        }else{
            $interest_rate = Setting::where('key', 'interest_rate')->value('value');

            if($loan->payment_mode == 'monthly'){
                $no_of_payments = $loan->period_in_months;

                $principal__per_payment = $loan->amount_given / $no_of_payments;

                for ($i = 1; $i <= $no_of_payments; $i++) { 
                    # code...

                    $interest__per_payment = ($interest_rate/100)*($loan->amount_given - ($i-1)*$principal__per_payment);

                    $amount_per_payment = $principal__per_payment + $interest__per_payment;

                    $due_date = new \DateTime($loan->date_of_issue);

                    $due_date = $due_date->modify('+'.$i.' months');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    // $loan_repayment->save();
                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                }
            }
            if($request->paymentmode == 'weekly'){

                $no_of_payments = $request->period * 4;

                $principal__per_payment = $request->amountgiven / $no_of_payments;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...

                    $interest__per_payment = ($interest_rate/100)*($loan->amount_given - ($i-1)*$principal__per_payment);

                    $amount_per_payment = $principal__per_payment + $interest__per_payment;

                    $due_date = new \DateTime($request->dateofissue);

                    $due_date = $due_date->modify('+'.$i.' weeks');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }    
            }

            if($request->paymentmode == 'daily'){

                $no_of_payments = $request->period * 30;

                $principal__per_payment = $request->amountgiven / $no_of_payments;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...
                    $interest__per_payment = ($interest_rate/100)*($loan->amount_given - ($i-1)*$principal__per_payment);

                    $amount_per_payment = $principal__per_payment + $interest__per_payment;

                    $due_date = new \DateTime($request->dateofissue);

                    $due_date = $due_date->modify('+'.$i.' days');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
            

        $transaction = new Transaction;
        $transaction->account_id = $id;
        $transaction->transaction_date = Carbon::now()->toDateTimeString();
        $transaction->amount_out = $loan->amount_given;

        $transaction->save();

    	return redirect('/applicant/'.$id)->with('success', 'Loan Created');
        // return redirect('/user/details');
    }
    public function update_loan_to_user(Request $request, $id){
        
        $loan = Loan::find($id);

        $request->validate([
            'amountappliedfor' => 'bail|required|numeric|max:1000000000',
            'amountgiven' => 'bail|required|numeric|max:1000000000',
            'period' => 'bail|required|numeric|max:16',
            'interest' => 'bail|required|numeric',
            'dateofissue' => 'bail|required|date',
            'datewhenaquired' => 'bail|required|date',            
            'paymentmode' => 'required',
            'interestmethod' => 'required'
        ]);

        $applicant_id = $request->session()->get('user_id');
        $loan->applicant_id = $applicant_id;
        $loan->amount_applied_for = $request->amountappliedfor;
        $loan->amount_given = $request->amountgiven;
        $loan->period_in_months = $request->period;
        $loan->interest = $request->interest;
        $loan->due_loan = $request->interest + $request->amountgiven;
        $loan->purpose = $request->purpose;
        $loan->date_when_required = $request->datewhenaquired;
        $loan->date_of_issue = $request->dateofissue;
        $loan->security1 = $request->security1;
        $loan->security1_value = $request->security1_value;
        $loan->security2 = $request->security2;
        $loan->security2_value = $request->security2_value;
        $loan->security3 = $request->security3;
        $loan->security3_value = $request->security3_value;
        $loan->guarantor1_name = $request->guarantor1_name;
        $loan->guarantor1_phone = $request->guarantor1_phone;
        $loan->guarantor2_name = $request->guarantor2_name;
        $loan->guarantor2_phone = $request->guarantor2_phone;
        $loan->payment_mode = $request->paymentmode;
        $loan->interest_method = $request->interestmethod;
        $date_of_completion = $this->determine_date_of_completion($request->dateofissue, $request->period, $request->paymentmode);
        $loan->date_of_completion = $date_of_completion;

        $loan->save();

        $id = $loan->id;

        $old_repayment = LoanRepayment::where('loan_id', $loan->id)->truncate();
        // $old_repayment->delete();

        $loan_repayment = new LoanRepayment;

        if($loan->interest_method == 'flat'){
           if($loan->payment_mode == 'monthly'){
                $no_of_payments = $loan->period_in_months;

                $principal__per_payment = $loan->amount_given / $no_of_payments;

                $interest__per_payment = $loan->interest / $no_of_payments;

                $amount_per_payment = $principal__per_payment + $interest__per_payment;

                for ($i = 1; $i <= $no_of_payments; $i++) { 
                    # code...

                    $due_date = new \DateTime($loan->date_of_issue);

                    $due_date = $due_date->modify('+'.$i.' months');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    // $loan_repayment->save();
                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                }
            }
            if($request->paymentmode == 'weekly'){

                $no_of_payments = $request->period * 4;

                $principal__per_payment = $request->amountgiven / $no_of_payments;

                $interest__per_payment = $request->interest / $no_of_payments;

                $amount_per_payment = $principal__per_payment + $interest__per_payment;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...

                    $due_date = new \DateTime($request->dateofissue);

                    $due_date = $due_date->modify('+'.$i.' weeks');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }    
            }

            if($request->paymentmode == 'daily'){

                $no_of_payments = $request->period * 30;

                $principal__per_payment = $request->amountgiven / $no_of_payments;

                $interest__per_payment = $request->interest / $no_of_payments;

                $amount_per_payment = $principal__per_payment + $interest__per_payment;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...

                    $due_date = new \DateTime($request->dateofissue);

                    $due_date = $due_date->modify('+'.$i.' days');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            } 
        }else{
            $interest_rate = Setting::where('key', 'interest_rate')->value('value');

            if($loan->payment_mode == 'monthly'){
                $no_of_payments = $loan->period_in_months;

                $principal__per_payment = $loan->amount_given / $no_of_payments;

                for ($i = 1; $i <= $no_of_payments; $i++) { 
                    # code...

                    $interest__per_payment = ($interest_rate/100)*($loan->amount_given - ($i-1)*$principal__per_payment);

                    $amount_per_payment = $principal__per_payment + $interest__per_payment;

                    $due_date = new \DateTime($loan->date_of_issue);

                    $due_date = $due_date->modify('+'.$i.' months');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    // $loan_repayment->save();
                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                }
            }
            if($request->paymentmode == 'weekly'){

                $no_of_payments = $request->period * 4;

                $principal__per_payment = $request->amountgiven / $no_of_payments;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...

                    $interest__per_payment = ($interest_rate/100)*($loan->amount_given - ($i-1)*$principal__per_payment);

                    $amount_per_payment = $principal__per_payment + $interest__per_payment;

                    $due_date = new \DateTime($request->dateofissue);

                    $due_date = $due_date->modify('+'.$i.' weeks');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }    
            }

            if($request->paymentmode == 'daily'){

                $no_of_payments = $request->period * 30;

                $principal__per_payment = $request->amountgiven / $no_of_payments;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...
                    $interest__per_payment = ($interest_rate/100)*($loan->amount_given - ($i-1)*$principal__per_payment);

                    $amount_per_payment = $principal__per_payment + $interest__per_payment;

                    $due_date = new \DateTime($request->dateofissue);

                    $due_date = $due_date->modify('+'.$i.' days');

                    $due_date = $due_date->format('Y-m-d');

                    $loan_repayment->loan_id = $loan->id;
                    $loan_repayment->due_date = $due_date;
                    $loan_repayment->principal = $principal__per_payment;
                    $loan_repayment->principal_repaid = 0;
                    $loan_repayment->interest = $interest__per_payment;
                    $loan_repayment->interest_repaid = 0;

                    LoanRepayment::insert([
                        'loan_id' => $loan_repayment->loan_id,
                        'due_date' => $loan_repayment->due_date,
                        'principal' => $loan_repayment->principal,
                        'principal_repaid' => $loan_repayment->principal_repaid,
                        'interest' => $loan_repayment->interest,
                        'interest_repaid' => $loan_repayment->interest_repaid,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
        
        $old_transaction = Transaction::where('account_id', $loan->id)->first();
        $old_transaction->amount_in = $old_transaction->amount_out;
        $old_transaction->save();


        $transaction = new Transaction;
        $transaction->account_id = $id;
        $transaction->transaction_date = Carbon::now()->toDateTimeString();
        $transaction->amount_out = $loan->amount_given;

        $transaction->save();

        return redirect('/applicant/'.$id)->with('success', 'Loan Updated');
        // return redirect('/user/details');
    }
    /**
     * Called when the Calculate button on the New Loan Form is clicked.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function calculate_interest(Request $request){
        # code...
        $interest_rate = Setting::where('key', 'interest_rate')->value('value');

        $principal = $request->amountgiven;
        $period = $request->period;
        $interestmethod = $request->interestmethod;
        $paymentmode = $request->paymentmode;

        $principal__per_payment = $principal / $period;
        $running_interest = 0;

        if($interestmethod == 'flat'){
            $interest = $principal * ($interest_rate/100) * $period;
        }else{
            if($paymentmode == 'weekly'){
                $period = $period * 4;
                $principal__per_payment = $principal / $period;
                for ($i = 1; $i <= $period ; $i++) {
                    $interest__per_payment = ($interest_rate/100)*($principal- ($i-1)*$principal__per_payment);
                    $running_interest += $interest__per_payment;
                }
                $interest = $running_interest;

            }elseif($paymentmode == 'daily'){
                $period = $period * 30;
                $principal__per_payment = $principal / $period;
                for ($i = 1; $i <= $period ; $i++) {
                    $interest__per_payment = ($interest_rate/100)*($principal- ($i-1)*$principal__per_payment);
                    $running_interest += $interest__per_payment;
                }
                $interest = $running_interest;

            }else{
                for ($i = 1; $i <= $period ; $i++) {
                    $interest__per_payment = ($interest_rate/100)*($principal- ($i-1)*$principal__per_payment);
                    $running_interest += $interest__per_payment;
                }
                $interest = $running_interest;
            }
        }

        

        $data = array('interest' => $interest);

        return response()->json($data); 
    }
    /**
     * Called when the Calculate button on the New Loan Form is clicked.
     *
     * @return date
     */
    function determine_date_of_completion($date, $period, $paymentmode){
        # code...
        // Your date
        $date_of_issue = new \DateTime($date); // empty for now or pass any date string as param


        // or even easier
        if($paymentmode == 'monthly'){
            $date_of_completion = $date_of_issue->modify('+'.$period.' months');
            return $date_of_completion->format('Y-m-d');
        }
        if($paymentmode == 'weekly'){
            $period *= 4;
            $date_of_completion = $date_of_issue->modify('+'.$period.' weeks');
            return $date_of_completion->format('Y-m-d');
        }
        if($paymentmode == 'daily'){
            $period *= 30;
            $date_of_completion = $date_of_issue->modify('+'.$period.' days');
            return $date_of_completion->format('Y-m-d');
        }
    }

    function get_loan_schedule($amount_given, $interest, $period, $date_of_issue, $paymentmode, $interestmethod){
        # code...

        $schedule_arr=array();
        
        if($interestmethod == 'flat'){
            if($paymentmode == 'monthly'){
                $no_of_payments = $period;

                $principal__per_payment = $amount_given / $no_of_payments;

                $interest__per_payment = $interest / $no_of_payments;

                $amount_per_payment = $principal__per_payment + $interest__per_payment;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...
                    $balance_per_payment = $amount_given + $interest - $amount_per_payment * $i;

                    $due_date = new \DateTime($date_of_issue);

                    $due_date = $due_date->modify('+'.$i.' months');

                    $due_date = $due_date->format('Y-m-d');

                    $schedule_object = new \stdClass();

                    $schedule_object->no = $i;
                    $schedule_object->principal = $principal__per_payment;
                    $schedule_object->interest = $interest__per_payment;
                    $schedule_object->amount = $amount_per_payment;
                    $schedule_object->balance = $balance_per_payment;
                    $schedule_object->due_date = $due_date;

                    array_push($schedule_arr, $schedule_object);

                }

                // $date_of_completion = end($schedule_arr);

                return $schedule_arr;
            }
            if($paymentmode == 'weekly'){
                $no_of_payments = $period * 4;

                $principal__per_payment = $amount_given / $no_of_payments;

                $interest__per_payment = $interest / $no_of_payments;

                $amount_per_payment = $principal__per_payment + $interest__per_payment;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...
                    $balance_per_payment = $amount_given + $interest - $amount_per_payment * $i;

                    $due_date = new \DateTime($date_of_issue);

                    $due_date = $due_date->modify('+'.$i.' weeks');

                    $due_date = $due_date->format('Y-m-d');

                    $schedule_object = new \stdClass();

                    $schedule_object->no = $i;
                    $schedule_object->principal = $principal__per_payment;
                    $schedule_object->interest = $interest__per_payment;
                    $schedule_object->amount = $amount_per_payment;
                    $schedule_object->balance = $balance_per_payment;
                    $schedule_object->due_date = $due_date;

                    array_push($schedule_arr, $schedule_object);

                }

                // $date_of_completion = end($schedule_arr['due_date']);

                return $schedule_arr;
            }
            if($paymentmode == 'daily'){
                // $no_of_payments = cal_days_in_month(CAL_GREGORIAN, 8, 2003);
                $no_of_payments = $period * 30;

                $principal__per_payment = $amount_given / $no_of_payments;

                $interest__per_payment = $interest / $no_of_payments;

                $amount_per_payment = $principal__per_payment + $interest__per_payment;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...
                    $balance_per_payment = $amount_given + $interest - $amount_per_payment * $i;

                    $due_date = new \DateTime($date_of_issue);

                    $due_date = $due_date->modify('+'.$i.' days');

                    $due_date = $due_date->format('Y-m-d');

                    $schedule_object = new \stdClass();

                    $schedule_object->no = $i;
                    $schedule_object->principal = $principal__per_payment;
                    $schedule_object->interest = $interest__per_payment;
                    $schedule_object->amount = $amount_per_payment;
                    $schedule_object->balance = $balance_per_payment;
                    $schedule_object->due_date = $due_date;

                    array_push($schedule_arr, $schedule_object);

                }

                // $date_of_completion = end($schedule_arr['due_date']);

                return $schedule_arr;
            }
        }else{

            $interest_rate = Setting::where('key', 'interest_rate')->value('value');

            if($paymentmode == 'monthly'){
                $no_of_payments = $period;

                $principal__per_payment = $amount_given / $no_of_payments;

                $balance = $amount_given + $interest;

                // dd($balance);

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...
                    $interest__per_payment = ($interest_rate/100)*($amount_given - ($i-1)*$principal__per_payment);

                    $amount_per_payment = $principal__per_payment + $interest__per_payment;

                    $balance_per_payment = $balance - $amount_per_payment;
                    
                    $balance = $balance_per_payment;

                    $due_date = new \DateTime($date_of_issue);

                    $due_date = $due_date->modify('+'.$i.' months');

                    $due_date = $due_date->format('Y-m-d');

                    $schedule_object = new \stdClass();

                    $schedule_object->no = $i;
                    $schedule_object->principal = $principal__per_payment;
                    $schedule_object->interest = $interest__per_payment;
                    $schedule_object->amount = $amount_per_payment;
                    $schedule_object->balance = $balance_per_payment;
                    $schedule_object->due_date = $due_date;

                    array_push($schedule_arr, $schedule_object);

                }

                // $date_of_completion = end($schedule_arr);

                return $schedule_arr;
            }
            if($paymentmode == 'weekly'){
                $no_of_payments = $period * 4;

                $principal__per_payment = $amount_given / $no_of_payments;

                $balance = $amount_given + $interest;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...

                    $interest__per_payment = ($interest_rate/100)*($amount_given - ($i-1)*$principal__per_payment);

                    $amount_per_payment = $principal__per_payment + $interest__per_payment;

                    $balance_per_payment = $balance - $amount_per_payment;
                    
                    $balance = $balance_per_payment;

                    $due_date = new \DateTime($date_of_issue);

                    $due_date = $due_date->modify('+'.$i.' weeks');

                    $due_date = $due_date->format('Y-m-d');

                    $schedule_object = new \stdClass();

                    $schedule_object->no = $i;
                    $schedule_object->principal = $principal__per_payment;
                    $schedule_object->interest = $interest__per_payment;
                    $schedule_object->amount = $amount_per_payment;
                    $schedule_object->balance = $balance_per_payment;
                    $schedule_object->due_date = $due_date;

                    array_push($schedule_arr, $schedule_object);

                }

                // $date_of_completion = end($schedule_arr['due_date']);

                return $schedule_arr;
            }
            if($paymentmode == 'daily'){
                // $no_of_payments = cal_days_in_month(CAL_GREGORIAN, 8, 2003);
                $no_of_payments = $period * 30;

                $principal__per_payment = $amount_given / $no_of_payments;

                $balance = $amount_given + $interest;

                for ($i = 1; $i <= $no_of_payments ; $i++) { 
                    # code...

                    $interest__per_payment = ($interest_rate/100)*($amount_given - ($i-1)*$principal__per_payment);

                    $amount_per_payment = $principal__per_payment + $interest__per_payment;

                    $balance_per_payment = $balance - $amount_per_payment;
                    
                    $balance = $balance_per_payment;

                    $due_date = new \DateTime($date_of_issue);

                    $due_date = $due_date->modify('+'.$i.' days');

                    $due_date = $due_date->format('Y-m-d');

                    $schedule_object = new \stdClass();

                    $schedule_object->no = $i;
                    $schedule_object->principal = $principal__per_payment;
                    $schedule_object->interest = $interest__per_payment;
                    $schedule_object->amount = $amount_per_payment;
                    $schedule_object->balance = $balance_per_payment;
                    $schedule_object->due_date = $due_date;

                    array_push($schedule_arr, $schedule_object);

                }

                // $date_of_completion = end($schedule_arr['due_date']);

                return $schedule_arr;
            }
        }  
    }
    public function getNewApplicant($id){

        $loan = Loan::find($id);

        $applicant = Applicant::find($loan->applicant_id);

        $schedule = $this->get_loan_schedule($loan->amount_given, $loan->interest, $loan->period_in_months, $loan->date_of_issue, $loan->payment_mode,$loan->interest_method);
        
        // return $applicant;
        // return $loan;
        // return $schedule;

        $user = array('applicant' => $applicant);
        $loan_details = array('loan' => $loan);

        return view('applicant', $user, $loan_details)->with('schedule', $schedule);
    }
    public function getOldApplicant($id){

        $loan = Loan::find($id);

        // get the applicant with this loan
        $applicant = Applicant::find($loan->applicant_id);

        $schedule = LoanRepayment::get()->where('loan_id', $loan->id);
        // $schedule = $this->get_loan_schedule($loan->amount_given, $loan->interest, $loan->period_in_months, $loan->date_of_issue, $loan->payment_mode,$loan->interest_method);
        
        // return $applicant;
        // return $loan;
        // return $schedule;

        $user = array('applicant' => $applicant);
        $loan_details = array('loan' => $loan);

        return view('old_applicant', $user, $loan_details)->with('schedule', $schedule);
    }
    public function getLoans(){
        $loans = loan::leftjoin('applicants', 'loans.applicant_id', '=', 'applicants.id')->get(['loans.*','applicants.first_name','applicants.last_name']);

        // return $loans;

        $data = array('loans' => $loans);

        return view('loans', $data);
    }
    public function getActiveLoans(){
        $loans = loan::leftjoin('applicants', 'loans.applicant_id', '=', 'applicants.id')->where('loans.status', 0)->get(['loans.*','applicants.first_name','applicants.last_name']);

        // return $loans;

        $data = array('loans' => $loans);

        return view('active_loans', $data);
    }
    public function getArrearLoans(){
        $loans = loan::leftjoin('applicants', 'loans.applicant_id', '=', 'applicants.id')->where('loans.status', 0)->where('loans.date_of_completion', '<', Carbon::now()->toDateString())->get(['loans.*','applicants.first_name','applicants.last_name']);

        // return $loans;
        foreach ($loans as $loan) {
            # code...
            $this->getPenalty($loan->id);
        }
        

        $data = array('loans' => $loans);

        return view('arrear_loans', $data);
    }

    public function getPenalty($id){
        # code...
        $loan = Loan::find($id);
        event(new LoanInArrears($loan));
    }
    /**
     * post data to the loanRepayment table/model.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getLoanToRepay($id){
        # code...        
        $loan = Loan::find($id);
        $loan_repayments = LoanRepayment::where('loan_repayments.loan_id', $id)->get();

        // get the applicant with this loan
        $applicant = Applicant::find($loan->applicant_id);

        $total_p = DB::table('loan_repayments')->where('loan_id', $loan->id)->sum('principal');
        $total_i = DB::table('loan_repayments')->where('loan_id', $loan->id)->sum('interest');
        $total_pr = DB::table('loan_repayments')->where('loan_id', $loan->id)->sum('principal_repaid');
        $total_ir = DB::table('loan_repayments')->where('loan_id', $loan->id)->sum('interest_repaid');

        $total = $total_p - $total_pr + $total_i - $total_ir;

        // $loan_repayments = LoanRepayment::find($loan_id);

        $data = array('loan_repayments' => $loan_repayments, 'loan_id' => $id, 'applicant' => $applicant, 'total' => $total);

        return view('repayment', $data)->with('pay', 'Paying Loan')->with('total', $total);
    }
    public function repay(Request $request){
        # code...
        $total_p = DB::table('loan_repayments')->where('loan_id', $request->loan_id)->sum('principal');
        $total_i = DB::table('loan_repayments')->where('loan_id', $request->loan_id)->sum('interest');
        $total_pr = DB::table('loan_repayments')->where('loan_id', $request->loan_id)->sum('principal_repaid');
        $total_ir = DB::table('loan_repayments')->where('loan_id', $request->loan_id)->sum('interest_repaid');

        $total = $total_p - $total_pr + $total_i - $total_ir;

        $request->validate([
            'amount_in' => 'bail|required|numeric|min:0|not_in:0|max:'.round($total,0,PHP_ROUND_HALF_DOWN),
            'repay_date' => 'bail|required'
        ]);

        $loan = Loan::find($request->loan_id);
        $loan->due_loan = $loan->due_loan - $request->amount_in;
        $loan->save();

        session(['amount_in' => $request->amount_in]);

        $running_balance = $request->amount_in;

        $loan_repayments = DB::select('SELECT t.* FROM `loan_repayments` AS t WHERE (SELECT SUM(y.principal - y.principal_repaid + y.interest - y.interest_repaid) FROM `loan_repayments` AS y WHERE y.id <= t.id AND y.loan_id = ?) <= ? AND t.status = 0 AND t.loan_id = ? 
        UNION DISTINCT 
        (SELECT t.* FROM `loan_repayments` AS t WHERE (SELECT SUM(y.principal - y.principal_repaid + y.interest - y.interest_repaid) FROM `loan_repayments` AS y WHERE y.id <= t.id AND y.loan_id = ?) > ? AND t.status = 0 AND t.loan_id = ? LIMIT 1)',[$request->loan_id, $request->amount_in,$request->loan_id,$request->loan_id, $request->amount_in,$request->loan_id]); 

        // dd($loan_repayments);
        foreach($loan_repayments as $loan_repayment){
            $loan_repay_model = LoanRepayment::find($loan_repayment->id);
            // $count++;
            $interest_balance = $loan_repay_model->interest - $loan_repay_model->interest_repaid;

            $transaction = new Transaction;

            if($interest_balance > 0){ //have to pay interest due
                if($interest_balance >= $running_balance){ 
                    $loan_repay_model->interest_repaid += $running_balance; //pay interest
                    $loan_repay_model->date_repaid = $request->repay_date;
                    $running_balance = 0;
                    $loan_repay_model->save(); // and retrn to view

                    $transaction->account_id = $loan_repayment->loan_id;
                    $transaction->transaction_date = Carbon::now()->toDateTimeString();
                    $transaction->amount_in = $loan_repay_model->interest_repaid;
                    $transaction->save();
                }else{
                    $loan_repay_model->interest_repaid += $interest_balance;
                    $running_balance -= $interest_balance; // so there's some excess

                    $principal_balance = $loan_repay_model->principal - $loan_repay_model->principal_repaid;
                    if($principal_balance > 0){ 
                        if($principal_balance == $running_balance){ //clear the balance
                            $loan_repay_model->principal_repaid += $running_balance;
                            $loan_repay_model->status = 1;
                            $loan_repay_model->date_repaid = $request->repay_date;
                            $running_balance = 0;
                            $loan_repay_model->save(); // and retrn to view

                            $transaction->account_id = $loan_repayment->loan_id;
                            $transaction->transaction_date = Carbon::now()->toDateTimeString();
                            $transaction->amount_in = $loan_repay_model->principal_repaid + $loan_repay_model->interest_repaid;
                            $transaction->save();
                        }elseif($principal_balance > $running_balance){
                            $loan_repay_model->principal_repaid += $running_balance;
                            $loan_repay_model->date_repaid = $request->repay_date;
                            $running_balance = 0;
                            $loan_repay_model->save(); // and retrn to view

                            $transaction->account_id = $loan_repayment->loan_id;
                            $transaction->transaction_date = Carbon::now()->toDateTimeString();
                            $transaction->amount_in = $loan_repay_model->principal_repaid + $loan_repay_model->interest_repaid;
                            $transaction->save();
                        }
                        else{ // excess therefore overflows to the next repayment
                            $loan_repay_model->principal_repaid += $principal_balance;
                            $loan_repay_model->date_repaid = $request->repay_date;
                            $loan_repay_model->status = 1;
                            $running_balance -= $principal_balance;
                            $loan_repay_model->save();

                            $transaction->account_id = $loan_repayment->loan_id;
                            $transaction->transaction_date = Carbon::now()->toDateTimeString();
                            $transaction->amount_in = $loan_repay_model->principal_repaid + $loan_repay_model->interest_repaid;
                            $transaction->save();
                        }
                    }
                }
            }
            if($interest_balance == 0){         

                    $principal_balance = $loan_repay_model->principal - $loan_repay_model->principal_repaid;
                    if($principal_balance > 0){
                        if($principal_balance == $running_balance){
                            $loan_repay_model->principal_repaid += $running_balance;
                            $loan_repay_model->status = 1;
                            $loan_repay_model->date_repaid = $request->repay_date;
                            $running_balance = 0;
                            $loan_repay_model->save(); // and retrn to view

                            $transaction->account_id = $loan_repayment->loan_id;
                            $transaction->transaction_date = Carbon::now()->toDateTimeString();
                            $transaction->amount_in = $loan_repay_model->principal_repaid;
                            $transaction->save();
                        }elseif($principal_balance > $running_balance){
                            $loan_repay_model->principal_repaid += $running_balance;
                            $loan_repay_model->date_repaid = $request->repay_date;
                            $running_balance = 0;
                            $loan_repay_model->save(); // and retrn to view

                            $transaction->account_id = $loan_repayment->loan_id;
                            $transaction->transaction_date = Carbon::now()->toDateTimeString();
                            $transaction->amount_in = $loan_repay_model->principal_repaid;
                            $transaction->save();
                        }
                        else{ // excess therefore overflows to the next repayment
                            $loan_repay_model->principal_repaid += $principal_balance;
                            $loan_repay_model->status = 1;
                            $loan_repay_model->date_repaid = $request->repay_date;
                            $running_balance -= $principal_balance;
                            $loan_repay_model->save();

                            $transaction->account_id = $loan_repayment->loan_id;
                            $transaction->transaction_date = Carbon::now()->toDateTimeString();
                            $transaction->amount_in = $loan_repay_model->principal_repaid;
                            $transaction->save();
                        }
                    }        
            }
        }

        $last_repayment=DB::table('loan_repayments')->orderBy('id', 'DESC')->where('loan_id', $request->loan_id)->first();

        if($last_repayment->status == 1){
            $loan_to_clear = Loan::where('id', $request->loan_id)->first();

            $loan_to_clear->status = 1;
            $loan_to_clear->save();
        }

        return redirect('repayment/'.$loan_repay_model->loan_id)->with('success', 'Repaid');
    }
    public function getApplicantPDF(Request $request, $id){
        # code...
        $applicant = Applicant::findOrFail($id);

        $loan = Loan::find($id);

        $schedule = $this->get_loan_schedule($loan->amount_given, $loan->interest, $loan->period_in_months, $loan->date_of_issue, $loan->payment_mode,$loan->interest_method);

        $pdf = PDF::setOptions(['defaultMediaType' => 'print', 'isRemoteEnabled' => true])->loadView('applicant', array('applicant' => $applicant, 'loan' => $loan, 'schedule' => $schedule))->setPaper('legal', 'portrait');

        // $pdf = PDF::setOption('margin-bottom', 0)->loadView('applicant', array('applicant' => $applicant, 'loan' => $loan, 'schedule' => $schedule))->setPaper('a4');

        // $pdf->setOptions('defaultMediaType', 'print')

        return $pdf->stream();
    }
    public function getOldApplicantPDF(Request $request, $id){
        # code...
        $applicant = Applicant::findOrFail($id);

        $loan = Loan::find($id);

        $schedule = LoanRepayment::get()->where('loan_id', $loan->id);

        $pdf = PDF::setOptions(['defaultMediaType' => 'print', 'isRemoteEnabled' => true])->loadView('old_applicant', array('applicant' => $applicant, 'loan' => $loan, 'schedule' => $schedule))->setPaper('legal', 'portrait');

        // $pdf = PDF::setOption('margin-bottom', 0)->loadView('old_applicant', array('applicant' => $applicant, 'loan' => $loan, 'schedule' => $schedule))->setPaper('a4');

        // $pdf->setOptions('defaultMediaType', 'print')

        return $pdf->stream();
    }
    public function printLoans($value=''){
        # code...
        $loans = loan::leftjoin('applicants', 'loans.applicant_id', '=', 'applicants.id')->get();

        // return $loans;

        $data = array('loans' => $loans);

        $pdf = PDF::setOptions(['defaultMediaType' => 'print', 'isRemoteEnabled' => true])->loadView('loans', $data)->setPaper('legal', 'portrait');

        return $pdf->stream();
    }
    public function saveLoans($value=''){
        # code...
        $loans = loan::leftjoin('applicants', 'loans.applicant_id', '=', 'applicants.id')->get();

        // return $loans;

        $data = array('loans' => $loans);

        $pdf = PDF::setOptions(['defaultMediaType' => 'print', 'isRemoteEnabled' => true])->loadView('loans', $data)->setPaper('legal', 'portrait');

        return $pdf->download('loans.pdf');
    }
    public function printActiveLoans($value=''){
        # code...
        $loans = loan::leftjoin('applicants', 'loans.applicant_id', '=', 'applicants.id')->where('loans.status', 0)->get();

        // return $loans;

        $pdf = PDF::setOptions(['defaultMediaType' => 'print', 'isRemoteEnabled' => true])->loadView('active_loans', array( 'loans'=>$loans))->setPaper('legal', 'portrait');

        return $pdf->stream();
    }
    public function saveActiveLoans($value=''){
        # code...
        # code...
        $loans = loan::leftjoin('applicants', 'loans.applicant_id', '=', 'applicants.id')->where('loans.status', 0)->get();

        // return $loans;

        $pdf = PDF::setOptions(['defaultMediaType' => 'print', 'isRemoteEnabled' => true])->loadView('active_loans', array( 'loans'=>$loans))->setPaper('legal', 'portrait');

        return $pdf->download('active_loans.pdf');
    }
    public function printArrearLoans($value=''){
        # code...
        $loans = loan::leftjoin('applicants', 'loans.applicant_id', '=', 'applicants.id')->where('loans.status', 0)->where('loans.date_of_completion', '<', Carbon::now()->toDateString())->get();

        // return $loans;

        $data = array('loans' => $loans);

        $pdf = PDF::setOptions(['defaultMediaType' => 'print', 'isRemoteEnabled' => true])->loadView('arrear_loans', $data)->setPaper('legal', 'portrait');

        return $pdf->stream();
    }
    public function saveArrearLoans($value=''){
        # code...
        $loans = loan::leftjoin('applicants', 'loans.applicant_id', '=', 'applicants.id')->where('loans.status', 0)->where('loans.date_of_completion', '<', Carbon::now()->toDateString())->get();

        // return $loans;

        $data = array('loans' => $loans);

        $pdf = PDF::setOptions(['defaultMediaType' => 'print', 'isRemoteEnabled' => true])->loadView('arrear_loans', $data)->setPaper('legal', 'portrait');

        return $pdf->download('arrear_loans.pdf');
    }
    public function printRepayment($id){
        # code...
        # code...
        $applicant = Applicant::find($id);
        $loan = Loan::find($id);
        $loan_repayments = LoanRepayment::where('loan_repayments.loan_id', $id)->get();

        $total_p = DB::table('loan_repayments')->where('loan_id', $loan->id)->sum('principal');
        $total_i = DB::table('loan_repayments')->where('loan_id', $loan->id)->sum('interest');
        $total_pr = DB::table('loan_repayments')->where('loan_id', $loan->id)->sum('principal_repaid');
        $total_ir = DB::table('loan_repayments')->where('loan_id', $loan->id)->sum('interest_repaid');

        $total = $total_p - $total_pr + $total_i - $total_ir;

        // $loan_repayments = LoanRepayment::find($loan_id);

        $data = array('loan_repayments' => $loan_repayments, 'loan_id' => $id, 'applicant' => $applicant, 'total' => $total);

        $pdf = PDF::setOptions(['defaultMediaType' => 'print', 'isRemoteEnabled' => true])->loadView('repayment', $data)->setPaper('legal', 'portrait');

        return $pdf->stream();
    }
}

