<table>
  <tr>
    <th>Disposed Assets Report</th>
  </tr>
  <tr>
    <td>
      <b>Generated By:</b> {{Auth::user()->name}}
    </td>
  </tr>
  <tr>
    <td>
      <b>Date:</b> {{Carbon\Carbon::now()->format('M d, Y')}}
    </td>
  </tr>
</table>

<table>
  <tr>
    <th>Disposed Assets</th>
  </tr>
  <tr>
    <td>{{$disposed}} devices</td>
  </tr>
</table>

<table>
  <tr>
    <th>Serial</th>
    <th>Model</th>
    <th>Hardware Type</th>
    <th>Brand</th>
    <th>Processor</th>
    <th>RAM</th>
    <th>Storage</th>
    <th>Storage Type</th>
    <th>Purchased</th>
    <th>Warranty</th>
    <th>Status</th>
  </tr>
  @foreach($hardwares as $hardware)
  <tr>
    <td>{{$hardware->serial}}</td>
    <td>{{$hardware->model_name}}</td>
    <td>{{$hardware->hardware_type}}</td>
    <td>{{$hardware->brand}}</td>
    <td>{{$hardware->processor}}</td>
    <td>{{$hardware->ram}}</td>
    <td>{{$hardware->storage}}</td>
    <td>{{$hardware->storage_type}}</td>
    <td>{{$hardware->purchased_date->format('M d, Y')}}</td>
    <td>{{$hardware->warranty_date->format('M d, Y')}}</td>
    <td>{{$hardware->status}}</td>
  </tr>
  @endforeach
</table>