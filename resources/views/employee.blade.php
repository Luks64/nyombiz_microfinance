@extends('layout.app')

@section('title','Employee')

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
                    <li><a href="{{URL::to('/')}}/employees">Employees</a></li>
                    <li class="active">{{ $employee->name }}</li>
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
                               <img src="{{URL::asset('assets/images/no-avatar2.png')}}" alt=""/>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="profile-desk">
                               <h1>{{ $employee->name }}</h1>
                               <span class="text-muted" style="display:block;">Position: {{ $employee->position }}</span>
                               <div class="profile-statistics">
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Gender : {{ $employee->gender }}</p>                               
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Marital Status : {{ $employee->marital_status }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Residence : {{ $employee->residence }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Phone : {{ $employee->phone }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Email : {{ $employee->email }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Birth Date : {{ $employee->birth_date }}</p>
                               <p style="border-bottom: 1px solid #f1f2f7;display:block;padding-bottom: 5px">Enrolled : {{ $employee->start_date }}</p>
                           </div>
                               <a href="{{ URL::to('/') }}/employee/edit/{{ $employee->id }}" class="btn btn-primary">Edit</a>
                           </div>
                       </div>
                       <div class="col-md-3">
                           <div class="profile-statistics">
                               <h1>{{ $employee->employee_no }}</h1>
                               <p>Employee No</p>
                               <h1>Ugx {{ number_format($employee->monthly_salary).'/-' }}</h1>
                               <p>Salary</p>
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
                        Groups Managed
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
                                    <th>Group No.</th>
                                    <th>Group</th>
                                    <th>Officer</th>
                                    <th>Members</th>
                                    <th>Date Created</th>
                                    <th>Is Active</th>                                    
                                    <th class="noprint">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($groups) > 0)
                                      @foreach($groups as $key => $group)
                                       
                                        <tr class="">
                                                <td>{{$key + 1}}</td>
                                                <td>{{ $group->group_no }}</td>
                                            <td>{{ $group->name }}</td>
                                            <td>{{ $group->officer }}</td> 
                                                <td>{{ $group->members }}</td>                                               
                                                <td>{{ Carbon\Carbon::parse($group->creation_date)->format('d/m/Y')}}</td>
                                                <td>
                                                    @if ($group->is_active == 1)
                                                        Yes
                                                    @else
                                                        No
                                                    @endif
                                                </td>
                                            <td class="noprint"><a href="#{{URL::to('/')}}/group_repayment/{{ $group->id }}">Repay |</a><span>&nbsp;&nbsp;</span><a href="{{URL::to('/')}}/group/details/{{ $group->id }}">Details |</a><span>&nbsp;&nbsp;</span><a href="{{URL::to('/')}}/group/edit/{{ $group->id }}">Edit</a></td>
                                        </tr>
                                      @endforeach
                                    @else
                                        <p>No Groups Found...</p>
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