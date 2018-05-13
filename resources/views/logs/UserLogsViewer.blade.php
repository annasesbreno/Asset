@extends('layouts.app')

@section('content')
  <div class="container">

    <div class="row">
      <div class="col-sm-5">
        <h1>User Logs Viewer</h1>
      </div>

      @if(Auth::user()->role === 'super_admin')
      <div class="col-sm-10">
        <div class="btn-group btn-group-justified">

          <div class="btn-group">
            <a href="{{url('log-viewer')}}" type="button" class="btn btn-default btn-sm {{(Request::is('log-viewer') ? 'active' : '')}}"> <i class="fa fa-list"></i> All</a>
          </div>

          <div class="btn-group">
            <a href="{{url('log-viewer/added')}}" type="button" class="btn btn-default btn-sm {{(Request::is('log-viewer/added') ? 'active' : '')}}"> <i class="fa fa-plus"></i> Added</a>
          </div>

          <div class="btn-group">
            <a href="{{url('log-viewer/edited')}}" type="button" class="btn btn-default btn-sm {{(Request::is('log-viewer/edited') ? 'active' : '')}}"> <i class="fa fa-edit"></i> Edited</a>
          </div>

          <div class="btn-group">
            <a href="{{url('log-viewer/deleted')}}" type="button" class="btn btn-default btn-sm {{(Request::is('log-viewer/deleted') ? 'active' : '')}}"> <i class="fa fa-remove"></i> Deleted</a>
          </div>

          <div class="btn-group">
            <a href="{{url('log-viewer/logs')}}" type="button" class="btn btn-default btn-sm {{(Request::is('log-viewer/logs') ? 'active' : '')}}"> <i class="fa fa-sign-in"></i> User Logs</a>
          </div>

          <div class="btn-group">
            <a href="{{url('log-viewer/reports')}}" type="button" class="btn btn-default btn-sm {{(Request::is('log-viewer/reports') ? 'active' : '')}}"> <i class="fa fa-file"></i> Generated Reports</a>
          </div>

        </div>
      </div>

    </div>

    <br>
    <ul class="list-group">

    @forelse($logs as $log)
     <li class="list-group-item list-group-item-primary" style="padding:15px; background:#f4fdff;">
       @if($log->action === 'Log')
       <i class="fa fa-sign-in"></i>
       @elseif($log->action === 'Add')
       <i class="fa fa-plus"></i>
       @elseif($log->action === 'Edit')
       <i class="fa fa-edit"></i>
       @elseif($log->action === 'Delete')
       <i class="fa fa-remove"></i>
       @elseif($log->action === 'Report')
       <i class="fa fa-file"></i>
       @endif
       {{$log->created_by}} {{$log->description}} <span class="pull-right">{{$log->created_at->diffForHumans()}}</span>
     </li>
     <br>
    @empty
    </ul>
      <div class="alert alert-danger">
      <strong>No Logs!</strong> No logs made in the system.
      </div>
    @endforelse
    <span class="pull-right">{{ $logs->links() }}</span>
  </div>

  @else
  <div class="container">
    <div class="row">
      <br><br><br><br>
      <div class="alert alert-danger">
      <strong class=""> <i class="fa fa-remove"></i> Page Restricted!</strong>
      Please consult the super administrator to gain access to this page.
      </div>
    </div>
  </div>
  @endif
@endsection
