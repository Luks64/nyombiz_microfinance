@extends('layout.app')

@section('title','New Group')

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
                        <li><a href="{{URL::to('/')}}/groups">Groups</a></li>
                        <li class="active">New Group</li>
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
                            New Group
                            <span class="tools pull-right">
                                <a class="fa fa-chevron-down" href="javascript:;"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <form class="cmxform form-horizontal"  id="signupForm"  method="post" action="{{URL::to('/')}}/group/new" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group ">
                                        <label for="group_no" class="control-label col-lg-3">Group No.</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="group_no" name="group_no" type="text" placeholder="Unique Number"/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="groupname" class="control-label col-lg-3">Name</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="groupname" name="groupname" type="text" placeholder="Name of Group"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Location</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Location" name="location" id="location">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Meeting Day</label>
                                        <div class="col-lg-8">
                                            <select id="meeting_day" style="width:100%" class="populate placeholder" name="meeting_day">
                                                <option selected value="">Select Day</option>
                                                <option value="sunday">Sunday</option>
                                                <option value="monday">Monday</option>
                                                <option value="tuesday">Tuesday</option>
                                                <option value="wednesday">Wednesday</option>
                                                <option value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option value="saturday">Saturday</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Meeting Frequency</label>
                                        <div class="col-lg-8">
                                            <select id="frequency" style="width:100%" class="populate placeholder" name="frequency">
                                                <option selected value="">How Frequent</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="bi-weekly">Bi-Weekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Activity</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Activity" name="activity">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Date of Created</label>
                                        <div class="col-md-4 col-xs-11">                                            
                                            <input type="text" class="default-date-picker form-control" placeholder="Date of Creation" name="dateofcreation" id="dateofcreation" readonly size="16" >
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
                                                <option selected value="">Select Officer</option>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                    <input type="hidden" name="is_active" value="1">
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