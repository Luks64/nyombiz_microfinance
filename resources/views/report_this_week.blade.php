@extends('layout.app')

@section('title','This Week')

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
	<link rel="stylesheet" href="{{URL::asset('assets/js/data-tables/DT_bootstrap.css')}}">

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
    </style>
@endsection

@section('body')
	<section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-md-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li><a href="{{URL::to('/')}}/"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li class="active">This Week's Realization</li>
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
                    <header class="panel-heading noprint">
                        This Week
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>                            
                         </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table editable-table ">
                            <div class="clearfix noprint">
                                <!-- <div class="btn-group pull-right">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{URL::to('/')}}/print/all/loans">Print</a></li>
                                        <li><a href="{{URL::to('/')}}/save/all/loans">Save as PDF</a></li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="space15"></div>
                            <table class="table table-striped table-hover table-bordered" id="">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Principal</th>
                                    <th>P.Repaid</th>
                                    <th>Principal Bal</th>
                                    <th>Interest</th>
                                    <th>Int.Repaid</th>
                                    <th>Interest Bal</th>                                    
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($this_week_loans) > 0)
                                    	@foreach($this_week_loans as $key => $report)
                                       
    		                                <tr class="">
                                                <td>{{$key + 1}}</td>
                                                <td>{{ Carbon\Carbon::parse($report->loan_days)->format('d/m/Y')  }}</td>
    		                                    <td style="text-align:right">{{ number_format($report->total_principal) }}</td>
                                                <td style="text-align:right">{{ number_format($report->total_principal - $report->total_p_bal) }}</td> 
                                                <td style="text-align:right">{{ number_format($report->total_p_bal) }}</td>
                                                <td style="text-align:right">{{ number_format($report->total_interest) }}</td>
                                                <td style="text-align:right">{{ number_format($report->total_interest - $report->total_i_bal) }}</td>
                                                <td style="text-align:right">{{ number_format($report->total_i_bal) }}</td>           
                                                
    		                                </tr>
                                    	@endforeach
                                        <tr>
                                            <td></td>
                                            <td><strong>TOTAL</strong></td>
                                            <td style="text-align:right"><strong>{{ number_format($group_sums[0]->total_principal) }}</strong></td>
                                            <td style="text-align:right"><strong>{{ number_format($group_sums[0]->total_principal - $group_sums[0]->total_p_bal) }}</strong></td>
                                            <td style="text-align:right"><strong>{{ number_format($group_sums[0]->total_p_bal) }}</strong></td>
                                            <td style="text-align:right"><strong>{{ number_format($group_sums[0]->total_interest) }}</strong></td>
                                            <td style="text-align:right"><strong>{{ number_format($group_sums[0]->total_interest - $group_sums[0]->total_i_bal) }}</strong></td>
                                            <td style="text-align:right"><strong>{{ number_format($group_sums[0]->total_i_bal) }}</strong></td>
                                        </tr>
                                    @else
                                        <p>No Records Found...</p>
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
<script src="{{URL::asset('assets/js/data-tables/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/js/data-tables/DT_bootstrap.js')}}"></script>
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
    });
</script>
@endsection