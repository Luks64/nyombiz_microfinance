@extends('layout.app')

@section('title','Edit Employee')

@section('page_styles')
	<link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap-switch.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-fileupload/bootstrap-fileupload.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-datepicker/css/datepicker.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-timepicker/compiled/timepicker.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-colorpicker/css/colorpicker.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-daterangepicker/daterangepicker-bs3.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-datetimepicker/css/datetimepicker.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/jquery-multi-select/css/multi-select.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/jquery-tags-input/jquery.tagsinput.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/select2/select2.css')}}">
@endsection

@section('body')

       <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li><a href="{{URL::to('/')}}/"><i class="fa fa-home"></i> Dashboard</a></li>
                        <li><a href="{{URL::to('/')}}/employee/{{ $employee->id }}">Details</a></li>
                        <li class="active">Edit Employee</li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>            
            <!-- page start-->
            <!-- include messages div -->
                @include('includes.messages')
            <!-- messages end -->
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Employee Details
                            <span class="tools pull-right">
                                <a class="fa fa-chevron-down" href="javascript:;"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <form class="cmxform form-horizontal "  id="enrollForm"  method="post" action="{{URL::to('/')}}/employee/edit" enctype="multipart/form-data">
                                    @csrf
                                    {{ method_field('PUT')}}
                                    <input type="hidden" name="id" value="{{ $employee->id }}">
                                    <div class="form-group ">
                                        <label for="firstname" class="control-label col-lg-3">Employee No</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="employee_no" name="employee_no" type="text" placeholder="Employee's No" value="{{ $employee->employee_no }}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Employee's Name" id="name" name="name" value="{{ $employee->name }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Position</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Job Position" id="position" name="position" value="{{ $employee->position }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Salary</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Salary" id="salary" name="salary" value="{{ $employee->monthly_salary }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Residential Address</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Residential Address" name="residentialaddress" id="residentialaddress" value="{{ $employee->residence }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Phone</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Telephone" name="phone" id="phone" value="{{ $employee->phone }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Email</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Email" name="email" id="email" value="{{ $employee->email }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Gender</label>
                                        <div >      
                                            <input type="radio" name="gender" id="gender" value="female" @if(old('gender',$employee->gender)=="female") checked @endif>
                                            Female  
                                        </div>
                                        <div >  
                                            <input type="radio" name="gender" id="gender" value="male" @if(old('gender',$employee->gender)=="male") checked @endif>
                                            Male    
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Marital Status</label>
                                        <div class="col-lg-8">
                                            <select id="status" style="width:100%" class="populate placeholder" name="status" id="status">
                                                <option @if(old('status',$employee->status)=="single") selected @endif value="single">Single</option>
                                                <option @if(old('status',$employee->status)=="married") selected @endif value="married">Married</option>
                                                <option @if(old('status',$employee->status)=="divorced") selected @endif value="divorced">Divorced</option>
                                                <option @if(old('status',$employee->status)=="widowed") selected @endif value="widowed">Widowed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Date Enrolled</label>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" name="startdate" value="{{ $employee->start_date }}" id="startdate" readonly />
                                            <span class="help-block">Select date</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Date of Birth</label>
                                        <div class="col-md-4 col-xs-11">                                            
                                            <input type="text" class="default-date-picker form-control" placeholder="Date of Birth" name="dateofbirth" id="dateofbirth" readonly size="16" value="{{ $employee->birth_date }}">
                                            <div class="input-group-btn">
                                                <!-- <button type="button" class="btn btn-primary"><i class="fa fa-times"></i></button>
                                                <button type="button" class="btn btn-warning date-set"><i class="fa fa-calendar"></i></button> -->
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-primary" type="submit">Save</button>
                                            <!-- <button class="btn btn-default" type="button">Cancel</button> -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- page end-->
        </section>

    <!--main content end-->
@endsection

@section('page_script')
<!-- <script src="{{URL::asset('assets/js/easypiechart/jquery.easypiechart.js')}}"></script>
<script src="{{URL::asset('assets/js/sparkline/jquery.sparkline.js')}}"></script>
<script src="{{URL::asset('assets/js/flot-chart/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/js/flot-chart/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{URL::asset('assets/js/flot-chart/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/js/flot-chart/jquery.flot.pie.resize.js')}}"></script> -->
<script src="{{URL::asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{URL::asset('assets/js/validation-init.js?v=1')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-switch.js')}}"></script>
<script src="{{URL::asset('assets/js/fuelux/js/spinner.min.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-daterangepicker/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-multi-select/js/jquery.quicksearch.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-tags-input/jquery.tagsinput.js')}}"></script>
<script src="{{URL::asset('assets/js/select2/select2.js')}}"></script>
<!-- <script src="{{URL::asset('assets/js/toggle-init.js')}}"></script> -->
<script src="{{URL::asset('assets/js/advanced-form.js')}}"></script>

<script type="text/javascript">
    var PageScript = function () {

    $('#status').select2();

    $.validator.setDefaults({
        submitHandler: function() { $("#enrollForm").submit(); }
    });

    $().ready(function() {
        // validate the comment form when it is submitted
        //$("#commentForm").validate();

        // validate enroll form on keyup and submit
        $("#enrollForm").validate({
            rules: {
                employee_no: "required",
                name: "required",
                gender: "required",
                position: "required",
                residentialaddress: "required",
                dateofbirth: "required",
                startdate: "required",  
                status: "required", 
                phone: "required",   
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                salary: {
                    number: true
                }             
            },
            messages: {
                employee_no: "Please enter employee code",
                name: "Please enter employee name",
                name: {
                    required: "Please enter a username",
                    minlength: "Your username must consist of at least 2 characters"
                },
                email: "Please enter a valid email address",
                status: "Please choose status",
                phone: "Please enter phone number",
                salary: {
                    number: "Must be a number"
                } 
            }
        });        
       
    });

}();
</script>
@endsection