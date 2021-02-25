@extends( $from == 'backend' ? 'layouts.admin' : 'layouts.front')

@section('content')

@php
    $action = ($from == 'backend' ? 'booking-resource' : 'booking-resource-front');
    $st_resources = App\Model\StResource::where('status', 1)->orderBy('name', 'asc')->get();
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
            buttonText: {
                list: 'รายการ',
                prev: 'เดือนก่อนหน้า',
                next: 'เดือนถัดไป',
            },
            customButtons: {
                addBtn: {
                    text: '+ ขอจองทรัพยากร',
                    click: function() {
                        window.location.href = "/{{ $action }}/create";
                    }
                }
            },
            header: {
                left: 'prev,next today',
                center: 'title',
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
                window.location.href = "/{{ $action }}/create?start_date=" + arg.startStr;
            },
            events: [
                @foreach($rs as $key => $row) {
                    shortTitle: '[{{ displyDateTime($row->start_date,$row->start_time,$row->end_date,$row->end_time) }}] [{{ $row->code }}] {{ $row->title }} ({{ $row->status }})',
                    title: '{{ $row->code }}\n<span style="color:#c9884c; font-size:16px;">สถานะ:</span> {{ $row->status }}\n<span style="color:#c9884c; font-size:16px;">ทรัพยากร:</span> {{ $row->stResource->name }}\n{{ $row->title }}',
                    start: '{{ $row->start_date }}T{{ $row->start_time }}',
                    end: '{{ $row->end_date }}T{{ $row->end_time }}',
                    color: "{{ colorStatus($row->status) }}",
                },
                @endforeach
            ],
            eventTimeFormat: { // like '14:30:00'
                hour: '2-digit',
                minute: '2-digit',
            },
            eventRender: function(info) {
                $(info.el.childNodes).find('.fc-title').text(info.event.extendedProps.shortTitle);
            },
            eventClick: function(info) {
                $.colorbox({
                    html: '<div style="padding:15px;">'+info.event.title.replace(/\n/g, "<br />")+'</div>',
                    width: "50%",
                });
            },
            // defaultDate: '2018-06-01', ให้แสดงที่กิจกรรมวันสุดท้าย
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
 <a href="{{ $from == 'backend' ? url('booking-resource') : url('') }}"><img src="{{ $from == 'backend' ? url('images/view_list.png') : url('images/home.png') }}" class="vtip" title="หน้าแรก" width="32"></a>
</div>

<h3>จองทรัพยากรอื่นๆ</h3>

<div id="search">
    <div id="searchBox">
        <form accept-charset="UTF-8" class="form-inline" role="search">

            <select name="st_resource_id" class="selectpicker" data-size="15" data-live-search="true" title="+ ทรัพยากร +">
                <option value="">+ ทรัพยากร +</option>
                @foreach($st_resources as $item)
                    <option value="{{ $item->id }}" @if(request('st_resource_id') == $item->id) selected="selected" @endif>{{ $item->name }}</option>
                @endforeach
            </select>

            <input id="searchTxt" type="text" class="form-control" style="width:370px;" placeholder="รหัสการจอง" name="search" value="{{ request('search') }}">
            <input type="hidden" name="searchform" value="1">
            <button id="searchRoomBtn" type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>

        </form>
    </div>
</div>

@if( @$_GET['searchform'] == 1)

    {{-- แสดงผลแบบตาราง --}}
    <a href="{{ $from == 'backend' ? url('booking-resource/show') : url('booking-resource-front/show') }}" class="btn btn-lg btn-warning pull-right" style="margin-bottom:10px;">กลับหน้าปฎิทิน</a>
    <h4>ผลการค้นหา</h4>
    <table class="table table-bordered table-striped sortable tblist">
        <thead>
            <tr>
                <th style="width:7%" class="nosort" data-sortcolumn="1" data-sortkey="1-0">รหัสการจอง</th>
                <th style="width:5%" class="nosort" data-sortcolumn="1" data-sortkey="2-0">ทรัพยากร</th>
                <th style="width:20%" class="nosort" data-sortcolumn="2" data-sortkey="3-0">หัวข้อ</th>
                <th style="width:15%" class="nosort" data-sortcolumn="3" data-sortkey="4-0">วัน เวลา ที่ต้องการใช้</th>
                <th style="width:13%" class="nosort" data-sortcolumn="4" data-sortkey="5-0">ผู้ขอใช้</th>
                <th style="width:5%" class="nosort" data-sortcolumn="5" data-sortkey="6-0">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rs as $key=>$row)
            <tr @if(($key % 2)==1) class="odd" @endif>
                <td nowrap="nowrap">{{ $row->code }}</td>
                <td nowrap="nowrap">{{ $row->stResource->name }}</td>
                <td>
                    <div class="topicMeeting">{{ $row->title }}</div>
                </td>
                <td>
                    <div class="boxStartEnd"><span class="start">เริ่ม</span> {{ DB2Date($row->start_date) }} {{ date("H:i", strtotime($row->start_time)) }} น.</div>
                    <div class="boxStartEnd"><span class="end">สิ้นสุด</span> {{ DB2Date($row->end_date) }} {{ date("H:i", strtotime($row->end_time)) }} น.</div>
                </td>
                <td>{{ $row->request_name }}
                    @if(empty(request('export')))
                    <img src="{{ url('images/detail.png') }}" class="vtip" title="{{ $row->department->title }} {{ $row->bureau->title }} {{ $row->division->title }}<br>
                    {{ $row->request_tel }} {{ $row->request_email }}" />
                    @endif
                </td>
                <td><span style="background-color:{{ colorStatus($row->status) }}; font-weight:bold; color:#000; padding:0 5px; border-radius:20px;">{{ $row->status }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>

@else

    {{-- แสดงผลแบบปฏิทิน --}}
    @include('include._color_status', [ 'allrow' => $rs_all, 'from' => $from, 'type'=>'resource' ])
    <div id='calendar'></div>

@endif

@endsection