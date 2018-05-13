@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="row">
      <h2>Administrators</h2>
    </div>

    @if(Auth::user()->role === 'super_admin')
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Full Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Date Created</th>
          <th>Commands</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{$user->name}}</td>
          <td>{{$user->email}}</td>
          <td>{{($user->role === 'super_admin') ? 'Super Admin' : 'Sub Admin'}}</td>
          <td>{{$user->created_at->format('M d, Y')}}</td>
          <td>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-info btn-sm {{($user->id === 1) ? 'hidden' : ''}}" data-toggle="modal" data-target="#changeRole{{$user->id}}">
              <i class="fa fa-edit"></i>  Change Role
            </button>

            <!-- Modal -->
            <div class="modal fade" id="changeRole{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="" action="{{url('administrator/'.$user->id)}}" method="post">
                    {{csrf_field()}} {{method_field('PUT')}}
                    <div class="modal-body">
                      <h4>Change Role of {{$user->name}}?</h4>
                      <div class="">
                        <select name="role" required class="form-control">
                          <option value="">Choose Role</option>
                          <option value="super_admin">Super Admin</option>
                          <option value="sub_admin">Sub Admin</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>


            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger btn-sm {{($user->id === 1) ? 'hidden' : ''}}" data-toggle="modal" data-target="#delete{{$user->id}}">
              <i class="fa fa-remove"></i> Delete User
            </button>

            <!-- Modal -->
            <div class="modal fade" id="delete{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="" action="{{url('administrator/delete/'.$user->id)}}" method="post">
                    {{csrf_field()}} {{method_field('PUT')}}
                    <div class="modal-body">
                      <h4>Delete Account of {{$user->name}}?</h4>
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
  </div>
@endsection
