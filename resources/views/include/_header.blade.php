<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Branding Image -->
            <a class="navbar-brand">e-Reservation</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/booking_room') }}"><img src="{{ url('images/booking_room.png') }}" width="32"
                            height="32" /> จองห้องประชุม</a></li>
                <li><a href="{{ url('/booking_vehicle') }}"><img src="{{ url('images/booking_vehicle.png') }}"
                            width="32" height="32" /> จองยานพาหนะ</a></li>
                <li><a href="{{ url('/report') }}" class="dropdown-toggle" data-toggle="dropdown" role="button"
                        aria-haspopup="true" aria-expanded="false"><img src="{{ url('images/report.png') }}" width="32"
                            height="32" /> รายงาน <span class="caret"></span></a>
                    <ul class="dropdown-menu submenu" style="height:auto; max-height:450px; overflow-x: hidden;">
                        <li><a href="{{ url('/') }}">Report 1</a></li>
                        <li><a href="{{ url('/') }}">Report 2</a></li>
                        <li><a href="{{ url('/') }}">Report 3</a></li>
                        <li><a href="{{ url('/logfile') }}">ประวัติการใช้งาน</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false"><img src="{{ url('images/setting.png') }}" width="24" height="24" />
                        ตั้งค่าข้อมูลหลัก <span class="caret"></span></a>
                    <ul class="dropdown-menu submenu" style="height:auto; max-height:450px; overflow-x: hidden;">
                        <li><a href="{{ url('/user') }}">ผู้ใช้งาน</a></li>
                        <li><a href="{{ url('/permission') }}">สิทธิ์การใช้งาน</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ url('/room') }}">ห้องประชุม</a></li>
                        <li><a href="{{ url('/vehicle') }}">ยานพาหนะ</a></li>
                        <li><a href="{{ url('/driver') }}">พนักงานขับรถ</a></li>
                        <li><a href="{{ url('/vehicle_type') }}">ประเภทรถ</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/user/form') }}" class="vtip" title="{{ Auth::user()->name }}"><img
                            src="{{ url('images/user_info.png') }}" width="16" height="16" /></a></li>
                <li>
                    <a class="" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <!-- {{ __('Logout') }} -->
                        <img src="{{ url('images/logout.png') }}" width="16" height="16" class="vtip" title="ออกจากระบบ" />
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

            <!--<ul class="nav navbar-nav navbar-right">
            <li><a href="../navbar/">Default</a></li>
            <li><a href="../navbar-static-top/">Static top</a></li>
            <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
          </ul>-->
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>