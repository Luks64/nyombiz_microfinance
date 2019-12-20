<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Applicant, Loan, Setting, Schedule, LoanRepayment, Transaction, Group};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class MembersController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }
    //
    public function members($value='')
    {
    	# code...
    	$members = Applicant::leftjoin('groups','groups.id','=','applicants.group_id')->get(['groups.name AS group', 'applicants.*']);

    	$data = array('members'=>$members);

    	return view('members', $data);
    }

    public function member($id='')
    {
        # code...
        $member = Applicant::leftjoin('groups','groups.id','applicants.group_id')->where('applicants.id',$id)->get(['applicants.*','groups.name AS group'])->first();

        $active_loan = Loan::where('applicant_id',$id)->where('status',0)->get()->first();

        $data = array('member'=>$member,'active_loan'=>$active_loan);

        return view('member', $data);
    }

    public function register_member(){
        # code...
        $groups = Group::get();

        $data = array('groups'=>$groups);

        return view('new_applicant', $data);
    }

    public function edit($id)
    {
        $applicant = Applicant::find($id);

        $groups = Group::get();

        $data = ['applicant' => $applicant, 'groups'=>$groups];

        return view('edit_applicant', $data);
    }

    public function save(Request $request, $id='') // save new and edits
    {
        //dd('We are here');
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'telephone' => 'required',
            'photo' => 'bail|image|nullable|max:1999',
            'nationalid' => 'bail|image|nullable|max:1999',
            'gender' => 'required'
        ]);

        $applicant = new Applicant;
        $success_msg = 'Member Created';

        if(isset($request->id)) // If id is given update the existing record
        {
            if(Applicant::find($request->id))
            {
                $applicant = Applicant::find($request->id);
                $success_msg = 'Member Updated';
            }else{
                throw new Exception("Out of Range");
            }
        }

        if($request->hasFile('photo')){
            // use laravel to get the name with its extension
            $photoNameWithExt = $request->file('photo')->getClientOriginalName();
            // use php to get just the name without extension
            $photoName = pathinfo($photoNameWithExt, PATHINFO_FILENAME); 
            // use laravel to get just the extension
            $photoExtension = $request->file('photo')->getClientOriginalExtension();
            // actual name to go to the databasae
            $photoNameToStore = $photoName.'-'.time().'.'.$photoExtension;
            // upload the image to public/photos under the storage/app
            $photoPath = $request->file('photo')->storeAs('public/photos', $photoNameToStore);

        }else{
            $photoNameToStore= 'noimage.jpg';
        }

        if($request->hasFile('nationalid')){
            // use laravel to get the name with its extension
            $nationalidNameWithExt = $request->file('nationalid')->getClientOriginalName();
            // use php to get just the name without extension
            $nationalIdname = pathinfo($nationalidNameWithExt, PATHINFO_FILENAME);
            // use laravel to get just the extension
            $nationalIdExtension = $request->file('nationalid')->getClientOriginalExtension();
            // actual name to go to the databasae
            $nationalIdnameToStore = $nationalIdname.'-'.time().'.'.$nationalIdExtension;
            // upload the image to public/nationalIds under the storage/app
            $nationalIdPath = $request->file('nationalid')->storeAs('public/nationalIds', $nationalIdnameToStore);

        }else{
            $nationalIdnameToStore = 'noimage.jpg';
        }

        

        $applicant->first_name = $request->firstname;
        $applicant->last_name = $request->lastname;
        $applicant->other_name = $request->othername;
        $applicant->residential_address = $request->residentialaddress;
        $applicant->email = $request->email;
        $applicant->phone = $request->telephone;
        $applicant->business_location = $request->businessaddress;
        $applicant->photo = $photoNameToStore;
        $applicant->nationalid_scan = $nationalIdnameToStore;
        $applicant->gender = $request->gender;
        $applicant->date_of_birth = $request->dateofbirth;
        $applicant->group_id = $request->group;

        $applicant->save();

        $id = $applicant->id;

        return redirect('member/details/'.$id)->with('success', $success_msg);
    }

    public function delete($id='')
    {
        //Get members group_id to redirect later
        $group_id = Applicant::where('id', $id)->value('group_id');
        DB::delete('DELETE FROM applicants WHERE id = ?', [$id]);

        // Get all loans by this applicant
        $loans = loan::join('applicants', 'loans.applicant_id', '=', 'applicants.id')->where('applicants.id',$id)->pluck('loans.id')->toArray();
        
        //clear loans an and repayments
        DB::delete('DELETE FROM loans WHERE id IN ?', [$loans]);
        DB::delete('DELETE FROM loan_repayments WHERE loan_id IN ?', [$loans]);
           

        // Redirect to GroupController@group($id='')
        return redirect()->action('GroupController@group',['id' => $group_id]);
    }
}
