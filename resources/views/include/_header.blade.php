<!--====== NAV HEADER PART START ======-->
<nav class="navbar navbar-default bg-primary-light" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="{{ asset('images/logo-eReservation.png') }}" alt="logo" class="pt-1 pr-1">
        </div>
        <div id="app-navbar-collapse" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                @if(CanPerm('booking-room-view') || CanPerm('booking-room-conference-view'))
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ url('images/booking_room.png') }}" width="32" height="32" />
                        จองห้องประชุม/อบรม <span class="caret"></span></a>
                    <ul class="dropdown-menu submenu" style="height:auto; max-height:450px; overflow-x: hidden;">
                        @if(CanPerm('booking-room-view'))<li><a href="{{ url('/booking-room') }}">ห้องประชุม</a></li>@endif
                        @if(CanPerm('booking-room-conference-view'))<li><a href="{{ url('/booking-room-conference') }}">ห้อง Conference</a></li>@endif
                    </ul>
                </li>
                @endif

                @if(CanPerm('booking-vehicle-view'))<li><a href="{{ url('/booking-vehicle') }}"><img src="{{ url('images/booking_vehicle.png') }}" width="32" height="32" /> จองยานพาหนะ</a></li>@endif

                @if(CanPerm('booking-boss-view'))<li><a href="{{ url('booking-boss') }}"><img src="{{ url('images/booking_boss.png') }}" width="32" height="32">จองวาระผู้บริหาร</a></li>@endif

                @if(CanPerm('booking-resource-view'))<li><a href="{{ url('/booking-resource') }}"><img src="{{ url('images/booking_rt.png') }}" width="32" height="32" /> จองทรัพยากรอื่นๆ</a></li>@endif

                @if(CanPerm('report-1-view') || CanPerm('report-2-view') || CanPerm('log-view'))
                <li><a href="{{ url('/report') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ url('images/report.png') }}" width="32" height="32" /> รายงาน <span class="caret"></span></a>
                    <ul class="dropdown-menu submenu" style="height:auto; max-height:450px; overflow-x: hidden;">
                        @if(CanPerm('report-1-view'))<li><a href="{{ url('report1') }}">รายงานการจองห้องประชุม</a></li>@endif
                        @if(CanPerm('report-2-view'))<li><a href="{{ url('report2') }}">รายงานการจองยานพาหนะ</a></li>@endif
                        @if(CanPerm('report-3-view'))<li><a href="{{ url('report3') }}">รายงานการจองทรัพยากร</a></li>@endif
                        @if(CanPerm('report-4-view'))<li><a href="{{ url('report4') }}">รายงานการจองวาระผู้บริหาร</a></li>@endif
                        @if(CanPerm('log-view'))<li><a href="{{ url('/log') }}">ประวัติการใช้งาน</a></li>@endif
                    </ul>
                </li>
                @endif
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if(CanPerm('user-view') || CanPerm('permission-group-view') || CanPerm('st-room-view') || CanPerm('st-vehicle-view') || CanPerm('st-driver-view') || CanPerm('st-vehicle-type-view'))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ url('images/setting.png') }}" width="24" height="24" />
                        ตั้งค่าข้อมูลหลัก <span class="caret"></span></a>
                    <ul class="dropdown-menu submenu" style="height:auto; max-height:450px; overflow-x: hidden;">
                        @if(CanPerm('user-view'))<li><a href="{{ url('/setting/user') }}">ผู้ใช้งาน</a></li>@endif
                        @if(CanPerm('permission-group-view'))<li><a href="{{ url('/setting/permission-group') }}">สิทธิ์การใช้งาน</a></li>@endif
                        <li role="separator" class="divider"></li>
                        @if(CanPerm('st-room-view'))<li><a href="{{ url('/setting/st-room') }}">ห้องประชุม</a></li>@endif
                        @if(CanPerm('st-vehicle-view'))<li><a href="{{ url('/setting/st-vehicle') }}">ยานพาหนะ</a></li>@endif
                        @if(CanPerm('st-driver-view'))<li><a href="{{ url('/setting/st-driver') }}">พนักงานขับรถ</a></li>@endif
                        @if(CanPerm('st-vehicle-type-view'))<li><a href="{{ url('/setting/st-vehicle-type') }}">ประเภทรถ</a></li>@endif
                        <li role="separator" class="divider"></li>
                        @if(CanPerm('st-resource-view'))<li><a href="{{ url('/setting/st-resource') }}">ทรัพยากร</a></li>@endif
                        @if(CanPerm('st-boss-view'))<li><a href="{{ url('/setting/st-boss') }}">ผู้บริหาร</a></li>@endif
                        @if(CanPerm('st-position-level-view'))<li><a href="{{ url('/setting/st-position-level') }}">ระดับตำแหน่งผู้บริหาร</a></li>@endif
                        <li><a href="{{ url('/setting/st-position-meeting') }}">ตำแหน่งการประชุม/พิธี</a></li>
                    </ul>
                </li>
                @endif
                <li><a href="{{ url('profile') }}" class="vtip" title="ข้อมูลส่วนตัว"><img src="{{ url('images/user_info.png') }}" width="16" height="16" /></a></li>
                <li>
                    <a class="" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <!-- {{ __('Logout') }} -->
                        <img src="{{ url('images/logout.png') }}" width="16" height="16" class="vtip" title="ออกจากระบบ" />
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

        </div>
        <!--/.nav-collapse -->
    </div>
</nav>

<div style="font-size: 10px; line-height: 15px; z-index:9;" class="col-md-12 text-right info">
    {{ @Auth::user()->prefix->title }} {{ @Auth::user()->givename }} {{ @Auth::user()->familyname }}
    <br>{{ @Auth::user()->department->title }}
    <br>{{ @Auth::user()->bureau->title }}
    <br>{{ @Auth::user()->division->title }}
    <br>[{{ @Auth::user()->permission_group->title }}]
</div>