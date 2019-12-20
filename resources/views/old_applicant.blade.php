@extends('layout.app')

@section('title','Old Applicant')

@section('page_styles')

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
        <!-- include messages div -->
            @include('includes.messages')
        <!-- messages end -->
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                       <section class="panel">
                            
                        <aside class="profile-nav alt">
                            <section class="panel">
                                <div class="user-heading alt gray-bg">
                                    <a href="#">
                                        <img alt="" src="{{URL::to('/')}}/storage/photos/{{ $applicant->photo }}">
                                    </a>
                                    <h1>{{ $applicant->first_name." ".$applicant->last_name }}</h1>
                                    <p>{{ $applicant->gender }}</p>
                                </div>
                                <div class="">

                                <a href="#">
                                    <img alt="" src="{{URL::to('/')}}/storage/nationalids/{{ $applicant->nationalid_scan }}" style="width: 310px; height:167px; padding-top: 20px;">
                                </a>

                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="javascript:;"> <i class="fa fa-money"></i> Principal<span class="badge label-success pull-right r-activity">{{ number_format($loan->amount_given, 2) }}</span></a></li>
                                    <li><a href="javascript:;"> <i class="fa  fa-plus-square"></i> Interest <span class="badge label-danger pull-right r-activity">{{ number_format($loan->interest, 2) }}</span></a></li>
                                    <li><a href="javascript:;"> <i class="fa fa-bell-o"></i> Period (in months) <span class="badge label-success pull-right r-activity">{{ number_format($loan->period_in_months) }}</span></a></li>
                                    <li><a href="javascript:;"> <i class="fa  fa-lock"></i> Security <span class="badge label-success pull-right r-activity">{{ number_format($loan->security1_value, 2) }}</span></a></li>

                                    <li><a href="javascript:;"> <i class="fa fa-user"></i> {{ $loan->guarantor1_name}} <span class="badge label-default pull-right r-activity">{{ $loan->guarantor1_phone }}</span></a></li>
                                    <li><a href="javascript:;"> <i class="fa fa-user"></i> {{ $loan->guarantor2_name }} <span class="badge label-default pull-right r-activity">{{ $loan->guarantor2_phone }}</span></a></li>

                                </ul>
                            </div>
                            </section>
                        </aside>
                        <!--widget end-->


                        </section>

                    </div>
                    <div class="col-md-8">
                        <section class="panel">
                    <header class="panel-heading">
                        Loan Schedule
                        <span class="btn-group pull-right">
                            <a href="{{URL::to('/')}}/print/old_applicant/{{$loan->id}}" class="fa fa-print noprint"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        <table class="table  table-hover general-table">
                            <thead>
                            <tr>
                                <th>#</th>
	                            <th>Due Date</th>
	                            <th>Principal</th>
	                            <th>Interest</th>
	                            <th>Amount</th>
	                            <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            	@foreach($schedule as $key => $sch)
                            <tr @if( Carbon\Carbon::now()->weekOfYear ==Carbon\Carbon::parse($sch->due_date)->weekOfYear) style="background-color:wheat" @endif>
                                <td>{{	$key + 1 }}</td>                                
	                            <td>{{  Carbon\Carbon::parse($sch->due_date)->format('d/m/Y') }} @if( Carbon\Carbon::now()->weekOfYear ==Carbon\Carbon::parse($sch->due_date)->weekOfYear) (This Week) @endif</td>
	                            <td>{{	number_format($sch->principal, 2) }}</td>
	                            <td>{{	number_format($sch->interest, 2) }}</td>
	                            <td>{{	number_format($sch->principal + $sch->interest, 2) }}</td>
                                @if($sch->status == 0)
                                    <td><span class="label label-danger label-mini">Uncleared</span></td>
                                @else
                                    <td><span class="label label-success label-mini">Cleared</span></td>
                                @endif
                            </tr>
                            	@endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
                    </div>
                </div>
            </div>

        </div>

	</section>

@endsection