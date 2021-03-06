

<!-- Modal -->
<div class="modal fade" id="repair{{$hardware->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="{{url('/repair/device/'.$hardware->id)}}" method="POST">
        {{csrf_field()}} {{method_field('PUT')}}
        <div class="modal-body">
          <h3>Put {{$hardware->model_name}} on repair ?</h3>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm">Confirm</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
