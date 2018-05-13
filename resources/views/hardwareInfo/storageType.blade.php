@extends('layouts.app')

@section('content')
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3>
        Storage Type

        <div class="pull-right">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-plus"></i> Add
          </button>
        </div>
      </h3>



      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="exampleModalLabel">Storage Type</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{url('storage-type')}}" method="post">
              {{csrf_field()}}
              <div class="modal-body">
                <div class="">
                  <label for="">Storage Type</label>
                </div>
                <input type="text" name="name" placeholder="Storage Type" class="form-control" required>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
    <div class="panel-body">
      <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Created at</th>
        <th>Created by</th>
        <th>Commands</th>
      </tr>
    </thead>
    <tbody>
      @foreach($storageTypes as $storageType)
      <tr>
        <td>{{$storageType->name}}</td>
        <td>{{$storageType->created_at->format('M d, Y')}}</td>
        <td>{{$storageType->created_by}}</td>
        <td>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#edit{{$storageType->id}}">
            <i class="fa fa-edit"></i> Edit
          </button>

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete{{$storageType->id}}">
            <i class="fa fa-remove"></i> Remove
          </button>

          <!-- Modal -->
          <div class="modal fade" id="edit{{$storageType->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="exampleModalLabel">Edit Storage Type</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{url('storage-type/'.$storageType->id)}}" method="post">
                  {{csrf_field()}} {{method_field('PUT')}}
                  <div class="modal-body">
                    <div class="">
                      <label for="">Storage Type</label>
                    </div>
                    <input type="text" name="name" value="{{$storageType->name}}" placeholder="Storage Type" class="form-control">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="delete{{$storageType->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="exampleModalLabel">Remove Storage Type</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{url('storage-type/remove/'.$storageType->id)}}" method="post">
                  {{csrf_field()}} {{method_field('PUT')}}
                  <div class="modal-body">
                   <h2>Remove {{$storageType->name}}?</h2>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Confirm</button>
                  </div>
                </form>
              </div>
            </div>
          </div>


        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="text-center">
    {{$storageTypes->links()}}
  </div>
    </div>
 </div>
</div>
@endsection
