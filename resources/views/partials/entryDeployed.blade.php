<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#single"> <i class="fa fa-caret-right"></i> Single Entry</button>
<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#bulk"><i class="fa fa-database"></i> Bulk Entry</button>
<!-- Modal -->
<div id="single" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Deployed Device</h4>
      </div>
      <form class="" action="{{url('singleDeployed')}}" method="POST">
        {{csrf_field()}}
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-4">
              <label>Serial</label>
              <input type="text" name="serial" class="form-control" placeholder="Serial Number" required>
            </div>

            <div class="col-sm-4">
              <label>Model Unit Name</label>
              <input type="text" name="model" class="form-control" placeholder="Model Unit Name" required>
            </div>

            <div class="col-sm-4">
              <label>Hardware Type</label>
              <select type="select" name="ht" class="form-control" placeholder="Hardware Type" required>
                <option value="">Choose One</option>
                @forelse(App\HardwareType::where('status', '=', 'Created')->get() as $ht)
                <option value="{{$ht->id}}">{{$ht->name}}</option>
                @empty
                @endforelse
              </select>
            </div>

          </div>


          <div class="row">
            <div class="col-sm-4">
              <label>Brand</label>
              <select type="select" name="brand" class="form-control" placeholder="Brand" required>
                <option value="">Choose One</option>
                @forelse(App\Brand::where('status', '=', 'Created')->get() as $brand)
                <option value="{{$brand->id}}">{{$brand->name}}</option>
                @empty
                @endforelse
              </select>
            </div>

            <div class="col-sm-4">
              <label>Processor</label>
              <select type="select" name="processor" class="form-control" placeholder="Processor" required>
                <option value="">Choose One</option>
                @forelse(App\Processor::where('status', '=', 'Created')->get() as $processor)
                <option value="{{$processor->id}}">{{$processor->name}}</option>
                @empty
                @endforelse
              </select>
            </div>

            <div class="col-sm-4">
              <label>RAM (gb)</label>
              <input type="number" name="ram" class="form-control" placeholder="RAM" min="2" required>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4">
              <label>Storage Size</label>
              <input type="text" name="storage" class="form-control" placeholder="Storage" required>
            </div>

            <div class="col-sm-4">
              <label>Storage Type</label>
              <select type="text" name="st" class="form-control" placeholder="Storage Type" required>
                <option value="">Choose One</option>
                @forelse(App\StorageType::where('status', '=', 'Created')->get() as $st)
                <option value="{{$st->id}}">{{$st->name}}</option>
                @empty
                @endforelse
              </select>
            </div>

            <div class="col-sm-4">
              <label>Purchased Date</label>
              <input type="date" name="pd" class="form-control" placeholder="Purchased Date" required>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4">
              <label>Warranty Date</label>
              <input type="date" name="wt" class="form-control" placeholder="Warranty Date" required>
            </div>
            <div class="col-sm-4">

            </div>
            <div class="col-sm-4">

            </div>
          </div>

          <hr>
          <h4>Deployed to</h4>
          <div class="row">
            <div class="col-sm-4">
              <label>Emp ID</label>
              <input type="text" name="empid" class="form-control" placeholder="Employee ID" required>
            </div>

            <div class="col-sm-4">
              <label>Seat Number</label>
              <input type="text" name="sn" class="form-control" placeholder="Seat Number" required>
            </div>

            <div class="col-sm-4">
              <label>Deployed to</label>
              <input type="text" name="dt" class="form-control" placeholder="Deployed to" required>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4">
              <label>Deployed by</label>
              <!--<input type="text" name="db" class="form-control" placeholder="Deployed by" required>-->
              <select class="form-control" name="db" required>
                <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                @foreach(App\User::where('id','!=', Auth::user()->id)->get() as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-4">
              <label>Deployed Date</label>
              <input type="date" name="dd" class="form-control" placeholder="Deployed Date" required>
            </div>

            <div class="col-sm-4">

            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Confirm</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="bulk" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import Excel File</h4>
      </div>
      <div class="modal-body">
        <div>
          <div>
            <div class="panel panel-default">
              <div class="panel-heading">Import Excel Deployed File</div>
              <div class="panel-body">
                <form action="{{url('add/deployed/excel')}}" method="POST"  enctype="multipart/form-data">
                  {{csrf_field()}}
                  <div>
                    <input type="file" name="excel" class="form-control" required>
                  </div>
                  <div><br>
                    <input type="submit" class="form-control btn btn-primary" value="Confirm">
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
