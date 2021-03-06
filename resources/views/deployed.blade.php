@extends('layouts.app')

@section('content')
<style media="screen">
  tr
  {

  }
</style>
<div class="container">
  <div class="row">
    @include('partials.entryDeployed')
    <a class="btn btn-primary btn-sm" href="{{url('deployed/report')}}" target="_blank"><i class="fa fa-print"></i> Generate Deployed Report</a>
    <a class="btn btn-success btn-sm pull-right" href="{{url('deployed-excel')}}" target="_blank"><i class="fa fa-print"></i> Generate Deployed Excel</a>
  </div>

    <h2>Deployed Devices</h2>
    <div class="row">

      <div class="right-inner-addon">
        <div class="pull-right">
          <i class="fa fa-user" ></i>
        </div>
        <input id="search2" type="text" name="search2" class="form-control" placeholder="Quick Device"><br>
      </div>

    </div>

    <div class="row">
      <div class="table-responsive">
        @include('partials.multipleButtons')
        <table class="table table-striped">
          <thead>
            <tr style="font-size:12px !important;">
              <th><input type="checkbox" name="select-all" id="select-all" class="btn btn-primary" /></th>
              <th>Serial</th>
              <th>Model</th>
              <th>Hardware Type</th>
              <th>Brand</th>
              <th>Employee ID</th>
              <th>Seat Number</th>
              <th>Owner</th>

              <th>Deployed Date</th>
              <th>Deployed By</th>
              <th>Commands</th>
            </tr>
          </thead>
          <tbody>
            @forelse($hardwares as $key=>$hardware)
            <tr class="deployed">
              <td><input type="checkbox" name="checkbox" class="sub_chk" data-id="{{$hardware->id}}"></td>
              <td>{{$hardware->serial}}</td>
              <td>{{$hardware->model_name}}</td>
              <td>{{$hardware->hardware_type}}</td>
              <td>{{$hardware->brand}}</td>

              @foreach(App\Employee::where('hardware_id', $hardware->id)->orderBy('updated_at', 'desc')->cursor() as $key=>$employee)
              @if($key === 0 && $hardware->status !== 'Inventory')
              <td>{{ $employee->emp_id }}</td>
              <td>{{ $employee->seat }}</td>
              <td>{{ $employee->name }}</td>
              <td>{{ Carbon\Carbon::parse( $employee->hardware->deployed_date)->format('M d, Y') }}</td>
              @endif($hardware->status === 'Inventory')
              @endforeach
              <td>{{ $hardware->deployed_by->name }}</td>
              <td>
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#owner{{$hardware->id}}" >View Details</button>
                <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteModal{{$hardware->id}}">Dispose</a>
                @include('partials.details')
                @include('partials.inModal')
                @include('partials.outModal')
                @include('partials.editModal')
                @include('partials.deleteModal')
              </td>
            </tr>
            @empty
            <div class="alert alert-success">
              <h4><i class="fa fa-exclamation-circle"></i> No Deployed Devices found.</h4>
            </div>
            @endforelse
          </tbody>
        </table>
        <center>{{$hardwares->links()}}</center>
      </div>
    </div>
</div>
<script type="text/javascript">

</script>
@endsection
