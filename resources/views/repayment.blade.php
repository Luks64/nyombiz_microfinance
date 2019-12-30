@extends('layout.app')

@section('title','Repayments')

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
	<link rel="stylesheet" href="{{URL::asset('assets/js/jquery-tags-input/jquery.tagsinput.css')}}"> -->
    <link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-datepicker/css/datepicker.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-timepicker/compiled/timepicker.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-colorpicker/css/colorpicker.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-daterangepicker/daterangepicker-bs3.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/js/bootstrap-datetimepicker/css/datetimepicker.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/data-tables/DT_bootstrap.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/sweetalert2/dist/sweetalert2.min.css')}}">
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
    <style type = "text/css">
        .hide{
            display:none; 
        }

        @media print {
            body {
              margin: 0;
            }
            .noprint { display: none; }

            .container {
              padding-right: 15px;
              padding-left: 15px;
              margin-right: auto;
              margin-left: auto;
            }

            .row {
              margin-right: -15px;
              margin-left: -15px;
            }

            .col-md-4, .col-md-8, .col-md-12 {
              position: relative;
              min-height: 1px;
              padding-right: 15px;
              padding-left: 15px;
            }

            .col-md-4 {
                width: 33.33333333333333%;
            }

            .col-md-8 {
                width: 66.66666666666666%;
            }

            .col-md-12 {
                width: 100%;
            }       
        }

        .datepicker{
            z-index:9999 !important;
        }
    </style>
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
                        <div class="alert alert-info alert-dismissible">
                            {{ $applicant->first_name  }} {{ $applicant->last_name  }} <br> Total balance Due : <span style="color: red">{{number_format($total,2)}}</span>
                        </div>                        
                    </header>
                    <div class="panel-body">
                        <div class="adv-table editable-table ">
                            <div class="row clearfix noprint">
                                <div class="col-md-3">
                                    <div class="btn-group btns">
                                        <a class="btn btn-success" data-toggle="modal" href="#myModal">
                                            Repay
                                        </a>
                                    </div>

                                </div>
                                <div class="col-md-9">
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="{{URL::to('/')}}/print/repayment/{{ $loan_id }}">Print</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div><br>

                           
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                   
                                    <th>Due Date</th>
                                    <th>Principal</th>
                                    <th>Principal Repaid</th>
                                    <th>Interest</th>
                                    <th>Interest Repaid</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                	@foreach($loan_repayments as $key => $loan_repayment)
                                        
                                            
                                            <tr class="" @if( Carbon\Carbon::now()->weekOfYear >= Carbon\Carbon::parse($loan_repayment->due_date)->weekOfYear) style="background-color:wheat" @endif>
                                                <input type="hidden" name="repay_id" id="repay_id" value="{{$loan_repayment->id}}">
                                                <?php
                                                    $formated_due_date = explode('-', $loan_repayment->due_date);
                                                    $day = $formated_due_date[2];
                                                    $month = $formated_due_date[1];
                                                    $year = $formated_due_date[0];
                                                ?>
                                                <td><span class='hide'>{{$loan_repayment->due_date}}</span>{{ $day }}/{{$month}}/{{$year}} @if( Carbon\Carbon::now()->weekOfYear ==Carbon\Carbon::parse($loan_repayment->due_date)->weekOfYear) (This Week) @endif</td>
                                                <td>{{ $loan_repayment->principal }}</td>
                                                <td>{{ $loan_repayment->principal_repaid }}</td>
                                                <td>{{ number_format($loan_repayment->interest, 2) }}</td>
                                                <td>{{ number_format($loan_repayment->interest_repaid, 2) }}</td> 
                                                <?php if($loan_repayment->status == 0) : ?>
                                                    <td class="center"><span class="label label-danger label-mini ">Uncleared</span></td>
                                                <?php else : ?>
                                                    <td class="center"><span class="label label-success label-mini ">Cleared</span></td>
                                                <?php endif; ?>
                                                <td><a class="btn btn-success" href="#Modal"><i class="fa fa-exclamation-triangle"></i>
                                                </a></td>
                                            </tr>
                                        
                                	@endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </section>
            </div>
        </div>

         <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Repayment Details</h4>
                    </div>
                     <form action="{{URL::to('/')}}/repayment" method="POST" id='repay_form'>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="loan_id" id="loan_id" value="{{$loan_id}}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="amount_in">Amount Brought</label>
                                <input type="number" step="0.1" id="amount_in" name="amount_in" class="form-control" placeholder="All Amount Brought">
                            </div>
                            <div class="form-group">
                                <label for="repay_date">Date</label>
                                <input type="text" class="form-control default-date-picker" id="repay_date" name="repay_date" class="form-control" placeholder="Transaction Date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal -->
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
<!-- <script src="{{URL::asset('assets/js/jquery.validate.min.js')}}"></script>
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
<script src="{{URL::asset('assets/js/jquery-multi-select/js/jquery.quicksearch.js')}}"></script> -->
<script src="{{URL::asset('assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-daterangepicker/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/js/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

<script src="{{URL::asset('assets/js/data-tables/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/js/data-tables/DT_bootstrap.js')}}"></script>
<!--script for this page only-->
<script src="{{URL::asset('assets/js/table-editable.js')}}"></script>
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
<!-- END JAVASCRIPTS -->
<script>
    jQuery(document).ready(function() {
        EditableTable.init();

        $('.default-date-picker').datepicker({
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(e){
            $(this).datepicker('hide');
        });
    });
</script>

<script type="text/javascript">
     $(document).ready(function(){

        //  $.ajaxSetup({
        //       headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        // // when the user clicks on like
        $('.repay').on('click', function(){
            var parent_tr = $(this).parent('tr');
            var repay_id = parent_tr.find( "input[name='repay_id']").first();
            var amount_in = parent_tr.find( "input[name='amount_in']").first();
            var repay_date = parent_tr.find( "input[name='repay_date']").first();
            var token = $('input[name = "_token"]').val();
            // var amountgiven = $('#amountgiven').val();
            // var period = $('#period').val();
            // var token = $('meta[content = "csrf-token"]').val();

            // var myForm = document.getElementById('repay_form');

            var formData = new FormData();

            formData.append("repay_id", repay_id);

            formData.append("amount_in", amount_in);

            formData.append("repay_date", repay_date);

            formData.append("_token", token);

            formData.submit();

           // $.ajax({
           //      url: '/calcualate/interest',
           //      type: 'post',
           //      data: {
           //          '_token': token,
           //          'repay_id': repay_id,
           //          'amount_in': amount_in
           //      },
           //      success: function(response){
           //          var interest = document.getElementById('interest');
           //           interest.value = response.interest;
           //           // console.log(response.interest); 
           //      }
           //  });
        });
    });
</script>

<script src="{{URL::asset('assets/js/sweetalert2/dist/sweetalert2.min.js')}}"></script>
@endsection