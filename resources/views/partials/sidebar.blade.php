<nav class="main-menu">
            <ul>
              <li>
                  <a href="{{url('/')}}">
                      <i class="fa fa-database fa-2x"></i>
                      <span class="nav-text">
                          Asset Manager v1.0
                      </span>
                  </a>

              </li>

                <li>
                    <a href="{{url('home')}}">
                        <i class="fa fa-home fa-2x"></i>
                        <span class="nav-text">
                            Dashboard
                        </span>
                    </a>

                </li>
                <li class="has-subnav">
                    <a href="{{url('deliveries')}}">
                        <i class="fa fa-truck fa-2x"></i>
                        <span class="nav-text">
                            Deliveries
                        </span>
                    </a>

                </li>
                <li class="has-subnav">
                    <a href="{{url('inventory')}}">
                       <i class="fa fa-dropbox fa-2x"></i>
                        <span class="nav-text">
                            Inventory
                        </span>
                    </a>

                </li>
                <li class="has-subnav">
                    <a href="{{url('deployed')}}">
                       <i class="fa fa-users fa-2x"></i>
                        <span class="nav-text">
                            Deployed
                        </span>
                    </a>

                </li>


                <li class="has-subnav">
                    <a href="{{url('servermon')}}">
                       <i class="fa fa-server fa-2x"></i>
                        <span class="nav-text">
                            Server Monitoring
                        </span>
                    </a>
                </li>

                <li class="has-subnav">
                    <a href="{{url('status')}}">
                       <i class="fa fa-exclamation  fa-2x"></i>
                        <span class="nav-text">
                            Network Status
                        </span>
                    </a>
                </li>

                <li class="has-subnav">
                    <a href="{{url('calendar')}}">
                       <i class="fa fa-calendar  fa-2x"></i>
                        <span class="nav-text">
                            Calendar
                        </span>
                    </a>
                </li>

                <li class="has-subnav">
                    <a href="{{url('disposed')}}">
                       <i class="fa fa-trash  fa-2x"></i>
                        <span class="nav-text">
                            Disposed Assets
                        </span>
                    </a>
                </li>

                <li class="has-subnav">
                    <a href="{{url('repair')}}">
                       <i class="fa fa-wrench  fa-2x"></i>
                        <span class="nav-text">
                            Under Repair
                        </span>
                    </a>
                </li>



                <li>
                    <a href="#">
                       <i class="fa fa-book fa-2x"></i>
                        <span class="nav-text">
                            Documentation
                        </span>
                    </a>
                </li>

                <li>
                    <a href="#" data-toggle="collapse" data-target="#toggleDemo">
                       <i class="fa fa-list fa-2x"></i>
                        <span class="nav-text">
                            Hardware Info
                        </span>
                    </a>

                    <div class="collapse" id="toggleDemo" style="height: 0px;">
                      <ul class="nav nav-list">
                        <li>
                          <a href="{{url('hardware-type')}}">
                             <i class="fa fa-desktop"></i> <span class="nav-text">Hardware Type</span>
                          </a>
                        </li>

                        <li>
                          <a href="{{url('brand')}}">
                             <i class="fa fa-tag"></i> <span class="nav-text">Brand</span>
                          </a>
                        </li>

                        <li>
                          <a href="{{url('processor')}}">
                             <i class="fa fa-hdd-o"></i> <span class="nav-text">Processor</span>
                          </a>
                        </li>

                        <li>
                          <a href="{{url('storage-type')}}">
                             <i class="fa fa-database"></i> <span class="nav-text">Storage Type</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                </li>


            </ul>

            <ul class="logout">
                <li>
                  <a href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                      <i class="fa fa-sign-out"></i> <span class="nav-text">Logout</span>
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
                </li>
            </ul>
        </nav>
