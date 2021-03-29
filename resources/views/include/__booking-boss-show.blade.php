@extends( $from == 'backend' ? 'layouts.admin' : 'layouts.front')

@section('content')

@php
    $action = ($from == 'backend' ? 'booking-boss' : 'booking-boss-front');
    $st_bosses = App\Model\StBoss::where('status', 1)->orderBy('order', 'asc')->get();

    // หน่วยงานที่รับผิดชอบ
    $st_departments = App\Model\StDepartment::orderBy('code', 'asc')->get();
    $st_department_code = request('st_department_code') ?? @old('st_department_code');
    $st_bureau_code = request('st_bureau_code') ?? @old('st_bureau_code');

    if ($st_department_code) $st_bureaus = App\Model\StBureau::where('code', 'like', $st_department_code . '%')->orderBy('code', 'asc')->get();
    if ($st_bureau_code) $st_divisions = App\Model\StDivision::where('code', 'like', $st_bureau_code . '%')->orderBy('code', 'asc')->get();
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'list'],
            buttonText: {
                list: 'รายการ',
                prev: 'เดือนก่อนหน้า',
                next: 'เดือนถัดไป',
            },
            customButtons: {
                addBtn: {
                    text: '+ จองวาระผู้บริหาร',
                    click: function() {
                        window.location.href = "/{{ $action }}/create?st_boss_id={{ @request('st_boss_id') }}";
                    }
                }
            },
            header: {
                left: 'prev,next today',
                center: 'title',
                // right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                right: 'dayGridMonth,listMonth addBtn'
            },
            // defaultDate: '2019-03-12',
            locale: 'th',
            buttonIcons: false, // show the prev/next text
            weekNumbers: false,
            navLinks: true, // can click day/week names to navigate views
            // editable: true,
            eventLimit: false, // allow "more" link when too many events
            selectable: true,
            selectMirror: true,
            displayEventTime: false,
            select: function(arg) {
                // console.log(arg.startStr);
                window.location.href = "/{{ $action }}/create?st_boss_id={{ @request('st_boss_id') }}&start_date=" + arg.startStr;
            },
            events: [
                @foreach($rs as $key => $row) {
                    {!! getBossCboxDetail($row) !!}
                },
                @endforeach
            ],
            eventTimeFormat: { // like '14:30:00'
                hour: '2-digit',
                minute: '2-digit',
                // second: '2-digit'
            },
            eventRender: function(info) {
                // console.log(info.view.type);
                // console.log(info.el.childNodes);
                // console.log(info.event.extendedProps.description);
                $(info.el.childNodes).find('.fc-title').html(info.event.extendedProps.shortTitle);

                // ถ้าเป็นหน้าลิสรายการ
                if (info.view.type == 'listMonth') {
                    // console.log($(info.el).find('a').html(info.event.title));
                    $(info.el).find('a').html(info.event.title)
                }		   

            },
            eventClick: function(info) {
                $.colorbox({
                    html: '<div style="padding:15px;">'+info.event.title.replace(/\n/g, "<br />")+'</div>',
                    width: "50%",
                });
                // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                // alert('View: ' + info.view.type);

                // change the border color just for fun
                // info.el.style.borderColor = 'red';
            }
        });

        calendar.render();
    });
</script>
<style>
    #top {
        background: #eee;
        border-bottom: 1px solid #ddd;
        padding: 0 10px;
        line-height: 40px;
        font-size: 12px;
    }

    #calendar {
        /* max-width: 90%; */
        margin: 40px auto;
        padding: 0 10px;
    }

    .fc-addBtn-button {
        color: #fff !important;
        background-color: #5cb85c !important;
        border-color: #4cae4c !important;
    }

    .fc-day-grid-event .fc-content {
        white-space: normal;
    }

    .fc-day-top {
        text-align: center !important;
    }
    .fc-ltr .fc-dayGrid-view .fc-day-top .fc-day-number{
        float:none;
    }
</style>

<div id="btnBox">
 <a href="{{ $from == 'backend' ? url('booking-boss') : url('') }}"><img src="{{ $from == 'backend' ? url('images/view_list.png') : url('images/home.png') }}" class="vtip" title="หน้าแรก" width="32"></a>
</div>

<h3>จองวาระผู้บริหาร</h3>

<div id="search">
    <div id="searchBox">
        <form accept-charset="UTF-8" class="form-inline" role="search">

            {{-- <select name="st_vehicle_id" class="selectpicker" data-size="10" data-live-search="true" title="+ ยานพาหนะ +">
                <option value="">+ ยานพาหนะ +</option>
                @foreach($st_vehicles as $item)
                    <option value="{{ $item->id }}" @if(request('st_vehicle_id') == $item->id) selected="selected" @endif>
                        {{ @$item->st_vehicle_type->name }} {{ @$item->brand }} {{ !empty(@$item->seat) ? @$item->seat : '-' }} ที่นั่ง สี{{ @$item->color }} ทะเบียน {{ @$item->reg_number }}
                    </option>
                @endforeach
            </select> --}}

            <input id="searchTxt" type="text" class="form-control" style="width:370px;" placeholder="รหัสการจอง" name="search" value="{{ request('search') }}">

            <span class="form-inline dep-chain-group">
                <select name="st_department_code"  class="chain-department selectpicker" data-live-search="true" title="กรม">
                    <option value="">+ กรม +</option>
                    @foreach($st_departments as $item)
                    <option value="{{ $item->code }}" @if($item->code == (request('st_department_code') ?? @old('st_department_code'))) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                </select>

                <select name="st_bureau_code"  class="chain-bureau selectpicker" data-live-search="true" title="สำนัก">
                    <option value="">+ สำนัก +</option>
                    @if($st_department_code))
                    @foreach($st_bureaus as $item)
                    <option value="{{ $item->code }}" @if($item->code == (request('st_bureau_code') ?? @old('st_bureau_code'))) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>

                <select name="st_division_code"  class="chain-division selectpicker" data-live-search="true" title="กลุ่ม">
                    <option value="">+ กลุ่ม +</option>
                    @if($st_bureau_code)
                    @foreach($st_divisions as $item)
                    <option value="{{ $item->code }}" @if($item->code == (request('st_division_code') ?? @old('st_division_code'))) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>
            </span>

            <input type="hidden" name="searchform" value="1">
            <button id="searchRoomBtn" type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>

        </form>
    </div>
</div>


@if( @$_GET['searchform'] == 1)

    {{-- แสดงผลแบบตาราง --}}
    <a href="{{ $from == 'backend' ? url('booking-boss/show') : url('booking-boss-front/show') }}" class="btn btn-lg btn-warning pull-right" style="margin-bottom:10px;">กลับหน้าปฎิทิน</a>
    <h4>ผลการค้นหา</h4>
    <table class="table table-bordered table-striped sortable tblist">
        <thead>
            <tr>
                <th style="width:5%">ลำดับ</th>
                <th style="width:8%">รหัสการจอง</th>
                <th style="width:15%">ชื่อผู้บริหาร</th>
                <th style="width:25%">ข้อมูลการจอง</th>
                <th style="width:15%">วัน เวลา นัดหมาย</th>
                <th style="width:15%">รายละเอียดผู้จอง</th>
                <th style="width:5%">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rs as $key=>$row)
            <tr @if(($key % 2)==1) class="odd" @endif>
                <td>{{ $key+1 }}</td>
                <td nowrap="nowrap">{{ $row->code }}</td>
                <td>{{ @$row->stBoss->name }} ({{ @$row->getBossStatusTxt() }})</td>
                <td>
                    <div class="topicMeeting">{{ @$row->title }}</div>
                    <div>{{ @$row->place }}</div>
                    <div>{{ @$row->owner }}</div>
                    <div>{{ @$row->tel }}</div>
                </td>
                <td>
                    <div class="boxStartEnd"><span class="start">เริ่ม</span> {{ DB2Date($row->start_date) }} {{ date("H:i", strtotime($row->start_time)) }} น.</div>
                    <div class="boxStartEnd"><span class="end">สิ้นสุด</span> {{ DB2Date($row->end_date) }} {{ date("H:i", strtotime($row->end_time)) }} น.</div>
                </td>
                <td>
                    {{ $row->request_name }}
                    @if(empty(request('export')))
                    <img src="{{ url('images/detail.png') }}" class="vtip" title="{{ $row->department->title }} {{ $row->bureau->title }} {{ $row->division->title }}<br>
                    {{ $row->request_tel }} {{ $row->request_email }}" />
                    @endif
                </td>
                <td>
                    <span style="background-color:{{ colorStatus($row->status) }}; font-weight:bold; color:#000; padding:0 5px; border-radius:20px;">{{ $row->status }}</span>
                    <div>{{ @$row->approver->prefix->title }} {{ @$row->approver->givename }} {{ @$row->approver->familyname }}</div>
                    <div>{{ DBToDate($row->approve_date,'true','true') }}</div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@else

    {{-- แสดงผลแบบปฏิทิน --}}
    @include('include._color_status', [ 'allrow' => $rs_all, 'from' => $from, 'type'=>'boss' ])

    <div id="bossSelectDiv" class="text-center" style="width:50%; margin: 0 auto;">
        <select class="selectpicker goUrl form-control" data-size="15" data-live-search="true" title="+ ผู้บริหาร +">
            @foreach($st_bosses as $item)
                <option 
                    value="{{ url($action.'/show?st_boss_id='.$item->id.'&search='.request('search').'&st_department_code='.request('st_department_code').'&st_bureau_code='.request('st_bureau_code').'&st_division_code='.request('st_division_code')) }}" 
                    @if(@request('st_boss_id') == $item->id) selected="selected" @endif  
                    data-content="<span class='badge' style='color:#000; background-color:{{ $item->color }}'>{{ @$item->abbr }}</span> {{ $item->name }} {{ @$item->stBossPosition->name ?? '-' }} {{ !empty(@$item->position_more) ? '('.@$item->position_more.')' : '' }}">
                ลิสต์รายการที่แสดงอยู่ใน data-content
                </option>
            @endforeach
        </select>
    </div>

    <div id='calendar'></div>

@endif

@endsection

@push('js')
<script>
    $(function(){
        // bind change event to select
        $('select.goUrl').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
    });
</script>
@endpush

@push('css')
<style>
    #bossSelectDiv .bootstrap-select.btn-group .dropdown-toggle .filter-option{
        font-size: 25px;
    }
    #bossSelectDiv .bootstrap-select > .dropdown-toggle{
        height: 55px !important;
    }
</style>
@endpush