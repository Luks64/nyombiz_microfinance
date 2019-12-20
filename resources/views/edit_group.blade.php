@extends('layout.app')

@section('title','Edit Group')

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

    <!--icheck-->
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/minimal/minimal.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/minimal/red.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/minimal/green.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/minimal/blue.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/minimal/yellow.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/minimal/purple.css')}}">

    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/square/square.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/square/red.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/square/green.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/square/blue.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/square/yellow.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/square/purple.css')}}">

    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/flat/grey.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/flat/red.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/flat/green.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/flat/blue.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/flat/yellow.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/iCheck/skins/flat/purple.css')}}">
@endsection

@section('body')

        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li><a href="{{URL::to('/')}}/"><i class="fa fa-home"></i> Dashboard</a></li>
                        <li><a href="{{URL::to('/')}}/group/details/{{ $group->id }}">{{ $group->name }}</a></li>
                        <li class="active">Edit</li>
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
                            Edit Group Details
                            <span class="tools pull-right">
                                <a class="fa fa-chevron-down" href="javascript:;"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <form class="cmxform form-horizontal"  id="signupForm"  method="post" action="{{URL::to('/')}}/group/edit" enctype="multipart/form-data">
                                    @csrf
                                    {{ method_field('PUT')}}
                                    <input type="hidden" name="id" value="{{ $group->id }}">
                                    <div class="form-group ">
                                        <label for="group_no" class="control-label col-lg-3">Group No.</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="group_no" name="group_no" type="text" placeholder="Unique Number" value="{{ $group->group_no }}" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="groupname" class="control-label col-lg-3">Name</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="groupname" name="groupname" type="text" placeholder="Name of Group" value="{{ $group->name }}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Location</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Location" name="location" id="location" value="{{ $group->location }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Meeting Day</label>
                                        <div class="col-lg-8">
                                            <select id="meeting_day" style="width:100%" class="populate placeholder" name="meeting_day">                                               
                                                <option value="sunday" @if(old('meeting_day',$group->meeting_day)=="sunday") selected @endif>Sunday</option>
                                                <option value="monday" @if(old('meeting_day',$group->meeting_day)=="monday") selected @endif>Monday</option>
                                                <option value="tuesday" @if(old('meeting_day',$group->meeting_day)=="tuesday") selected @endif>Tuesday</option>
                                                <option value="wednesday" @if(old('meeting_day',$group->meeting_day)=="wednesday") selected @endif>Wednesday</option>
                                                <option value="thursday" @if(old('meeting_day',$group->meeting_day)=="thursday") selected @endif>Thursday</option>
                                                <option value="friday" @if(old('meeting_day',$group->meeting_day)=="friday") selected @endif>Friday</option>
                                                <option value="saturday" @if(old('meeting_day',$group->meeting_day)=="saturday") selected @endif>Saturday</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Meeting Frequency</label>
                                        <div class="col-lg-8">
                                            <select id="frequency" style="width:100%" class="populate placeholder" name="frequency">
                                                <option value="weekly" @if(old('meeting_frequency',$group->meeting_frequency)=="weekly") selected @endif>Weekly</option>
                                                <option value="bi-weekly" @if(old('meeting_frequency',$group->meeting_frequency)=="bi-weekly") selected @endif>Bi-Weekly</option>
                                                <option value="monthly" @if(old('meeting_frequency',$group->meeting_frequency)=="monthly") selected @endif>Monthly</option>
                                            </select>
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Activity</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Activity" name="activity" value="{{ $group->activity }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Date of Created</label>
                                        <div class="col-md-4 col-xs-11">                                            
                                            <input type="text" class="default-date-picker form-control" placeholder="Date of Creation" name="dateofcreation" id="dateofcreation" readonly size="16" value="{{ $group->creation_date }}">
                                            <div class="input-group-btn">
                                                <!-- <button type="button" class="btn btn-primary"><i class="fa fa-times"></i></button>
                                                <button type="button" class="btn btn-warning date-set"><i class="fa fa-calendar"></i></button> -->
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Officer</label>
                                        <div class="col-lg-8">
                                            <select id="officer" style="width:100%" class="populate placeholder" name="officer">
                                                @if(old('employee_id',$group->employee_id)=="")  
                                                    <option selected value="">Select Officer</option>
                                                @endif>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}" @if(old('employee_id',$group->employee_id)==$employee->id) selected @endif>{{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Is Active?</label>

                                        <div class="col-sm-9 icheck ">                                            

                                            <div class="square-green single-row">
                                                <div class="checkbox ">
                                                    <input type="checkbox" name="is_active" value="{{ $group->is_active }}" @if ($group->is_active == 1) checked="checked" @endif>
                                                    <label>Activate/Deactivate </label>
                                                </div>
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
<!-- <script src="{{URL::asset('assets/js/validation-init.js?v=1')}}"></script> -->
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
<script src="{{URL::asset('assets/js/iCheck/jquery.icheck.js')}}"></script>
<script src="{{URL::asset('assets/js/icheck-init.js')}}"></script>

<script type="text/javascript">
    var PageScript = function () {

    $('#meeting_day').select2();
    $('#frequency').select2();
    $('#officer').select2();

    $.validator.setDefaults({
        submitHandler: function() { $("#signupForm").submit(); }
    });

    $().ready(function() {
        // validate the comment form when it is submitted
        //$("#commentForm").validate();

        // validate enroll form on keyup and submit
        $("#signupForm").validate({
            rules: {
                groupname: "required",
                Location: "required",
                frequency: "required",
                dateofcreation: "required",
                meeting_day: "required",
                groupname: {
                    required: true,
                    minlength: 2
                },
                location: {
                    required: true,
                    minlength: 2
                }           
            },
            messages: {
                groupname: {
                    required: "Please enter a Group Name",
                    minlength: "Group Name must consist of at least 2 characters"
                },
                location: {
                    required: "Please enter a Location",
                    minlength: "Location must consist of at least 2 characters"
                },
                frequency: "Meeting Frequency is required"
            }
        });    
       
    });

}();
</script>
@endsection