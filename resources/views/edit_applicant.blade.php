@extends('layout.app')

@section('title','Edit Applicant')

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
	        <!-- page start-->
            <div class="row">
                <div class="col-md-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li><a href="{{URL::to('/')}}/"><i class="fa fa-home"></i> Dashboard</a></li>
                        <li><a href="{{URL::to('/')}}/member/details/{{ $applicant->id }}">Details</a></li>
                        <li class="active">Edit</li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            <!-- include messages div -->
                @include('includes.messages')
            <!-- messages end -->
	        <div class="row">
	            <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit <span style="color: red">{{$applicant->first_name}} {{$applicant->last_name}}'s</span> Details
                            <span class="tools pull-right">
                                <a class="fa fa-chevron-down" href="javascript:;"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <form class="cmxform form-horizontal "  id="signupForm"  method="post" action="{{URL::to('/')}}/applicant/edit/{{$applicant->id}}" enctype="multipart/form-data">
                                    @csrf
                                    {{ method_field('PUT')}}
                                    <input class=" form-control" id="id" name="id" type="hidden" value="{{$applicant->id}}" />
                                    <div class="form-group ">
                                        <label for="firstname" class="control-label col-lg-3">First Name</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="firstname" name="firstname" type="text" value="{{$applicant->first_name}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Last Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{$applicant->last_name}}" name="lastname">
                                        </div>
                                	</div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Other Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{$applicant->other_name}}" name="othername">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Phone</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Telephone" value="{{$applicant->phone}}" name="telephone" id="telephone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Email</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Email" value="{{$applicant->email}}" name="email" id="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Residential Address</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{$applicant->residential_address}}" name="residentialaddress">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Bussiness Location</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{$applicant->business_location}}" name="businessaddress">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Photo</label>
                                        <div class="col-lg-8">
                                        	<div class="fileupload fileupload-new" data-provides="fileupload">
                                        		<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
		                                            <img src="{{ asset('assets/images/no+image.png') }}" alt="" />
		                                        </div>
		                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
		                                        </div>
		                                        <div>
                                                   <span class="btn btn-white btn-file">
                                                   	<span class="fileupload-new" ><i class="fa fa-paper-clip"></i> Select image</span>
                                                   	<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                   	<input type="file" class="default" name="photo" />
		                                           </span>
		                                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
		                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">National ID Scan</label>
                                        <div class="col-lg-8">
                                        	<div class="fileupload fileupload-new" data-provides="fileupload">
                                        		<span class="btn btn-white btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                <input type="file" class="default" name="nationalid"/>
                                                </span>
		                                        <span class="fileupload-preview" style="margin-left:5px;"></span>
		                                        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Gender</label>
                                        <div >	
		                                    <input type="radio" name="gender" id="gender" value="female" {{ $applicant->gender == 'female' ? 'checked' : '' }} >
		                                    Female	
			                            </div>
			                            <div >	
		                                    <input type="radio" name="gender" id="gender" value="male" {{ $applicant->gender == 'male' ? 'checked' : '' }} >
		                                    Male	
			                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Date of Birth</label>
                                        <div class="col-lg-8">
                                        	<div class="input-group">
                                            	<input type="text" class="default-date-picker form-control" placeholder="Date of Birth" name="dateofbirth" readonly="" size="110" value="{{$applicant->date_of_birth}}">
                                            	<div class="input-group-btn">
		                                            <!-- <button type="button" class="btn btn-primary"><i class="fa fa-times"></i></button>
		                                            <button type="button" class="btn btn-warning date-set"><i class="fa fa-calendar"></i></button> -->
		                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Group</label>
                                        <div class="col-lg-8">
                                            <select id="group" style="width:100%" class="populate placeholder" name="group">
                                                @if(old('group_id',$applicant->group_id)=="")
                                                    <option selected value="">Select Group</option>
                                                @endif
                                                @foreach($groups as $group)
                                                    <option value="{{ $group->id }}" @if(old('group_id',$applicant->group_id)==$group->id) selected @endif>{{ $group->name }}</option>
                                                @endforeach
                                            </select>
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
<script src="{{URL::asset('assets/js/validation-init.js?v=1.3')}}"></script>
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

    $('#group').select2();

    // $.validator.setDefaults({
    //     submitHandler: function() { $("#enrollForm").submit(); }
    // });

    $().ready(function() {
        // validate the comment form when it is submitted
        //$("#commentForm").validate();

               
       
    });

}();
</script>
@endsection