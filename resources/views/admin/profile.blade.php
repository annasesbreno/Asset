@extends('layouts.app')

@section('content')
<div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >


          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">{{Auth::user()->name}}</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center">
                  <h3>Local IS</h3>
                </div>

                <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                  <dl>
                    <dt>DEPARTMENT:</dt>
                    <dd>Administrator</dd>
                    <dt>HIRE DATE</dt>
                    <dd>11/12/2013</dd>
                    <dt>DATE OF BIRTH</dt>
                       <dd>11/12/2013</dd>
                    <dt>GENDER</dt>
                    <dd>Male</dd>
                  </dl>
                </div>-->
                <div class=" col-md-9 col-lg-9 ">
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td><b>Full Name:</b></td>
                        <td>{{Auth::user()->name}}</td>
                      </tr>
                      <tr>
                        <td><b>Email</b></td>
                        <td>{{Auth::user()->email}}</td>
                      </tr>
                      <tr>
                        <td><b>Department</b></td>
                        <td>Local IS Department</td>
                      </tr>

                         <tr>
                             <tr>
                        <td><b>Role</b></td>
                        <td>{{(Auth::user()->role === 'super_admin') ? 'Super Admin' : 'Sub Admin'}}</td>
                      </tr>
                      </tr>

                    </tbody>
                  </table>

                </div>
              </div>
            </div>
                 <div class="panel-footer">
                   <!-- Button trigger modal -->
                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#editModal">
                      <i class="fa fa-edit"></i> Edit Profile
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form class="" action="{{url('profile')}}" method="post">
                            {{csrf_field()}} {{method_field('PUT')}}
                            <div class="modal-body">
                              <div class="">
                                <label for="">Full Name</label>
                                <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control" required>
                              </div>

                              <div class="">
                                <label for="">Email</label>
                                <input type="email" name="email" value="{{Auth::user()->email}}" class="form-control" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                 </div>

          </div>
        </div>
      </div>
    </div>
@endsection
