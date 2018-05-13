@extends('layouts.app')

@section('content')
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3>
        Processor

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
              <h3 class="modal-title" id="exampleModalLabel">Add Processor</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{url('processor')}}" method="post">
              {{csrf_field()}}
              <div class="modal-body">
                <div class="">
                  <label for="">Processor Name</label>
                </div>
                <input type="text" name="name" placeholder="Processor Name" class="form-control" required>
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
      @foreach($processors as $processor)
      <tr>
        <td>{{$processor->name}}</td>
        <td>{{$processor->created_at->format('M d, Y')}}</td>
        <td>{{$processor->created_by}}</td>
        <td>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#edit{{$processor->id}}">
            <i class="fa fa-edit"></i> Edit
          </button>

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete{{$processor->id}}">
            <i class="fa fa-remove"></i> Remove
          </button>

          <!-- Modal -->
          <div class="modal fade" id="edit{{$processor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="exampleModalLabel">Edit Processor</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{url('processor/'.$processor->id)}}" method="post">
                  {{csrf_field()}} {{method_field('PUT')}}
                  <div class="modal-body">
                    <div class="">
                      <label for="">Processor Name</label>
                    </div>
                    <input type="text" name="name" value="{{$processor->name}}" placeholder="Processor Name" class="form-control">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="delete{{$processor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="exampleModalLabel">Remove Processor</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{url('processor/remove/'.$processor->id)}}" method="post">
                  {{csrf_field()}} {{method_field('PUT')}}
                  <div class="modal-body">
                   <h2>Remove {{$processor->name}}?</h2>
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
    {{$processors->links()}}
  </div>
    </div>
 </div>
</div>
@endsection
