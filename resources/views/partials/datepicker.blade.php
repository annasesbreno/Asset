<div class="col-sm-2 pull-right">
  <select class="form-control" onchange="location = this.value;">
    @if(Request::is('home'))
    <option value="">Choose Date Range</option>
    @elseif(Request::is('stats/today'))
    <option value="">Today</option>
    @elseif(Request::is('stats/yesterday'))
    <option value="">Yesterday</option>
    @elseif(Request::is('stats/week'))
    <option value="">Last 7 Days</option>
    @elseif(Request::is('stats/month'))
    <option value="">This Month</option>
    @elseif(Request::is('stats/last-month'))
    <option value="">Last Month</option>
    @endif
  <option value="{{url('/home')}}">Default</option>
  <option value="{{url('stats/today')}}">Today</option>
  <option value="{{url('stats/yesterday')}}">Yesterday</option>
  <option value="{{url('stats/week')}}">Last 7 Days</option>
  <option value="{{url('stats/month')}}">This Month</option>
  <option value="{{url('stats/last-month')}}">Last Month</option>
  </select>
</div>
