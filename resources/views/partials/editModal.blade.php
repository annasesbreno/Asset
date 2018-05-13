<!-- Modal -->
<div class="modal fade" id="editModal{{$hardware->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit {{$hardware->model_name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="{{url('edit/delivery/'.$hardware->id)}}" method="POST">
        {{csrf_field()}} {{method_field('PUT')}}
        <div class="modal-body long-modal">
          <div>
            <p>
              <strong>Serial Number</strong>
            </p>
            <input type="text" name="serial" value="{{$hardware->serial}}" placeholder="Serial Number" class="form-control" required>
          </div>

          <div>
            <p>
              <strong>Model Name</strong>
            </p>
            <input type="text" name="model_name" value="{{$hardware->model_name}}" placeholder="Model Name" class="form-control" required>
          </div>

          <div>
            <p>
              <strong>Hardware Type</strong>
            </p>
            <!--<input type="text" name="hardware_type" value="{{$hardware->hardware_type}}" placeholder="Hardware Type" class="form-control" required>-->
            <select class="form-control" name="hardware_type" required>
              <option value="{{$hardware->hardwaretype_id}}">{{$hardware->hardwareType->name}}</option>
              @foreach(App\HardwareType::where('status','Created')->where('id','!=',$hardware->hardwareType->id )->get() as $ht)
              <option value="{{$ht->id}}">{{$ht->name}}</option>
              @endforeach
            </select>
          </div>

          <div>
            <p>
              <strong>ssBrand</strong>
            </p>
            <!--<input type="text" name="brand" value="{{$hardware->brand}}" placeholder="Brand" class="form-control" required>-->
            <select class="form-control" name="brand" required>
              <option value="{{$hardware->brand_id}}">{{$hardware->brandKey->name}}</option>
              @foreach(App\Brand::where('status','Created')->where('id','!=',$hardware->brandKey->id )->get() as $brand)
              <option value="{{$brand->id}}">{{$brand->name}}</option>
              @endforeach
            </select>
          </div>

          <div>
            <p>
              <strong>Processor</strong>
            </p>
            <!--<input type="text" name="processor" value="{{$hardware->processor}}" placeholder="Processor" class="form-control" required>-->
            <select class="form-control" name="processor" required>
              <option value="{{$hardware->processor_id}}">{{$hardware->processor}}</option>
              @foreach(App\Processor::where('status','Created')->where('id','!=',$hardware->processorKey->id )->get() as $processor)
              <option value="{{$processor->id}}">{{$processor->name}}</option>
              @endforeach
            </select>
          </div>

          <div>
            <p>
              <strong>RAM</strong>
            </p>
            <input type="text" name="ram" value="{{$hardware->ram}}" placeholder="RAM" class="form-control" required>
          </div>

          <div>
            <p>
              <strong>Storage</strong>
            </p>
            <input type="text" name="storage" value="{{$hardware->storage}}" placeholder="Storage" class="form-control" required>
          </div>

          <div>
            <p>
              <strong>Storage Type</strong>
            </p>
            <!--<input type="text" name="storage_type" value="{{$hardware->storage_type}}" placeholder="Storage Type" class="form-control" required>-->
            <select class="form-control" name="storage_type" required>
              <option value="{{$hardware->storagetype_id}}">{{$hardware->storageType->name}}</option>
              @foreach(App\StorageType::where('status','Created')->where('id','!=',$hardware->storageType->id )->get() as $st)
              <option value="{{$st->id}}">{{$st->name}}</option>
              @endforeach
            </select>
          </div>

          <div>
            <p>
              <strong>Purchased Date</strong>
            </p>
            <input type="text" name="purchased_date" value="{{$hardware->purchased_date->format('Y-m-d')}}" placeholder="Purchased Date" class="form-control" required>
          </div>

          <div>
            <p>
              <strong>Warranty Date</strong>
            </p>
            <input type="text" name="warranty_date" value="{{$hardware->warranty_date->format('Y-m-d')}}" placeholder="Warranty Date" class="form-control" required>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
