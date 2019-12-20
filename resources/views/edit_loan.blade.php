@extends('layout.app')

@section('title','Edit Loan')

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
	        <!-- include messages div -->
                @include('includes.messages')
            <!-- messages end -->
	        <div class="row">
	            <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Loan Applicant Form
                            <span class="tools pull-right">
                                <a class="fa fa-chevron-down" href="javascript:;"></a>
                                <a class="fa fa-cog" href="javascript:;"></a>
                                <a class="fa fa-times" href="javascript:;"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <form class="cmxform form-horizontal " id="signupForm" method="post" action="{{URL::to('/')}}/loan/edit/{{$loan->id}}">
                                	@csrf
                                    <input class=" form-control" id="id" name="id" type="hidden" value="{{$loan->id}}" />
                                    <div class="form-group ">
                                        <label for="amountappliedfor" class="control-label col-lg-3">Amount Applied For</label>
                                        <div class="col-lg-8">
                                            <input class=" form-control" id="amountappliedfor" name="amountappliedfor" type="number" value="{{$loan->amount_applied_for}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Amount Given</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" value="{{$loan->amount_given}}" name="amountgiven" id="amountgiven">
                                        </div>
                                	</div>
                                	<div class="form-group">
                                    	<label class="col-lg-3 control-label">Period (In Months)</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" value="{{$loan->period_in_months}}" name="period" id="period">
                                        </div>
                                	</div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Interest Method</label>
                                        <div class="col-lg-8">
                                            <select style="width:633px" class="populate placeholder" name="interestmethod" id="interestmethod">
                                                <option value="flat" {{$loan->interest_method == 'flat' ? 'selected' : ''}}>Flat</option>
                                                <option value="reducing" {{$loan->interest_method == 'reducing' ? 'selected' : ''}}>Reducing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Payment Mode</label>
                                        <div class="col-lg-8">
                                            <select id="paymentmode" style="width:633px" class="populate placeholder" name="paymentmode">
                                                <option selected>Select Mode</option>
                                                <option value="daily" {{$loan->payment_mode == 'daily' ? 'selected' : ''}} >Daily</option>
                                                <option value="weekly" {{$loan->payment_mode == 'weekly' ? 'selected' : ''}} >Weekly</option>
                                                <option value="monthly" {{$loan->payment_mode == 'monthly' ? 'selected' : ''}} >Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                	<div class="form-group">
                                    	<label class="col-lg-3 control-label">Interest</label>
                                        <div class="col-lg-8">
                                        	<div class="input-group m-bot15" id="int">
	                                            <input type="text" class="form-control"  name="interest" id="interest" readonly="" value="{{$loan->interest}}">
	                                            <span class="input-group-btn">
	                                                <button class="btn btn-success calc_btn" type="button" id="calculate_interest">Calculate</button>
	                                            </span>
	                                        </div>
                                        </div>
                                	</div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Purpose </label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Purpose" name="purpose" value="{{$loan->purpose}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Date When Aquired</label>
                                        <div class="col-lg-8">
                                        	<div data-date="2012-12-21T15:25:00Z" class="input-group ">
                                            	<input type="text" class="form_datetime form-control" name="datewhenaquired" readonly="" size="110" value="{{$loan->date_when_required}}">
                                            	<div class="input-group-btn">
		                                            <!-- <button type="button" class="btn btn-primary date-reset"><i class="fa fa-times"></i></button>
		                                            <button type="button" class="btn btn-warning date-set"><i class="fa fa-calendar"></i></button> -->
		                                        </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Date of Issue</label>
                                        <div class="col-lg-8">
                                        	<div data-date="2012-12-21T15:25:00Z" class="input-group">
                                            	<input type="text" class="form_datetime form-control" value="{{$loan->date_of_issue}}" name="dateofissue" readonly="" size="110">
                                            	<div class="input-group-btn">
		                                            <button type="button" class="btn btn-primary date-reset"><i class="fa fa-times"></i></button>
		                                            <button type="button" class="btn btn-warning date-set"><i class="fa fa-calendar"></i></button>
		                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Security One</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{$loan->security1}}" name="security1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Security One Value</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" value="{{$loan->security1_value}}" name="security1_value">
                                        </div>
                                	</div>
                                	<div class="form-group">
                                        <label class="col-lg-3 control-label">Security Two</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{$loan->security2}}" name="security2">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Security Two Value</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" value="{{$loan->security2_value}}" name="security2_value">
                                        </div>
                                	</div>
                                	<div class="form-group">
                                        <label class="col-lg-3 control-label">Security Three</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{$loan->security3}}" name="security3">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Security Three Value</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" value="{{$loan->security3_value}}" name="security3_value">
                                        </div>
                                	</div>
                                    {{--<div class="form-group">
                                        <label class="col-lg-3 control-label">Guarantor Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{$loan->guarantor1_name}}" name="guarantor1_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Guarantor One Phone</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" value="{{$loan->guarantor1_phone}}" name="guarantor1_phone">
                                        </div>
                                	</div>
                                	<div class="form-group">
                                        <label class="col-lg-3 control-label">Guarantor Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{$loan->guarantor2_name}}" name="guarantor2_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Guarantor Two Phone</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" value="{{$loan->guarantor2_phone}}" name="guarantor2_phone">
                                        </div>
                                	</div>--}}
                                    
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-primary" type="submit">Save</button>
                                            <button class="btn btn-default" type="button">Cancel</button>
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
<script src="{{URL::asset('assets/js/validation-init.js')}}"></script>
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
<script type="text/javascript">
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
</script>
<script type="text/javascript">
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
            // $('#interestmethod').val();
            // var mySelect = $('#interestmethod');
            //mySelect.find(':selected').text();
            // $("select#interestmethod option").filter(":selected").val();
            var interestmethod = $("select#interestmethod option").filter(":selected").val();
            //$("#interestmethod option").filter(":selected").val(); 
            //$('#interestmethod option:selected').val();

            var paymentmode = $("select#paymentmode option").filter(":selected").val();

            var token = $('input[name = "_token"]').val();

            $.ajax({
                url: '{{URL::to("/")}}/calcualate/interest',
                type: 'post',
                data: {
                    '_token': token,
                    'amountgiven': amountgiven,
                    'period': period,
                    'interestmethod': interestmethod,
                    'paymentmode' : paymentmode
                },
                success: function(response){
                    var interest = document.getElementById('interest');
                     interest.value = response.interest;
                     // console.log(response.interest); 
                }
            });
        });
    });
</script>
<!-- <script src="{{URL::asset('assets/js/toggle-init.js')}}"></script> -->
<script src="{{URL::asset('assets/js/advanced-form.js')}}"></script>
@endsection