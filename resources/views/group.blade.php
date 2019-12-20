@extends('layout.app')

@section('title','Group')

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
                    <li><a href="{{URL::to('/')}}/groups">Groups</a></li>
                    <li class="active">{{ $group->name }}</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>  

        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body profile-information">
                       <div class="col-md-9">
                           <div class="profile-desk">
                               <h1>{{ $group->name }}</h1>
                               <span class="text-muted" style="display:block;">Officer: {{ $group->officer }}</span>
                               <div class="profile-statistics">
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Meeting Day : {{ $group->meeting_day }}</p>                               
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Meeting Frequency : {{ $group->meeting_frequency }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Location : {{ $group->location }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Activity : {{ $group->activity }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Date Formed : {{ Carbon\Carbon::parse($group->creation_date)->format('d/m/Y')}}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Is Active : {{ $group->is_active }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Principal Out : {{ $group->principal_out }}</p>
                           </div>
                               <a href="{{ URL::to('/') }}/group/edit/{{ $group->id }}" class="btn btn-primary">Edit</a>
                           </div>
                       </div>
                       <div class="col-md-3">
                           <div class="profile-statistics">
                               <h1>{{ $group->group_no }}</h1>
                               <p>Group No</p>
                               <h1>{{ Carbon\Carbon::parse($group->creation_date)->diffForHumans() }}</h1>
                               <p>Formed</p>
                               <h1>Ugx {{ number_format($group->monthly_salary).'/-' }}</h1>
                               <p>Principal Out</p>
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
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading noprint">
                        Members
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>                            
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table editable-table ">
                            <div class="clearfix noprint">
                                <div class="btn-group pull-right">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{URL::to('/')}}/print/all/loans">Print</a></li>
                                        <li><a href="{{URL::to('/')}}/save/all/loans">Save as PDF</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="space15"></div>
                            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Created</th>
                                    <th>Outstanding</th>                                    
                                    <th class="noprint">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($members) > 0)
                                      @foreach($members as $key => $member)
                                       
                                        <tr class="">
                                            <td>{{$key + 1}}</td>
                                            <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                                            <td>{{$member->created_at->format('d/m/Y')}} ({{$member->created_at->diffForHumans()}})</td>
                                            <td class="noprint"><a href="{{URL::to('/')}}/applicant/delete/{{ $member->id }}" onclick="return confirm('Are you sure?')">Delete |</a><span>&nbsp;&nbsp;</span><a href="{{URL::to('/')}}/member/details/{{ $member->id }}">Details |</a><span>&nbsp;&nbsp;</span><a href="{{URL::to('/')}}/applicant/edit/{{ $member->id }}">Edit</a></td>
                                        </tr>
                                      @endforeach
                                    @else
                                        <p>No Members Found...</p>
                                    @endif
                                </tbody>
                            </table>
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