@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2>Home - Dashboard</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <form method="POST" action="{{url('home')}}" class="form-inline">
        {{csrf_field()}}
        <label class="sr-only" for="inlineFormInputGroupUsername2">From</label>
        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
          <div class="input-group-addon">From</div>
          <input type="date" class="form-control" name="from" placeholder="From" required>
        </div>

        <label class="sr-only" for="inlineFormInputGroupUsername2">To</label>
        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
          <div class="input-group-addon">To</div>
          <input type="date" class="form-control" name="to" placeholder="To" required>
        </div>
        <button type="submit" class="btn btn-primary">Filter Data</button>

        @include('partials.datepicker')
     </form>


    </div>
    <div class="row">
      <div class="col-sm-10">
        <br>
        @if($from !== NULL)
        <h3>Date Range: {{$from->format('M d, Y')}} - {{$to->format('M d, Y')}}</h3>
        <a href="{{url('/dashboard-pdf/'.$from.'/'.$to)}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Generate Date Range Report</a>
        @elseif(Request::is('stats/today'))
        <h3>Stats {{$date}}</h3>
        <a href="{{url('/report/today')}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Generate Today Report</a>
        @elseif(Request::is('stats/yesterday'))
        <h3>Stats {{$date}}</h3>
        <a href="{{url('/report/yesterday')}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Generate Yesterday Report</a>
        @elseif(Request::is('stats/week'))
        <h3>Stats {{$date}}</h3>
        <a href="{{url('/report/week')}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Generate Last 7 Day Report</a>
        @elseif(Request::is('stats/month'))
        <h3>Stats {{$date}}</h3>
        <a href="{{url('/report/month')}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Generate This Month Report</a>
        @elseif(Request::is('stats/last-month'))
        <h3>Stats {{$date}}</h3>
        <a href="{{url('/report/last-month')}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Generate Last Month Report</a>
        @else
          @if($date !== NULL)
          <h3>Stats {{$date}}</h3>
          @endif
          <a href="{{url('/dashboard-pdf')}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Generate Dashboard Report</a>
          <a href="{{url('/dashboard-excel')}}" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-file"></i> Generate Excel Report</a>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        {!! $status->html() !!}
      </div>
      <div class="col-sm-6">
        {!! $hardware_type->html() !!}
      </div>
    </div>
    <hr>
    <div class="row">
       <div class="col-sm-6">
         {!! $vendor->html() !!}
       </div>
    </div>
</div>

<!-- End Of Main Application -->
{!! Charts::scripts() !!}
{!! $status->script() !!}
{!! $vendor->script() !!}
{!! $hardware_type->script() !!}
@endsection
