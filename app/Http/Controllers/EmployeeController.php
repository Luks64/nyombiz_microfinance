<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Applicant, Loan, Setting, Employee,Group};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class EmployeeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    //
    public function employees($value='')
    {
    	# code...
    	// $employees = Employee::get();
        $employees = DB::select('SELECT employees.*,(SELECT COUNT(id) FROM groups where groups.employee_id = employees.id) as groups FROM employees');

    	$data = array('employees'=>$employees);

    	return view('employees', $data);
    }

    public function employee($id='')
    {
        # code...
        $employee = Employee::find($id);

        $groups = Group::where('employee_id',$id)->get();

        $data = array('employee'=>$employee, 'groups'=>$groups);

        return view('employee', $data);
    }

    public function register_employee($value='')
    {
    	# code...
    	return view('new_employee');
    }

    public function edit($id='')
    {
        $employee = Employee::find($id);

        $data = array('employee'=>$employee);
       
        return view('edit_employee', $data);
    }

    // Insert or Update
    public function save(Request $request)
    {
    	$request->validate([
            'employee_no' => 'required',
            'name' => 'required',
            'position' => 'required',
            'residentialaddress' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'status' => 'required',
            'dateofbirth' => 'required',
            'startdate' => 'required'
        ]);

    	$employee = new Employee;

        if(isset($request->id)) // If id is given update the existing record
        {
            if(Employee::find($request->id))
            {
                $employee = Employee::find($request->id);
            }else{
                throw new Exception("Out of Range");
            }
        }

        $employee->employee_no = $request->employee_no;
        $employee->name = $request->name;
        $employee->gender = $request->gender;
        $employee->marital_status = $request->status;
        $employee->position = $request->position;
        $employee->monthly_salary  = $request->salary;
        $employee->residence = $request->residentialaddress;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->birth_date = $request->dateofbirth;
        $employee->start_date = $request->startdate;

        $employee->save();
    	
        return redirect('/employee/details/'.$employee->id)->with('status','Employee Save Successfully');
    }
}
