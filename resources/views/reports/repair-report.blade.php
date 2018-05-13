<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Assets Under Repair Report</title>
    <style media="screen">
      body
      {
        font-family:'Arial';
      }
    </style>
    {!! Charts::styles() !!}
  </head>
  <body>
    <div class="container">
      <div class="jumbotron">
        <h1>Under Repair Assets Report</h1>
        <p>As of {{date('M d, Y')}}</p>
      </div>
      <div class="row">
        <div class="col-sm-6">
          {!! $repair->html() !!}
        </div>
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <h3>Total Laptops Under Repair: {{$laptop_count}}</h3>
              <h3>Total Desktops Under Repair: {{$desktop_count}}</h3>
              <h3>Total Devices Under Repair: {{$repair_count}}</h3>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
         <div class="col-sm-6">

         </div>
      </div>
    </div>


    {!! Charts::scripts() !!}
    {!! $repair->script() !!}
  </body>
</html>
