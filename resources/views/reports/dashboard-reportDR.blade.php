<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Stats Report</title>
    {!! Charts::styles() !!}
  </head>
  <body>
    <div class="container">
      <div class="jumbotron">
        <h1>Statistical Report</h1>
        <p>Date Range:
          {{Carbon\Carbon::parse($fromd)->format('M d, Y')}} -
          {{Carbon\Carbon::parse($tod)->format('M d, Y')}}</p>
      </div>
      <div class="row">
        <div class="col-sm-6">
          {!! $status->html() !!}
        </div>
        <div class="col-sm-6">
          {!! $hardware_type->html() !!}
        </div>
      </div>
      <hr>
      <div class="row">
         <div class="col-sm-6">
           {!! $vendor->html() !!}
         </div>
      </div>
    </div>


    {!! Charts::scripts() !!}
    {!! $status->script() !!}
    {!! $vendor->script() !!}
    {!! $hardware_type->script() !!}
  </body>
</html>
