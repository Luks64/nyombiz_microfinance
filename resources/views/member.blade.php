@extends('layout.app')

@section('title','Member')

@section('page_styles')
	<!-- <link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap-switch.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-fileupload/bootstrap-fileupload.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-datepicker/css/datepicker.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-timepicker/compiled/timepicker.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-colorpicker/css/colorpicker.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-daterangepicker/daterangepicker-bs3.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-datetimepicker/css/datetimepicker.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/jquery-multi-select/css/multi-select.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/jquery-tags-input/jquery.tagsinput.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/select2/select2.css')}}"> -->
@endsection

@section('body')
	<section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-md-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li><a href="{{URL::to('/')}}/"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li><a href="{{URL::to('/')}}/members">Members</a></li>
                    <li class="active">{{ $member->first_name }} {{ $member->last_name }}</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>  

        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body profile-information">
                       <div class="col-md-3">
                           <div class="profile-pic text-center">
                               <img src="{{URL::asset('assets/images/no-avatar2.jpg')}}" alt=""/>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="profile-desk">
                               <h1>{{ $member->first_name }} {{ $member->last_name }} {{ $member->other_name }}</h1>
                               <span class="text-muted" style="display:block;">Group: <a href="{{ URL::to('/') }}/group/details/{{ $member->group_id }}" style="color: #0d8079;text-decoration: underline;">{{ $member->group }}</a></span>
                               <div class="profile-statistics">
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Gender : {{ $member->gender }}</p>                               
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Residence : {{ $member->residential_address }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Business Location : {{ $member->business_location }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Phone : {{ $member->phone }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Email : {{ $member->email }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Birth Date : {{ Carbon\Carbon::parse($member->date_of_birth)->format('d/m/Y') }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Registered : {{ Carbon\Carbon::parse($member->created_at)->format('d/m/Y') }}</p>
                           </div>
                              <a href="{{ URL::to('/') }}/applicant/edit/{{ $member->id }}" class="btn btn-primary">Edit</a>
                              @if(count($active_loan) > 0)
                                <a href="{{ URL::to('/') }}/old_applicant/{{ $active_loan->id }}" class="btn btn-primary">Loan Details</a>
                                <a href="{{ URL::to('/') }}/repayment/{{ $active_loan->id }}" class="btn btn-primary">Repay Loan</a>
                              @else
                                <a href="{{ URL::to('/') }}/loan/new/{{ $member->id }}" class="btn btn-primary">Add Loan</a>
                              @endif
                           </div>
                       </div>
                       <div class="col-md-3">
                           <div class="profile-statistics">
                               <h1>{{ $member->id }}</h1>
                               <p>Member Id</p>
                               <h1>
                                  @if(count($active_loan) > 0)
                                    Yes
                                  @else
                                    No
                                  @endif
                               </h1>
                               <p>Has Active Loan?</p>                                
                               <ul>
                                   <li>
                                       <a href="#">
                                           <i class="fa fa-facebook"></i>
                                       </a>
                                   </li>
                                   <li class="active">
                                       <a href="#">
                                           <i class="fa fa-twitter"></i>
                                       </a>
                                   </li>
                                   <li>
                                       <a href="#">
                                           <i class="fa fa-google-plus"></i>
                                       </a>
                                   </li>
                               </ul>
                           </div>
                       </div>
                    </div>
                </section>
            </div>            
        </div>
        <!-- page end-->
        </section>
@endsection

@section('page_script')
<!-- <script src="{{URL::asset('assets/js/easypiechart/jquery.easypiechart.js')}}"></script>
<script src="{{URL::asset('assets/js/sparkline/jquery.sparkline.js')}}"></script>
<script src="{{URL::asset('assets/js/flot-chart/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/js/flot-chart/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{URL::asset('assets/js/flot-chart/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/js/flot-chart/jquery.flot.pie.resize.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/jquery.validate.min.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/validation-init.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/bootstrap-switch.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/fuelux/js/spinner.min.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/bootstrap-daterangepicker/moment.min.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/bootstrap-daterangepicker/daterangepicker.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/jquery-multi-select/js/jquery.multi-select.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/jquery-multi-select/js/jquery.quicksearch.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/jquery-tags-input/jquery.tagsinput.js')}}"></script> -->
<script src="{{URL::asset('assets/js/jquery.printPage.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
	$('.btnprn').printPage();
	});
</script>
<!-- <script type="text/javascript">
	$(document).ready(function() {
    $("#e1").select2();
    $("#e9").select2();
    $("#e2").select2({
        placeholder: "Select a State",
        allowClear: true
    });
    $("#e3").select2({
        minimumInputLength: 2
    });
});
</script> -->
<!-- <script type="text/javascript">
    $(document).ready(function(){

         $.ajaxSetup({
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        // when the user clicks on like
        $('.calc_btn').on('click', function(){
            var amountgiven = $('#amountgiven').val();
            var period = $('#period').val();
            var token = $('input[name = "_token"]').val();

            $.ajax({
                url: '/calcualate/interest',
                type: 'post',
                data: {
                    '_token': token,
                    'amountgiven': amountgiven,
                    'period': period
                },
                success: function(response){
                    var interest = document.getElementById('interest');
                     interest.value = response.interest;
                     // console.log(response.interest); 
                }
            });
        });
    });
</script> -->
<!-- <script src="{{URL::asset('assets/js/toggle-init.js')}}"></script> -->
<!-- <script src="{{URL::asset('assets/js/advanced-form.js')}}"></script> -->
@endsection