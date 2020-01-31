<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
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

                @if(CanPerm('booking-room-view'))<li><a href="{{ url('/booking-room') }}"><img src="{{ url('images/booking_room.png') }}" width="32" height="32" /> จองห้องประชุม/อบรม</a></li>@endif

                @if(CanPerm('booking-vehicle-view'))<li><a href="{{ url('/booking-vehicle') }}"><img src="{{ url('images/booking_vehicle.png') }}" width="32" height="32" /> จองยานพาหนะ</a></li>@endif

                @if(CanPerm('booking-resource-view'))<li><a href="{{ url('/booking-resource') }}"><img src="{{ url('images/booking_rt.png') }}" width="32" height="32" /> จองทรัพยากรอื่นๆ</a></li>@endif

                <?php
                    if(CanPerm('report-1-view') || CanPerm('report-2-view') || CanPerm('log-view')):
                ?>
                <li><a href="{{ url('/report') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ url('images/report.png') }}" width="32" height="32" /> รายงาน <span class="caret"></span></a>
                    <ul class="dropdown-menu submenu" style="height:auto; max-height:450px; overflow-x: hidden;">
                        @if(CanPerm('report-1-view'))<li><a href="{{ url('report1') }}">รายงานการใช้ห้องประชุม</a></li>@endif
                        @if(CanPerm('report-2-view'))<li><a href="{{ url('report2') }}">รายงานการใช้ยานพาหนะ</a></li>@endif
                        @if(CanPerm('report-3-view'))<li><a href="{{ url('report3') }}">รายงานการใช้ทรัพยากร</a></li>@endif
                        @if(CanPerm('log-view'))<li><a href="{{ url('/log') }}">ประวัติการใช้งาน</a></li>@endif
                    </ul>
                </li>
                <?php endif;?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php
                    if(CanPerm('user-view') || CanPerm('permission-group-view') || CanPerm('st-room-view') || CanPerm('st-vehicle-view') || CanPerm('st-driver-view') || CanPerm('st-vehicle-type-view')):
                ?>
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
                    </ul>
                </li>
                <?php endif;?>
                <li><a href="{{ url('profile') }}" class="vtip" title="{{ @Auth::user()->prefix->title }} {{ @Auth::user()->givename }} {{ @Auth::user()->familyname }} [{{ @Auth::user()->permission_group->title }}]"><img src="{{ url('images/user_info.png') }}" width="16" height="16" /></a></li>
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

            <!--<ul class="nav navbar-nav navbar-right">
            <li><a href="../navbar/">Default</a></li>
            <li><a href="../navbar-static-top/">Static top</a></li>
            <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
          </ul>-->
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>