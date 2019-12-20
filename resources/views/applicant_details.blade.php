@extends('layout.app')

@section('title','New Applicant')

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
	        <!-- include messages div -->
                @include('includes.messages')
            <!-- messages end -->
            <div class="alert alert-info fade in">
            	<div class="row">
            		<div class="col-md-6 col-sm-6">
            			<header class="panel-heading"> LOAN DETAILS</header>
		                <div class="panel-body">
		                    <table class="table">

		                        <tr>
		                            <th>Name</th>
		                            <td>{{ $loan->first_name." ". $loan->last_name }}</td>
		                        </tr>
		                        <tr>
		                            <th>Gender</th>
		                            <td>{{ $loan->gender }}</td>
		                        </tr>
		                        <tr>
		                            <th>Principal</th>
		                            <td>{{ number_format($loan->amount_given, 2) }}</td>
		                        </tr>
		                        <tr>
		                            <th>Period</th>
		                            <td>{{ number_format($loan->period_in_months) }}</td>
		                        </tr>
		                        <tr>
		                            <th>Interest</th>
		                            <td>{{ number_format($loan->interest, 2) }}</td>
		                        </tr>
		                        <tr>
		                            <th>Date of Issue</th>
                                    <?php
                                        $formated_due_date = explode('-', $loan->date_of_issue);
                                        $day = $formated_due_date[2];
                                        $month = $formated_due_date[1];
                                        $year = $formated_due_date[0];
                                    ?>
		                            <td>{{ $day }}/{{$month}}/{{$year}}</td>
		                        </tr>
		                    </table>
		                </div>
            		</div>
            		<div class="col-md-4 col-sm-4" style="padding-top: 50px">
            			<img src="/storage/photos/{{ $loan->photo }}" style="width: 320px; height: 320px; ">
            		</div>
            		<div class="col-md-2 col-sm-2">
            			<a href="" class="btnprn btn"><i class="fa fa-print"></i></a></center>
            		</div>
            	</div>
            </div>

            <div class="alert alert-info fade in">
            	<header class="panel-heading">Loan Schedule</header>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Due Date</th>
                            <th>Principal</th>
                            <th>Interest</th>
                            <th>Amount</th>
                            <th>Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($schedule as $sch)
						    <tr>
	                            <td>{{	$sch->no }}</td>
	                            <td>{{	$sch->due_date->diffForHumans() }}</td>
	                            <td>{{	number_format($sch->principal, 2) }}</td>
	                            <td>{{	number_format($sch->interest, 2) }}</td>
	                            <td>{{	number_format($sch->amount, 2) }}</td>
	                            <td>{{	number_format($sch->balance, 2) }}</td>
	                        </tr>
						@endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>
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