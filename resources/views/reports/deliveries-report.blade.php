<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Delivery Report</title>
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
        <h1>Deliveries Report</h1>
        <p>As of {{date('M d, Y')}}</p>
      </div>
      <div class="row">
        <div class="col-sm-6">
          {!! $deliveries->html() !!}
        </div>
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-body">
              <h3>Total Laptops: {{$laptop_count}}</h3>
              <h3>Total Desktops: {{$desktop_count}}</h3>
              <h3>Total Deliveries: {{$delivery_count}}</h3>
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
    {!! $deliveries->script() !!}
  </body>
</html>
