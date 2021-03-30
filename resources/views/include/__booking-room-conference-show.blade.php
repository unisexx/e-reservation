@extends( $from == 'backend' ? 'layouts.admin' : 'layouts.front')

@section('content')

@php
    $action = ($from == 'backend' ? 'booking-room-conference' : 'booking-room-conference-front');

    $st_rooms = App\Model\StRoom::where('status', 1)->where('is_conference', 1)->orderBy('name', 'asc')->get();
    $req_st_room_id = request('st_room_id') ?? App\Model\StRoom::where('is_default', 1)->first()->id;
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
            // defaultView: window.mobilecheck() ? "listweek" : "dayGridWeek",
            buttonText: {
                list: 'รายการ',
                prev: 'เดือนก่อนหน้า',
                next: 'เดือนถัดไป',
            },
            customButtons: {
                addBtn: {
                    text: '+ ขอจองห้องประชุม/อบรม',
                    click: function() {
                        window.location.href = "/{{ $action }}/create?st_room_id={{ @$req_st_room_id }}";
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
                window.location.href = "/{{ $action }}/create?start_date=" + arg.startStr + "&st_room_id={{ @$req_st_room_id }}";
            },
            events: [
                @foreach($rs as $key => $row) {
                    shortTitle: '[{{ displyDateTime($row->start_date,$row->start_time,$row->end_date,$row->end_time) }}] [{{ $row->code }}] {{ $row->title }} ({{ $row->status }})',
                    title: '{{ $row->code }}\nสถานะ: {{ $row->status }}\nเรื่อง/หัวข้อการประชุม-อบรม: {{ $row->title }}\nประธานการประชุม: {{ $row->president_name }} ({{ $row->president_position }}) \nวัน-เวลา: {{ displyDateTime2($row->start_date,$row->start_time,$row->end_date,$row->end_time) }}\nผู้ขอใช้: {{ $row->request_name }} ({{ $row->request_position }})\nหน่วยงานผู้ขอใช้: {{ $row->department->title }}, {{ $row->bureau->title }}, {{ $row->division->title }}\nโทรศัพท์: {{ $row->request_tel }}\nอีเมล์: {{ $row->request_email }}\nจำนวน: {{ $row->number }} คน {!! @$row->internet_number > 0 ? "และขอใช้งานอินเตอร์เน็ต: ".$row->internet_number." คน" : "" !!} \nห้องประชุม: {{ $row->st_room->name }}\nผู้รับผิดชอบห้องประชุม: {{ $row->st_room->res_name }}, โทร: {{ $row->st_room->res_tel }}',
                    titleColorBox: '{{ $row->code }}\n<span style="color:#c9884c; font-size:16px;">สถานะ:</span> {{ $row->status }}\n<span style="color:#c9884c; font-size:16px;">เรื่อง/หัวข้อการประชุม-อบรม:</span> {{ $row->title }}\n<span style="color:#c9884c; font-size:16px;">ประธานการประชุม:</span> {{ $row->president_name }} ({{ $row->president_position }}) \n<span style="color:#c9884c; font-size:16px;">วัน-เวลา:</span> {{ displyDateTime2($row->start_date,$row->start_time,$row->end_date,$row->end_time) }}\n<span style="color:#c9884c; font-size:16px;">ผู้ขอใช้:</span> {{ $row->request_name }} ({{ $row->request_position }})\n<span style="color:#c9884c; font-size:16px;">หน่วยงานผู้ขอใช้:</span> {{ $row->department->title }}, {{ $row->bureau->title }}, {{ $row->division->title }}\n<span style="color:#c9884c; font-size:16px;">โทรศัพท์:</span> {{ $row->request_tel }}\n<span style="color:#c9884c; font-size:16px;">อีเมล์:</span> {{ $row->request_email }}\n<span style="color:#c9884c; font-size:16px;">จำนวน:</span> {{ $row->number }} คน {!! @$row->internet_number > 0 ? "และขอใช้งานอินเตอร์เน็ต: ".$row->internet_number." คน" : "" !!} \n<span style="color:#c9884c; font-size:16px;">ห้องประชุม:</span> {{ $row->st_room->name }}\n<span style="color:#c9884c; font-size:16px;">ผู้รับผิดชอบห้องประชุม:</span> {{ $row->st_room->res_name }}, โทร: {{ $row->st_room->res_tel }} \n{!! @$row->st_room->is_conference == 1 ? "<span style=\"color:#c9884c; font-size:16px;\">ขอใช้งาน conference:</span> ".$row->getConferenceTxt() : "" !!} \n{!! @$row->st_room->is_conference == 1 ? "<span style=\"color:#c9884c; font-size:16px;\">ผู้รับผิดชอบงาน conference:</span> ภูวดล โทร. 0 2202 9002, 08 7961 8121" : "" !!}',
                    start: '{{ $row->start_date }}T{{ $row->start_time }}',
                    end: '{{ $row->end_date }}T{{ $row->end_time }}',
                    color: "{{ colorStatus($row->status) }}",
                    imageurl: "{!! @$row->use_conference == 1 ? url('images/'.@$row->getStatusConferenceIcon()) : '' !!}",
                },
                @endforeach
            ],
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
            },
            eventRender: function(info) {
                $(info.el.childNodes).find('.fc-title').text(info.event.extendedProps.shortTitle);
                if(info.event.extendedProps.imageurl){
                    $(info.el.childNodes).find('.fc-title').prepend(" <img src='" + info.event.extendedProps.imageurl +"' width='32' height='32'> ");
                }
            },
            eventClick: function(info) {
                // alert(info.event.title);
                $.colorbox({
                    html: '<div style="padding:15px;">'+info.event.extendedProps.titleColorBox.replace(/\n/g, "<br />")+'</div>',
                    width: "50%",
                });
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
    <a href="{{ $from == 'backend' ? url('booking-room-conference') : url('') }}"><img src="{{ $from == 'backend' ? url('images/view_list.png') : url('images/home.png') }}" class="vtip" title="หน้าแรก" width="32"></a>
</div>

<center><h1>{{ @$_GET['st_province_code'] == 10 ? 'สำหรับส่วนกลาง' : 'สำหรับส่วนภูมิภาค' }}</h1></center>
<h3>จองห้องประชุม/อบรม Conference ({{ @$_GET['st_province_code'] == 10 ? 'ส่วนกลาง' : @getProviceName(@$_GET['st_province_code']) }})</h3>

<div id="search">
    <div id="searchBox">
        <form accept-charset="UTF-8" class="form-inline" role="search">
            <input id="searchTxt" type="text" class="form-control" style="width:80%;" placeholder="รหัสการจอง / ชื่อผู้ขอจอง" name="search" value="{{ request('search') }}">
            <input type="hidden" name="searchform" value="1">
            <button id="searchRoomBtn" type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>
    </div>
</div>


@if( @$_GET['searchform'] == 1)

    {{-- แสดงผลแบบตาราง --}}
    <a href="{{ $from == 'backend' ? url('booking-room-conference/show') : url('booking-room-conference-front/show') }}" class="btn btn-lg btn-warning pull-right" style="margin-bottom:10px;">กลับหน้าปฎิทิน</a>
    <h4>ผลการค้นหา</h4>
    <table class="table table-bordered table-striped sortable tblist">
        <thead>
            <tr>
                <th style="width:10%" class="nosort" data-sortcolumn="1" data-sortkey="1-0">รหัสการจอง</th>
                <th style="width:30%" class="nosort" data-sortcolumn="2" data-sortkey="2-0">หัวข้อการประชุม / ห้องประชุม</th>
                <th style="width:15%" class="nosort" data-sortcolumn="3" data-sortkey="3-0">วัน เวลา ที่ต้องการใช้ห้อง</th>
                <th style="width:15%" class="nosort" data-sortcolumn="4" data-sortkey="4-0">ผู้ขอใช้ห้องประชุม</th>
                <th style="width:8%" class="nosort" data-sortcolumn="5" data-sortkey="5-0">สถานะจองห้อง</th>
                <th style="width:8%" class="nosort" data-sortcolumn="5" data-sortkey="5-0">สถานะ Conference</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rs as $key=>$row)
            <tr @if(($key % 2)==1) class="odd" @endif>
                <td nowrap="nowrap">{{ $row->code }}</td>
                <td>
                    <div class="topicMeeting">{{ $row->title }}</div>
                    {{ $row->st_room->name }}
                    @if(empty(request('export')))
                    <img src="{{ url('images/detail.png') }}" class="vtip" title="
                    <u>จำนวนคนที่รองรับได้</u> {{ $row->st_room->people }} คน<br>
                    <u>อุปกรณ์ที่ติดตั้งในห้อง</u> {{ $row->st_room->equipment }}<br>
                    <u>ผู้รับผิดชอบห้องประชุม</u> {{ $row->st_room->res_name }} {{ $row->st_room->department->title }} {{ $row->st_room->bureau->title }}<br>{{ $row->st_room->division->title }}<br>
                    <u>ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม</u> {{ $row->st_room->fee }}" />
                    @endif
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
                <td>
                    <span style="background-color:{{ colorStatus($row->status) }}; font-weight:bold; color:#000; padding:0 5px; border-radius:20px;">{{ $row->status }}</span>
                    <div>{{ @$row->approver->prefix->title }} {{ @$row->approver->givename }} {{ @$row->approver->familyname }}</div>
                    <div>{{ DBToDate($row->approve_date,'true','true') }}</div>
                </td>
                <td>
                    <span style="background-color:{{ @colorStatus($row->status_conference) }}; font-weight:bold; color:#000; padding:0 5px; border-radius:20px;">{{ $row->status_conference }}</span>
                    <div>{{ @$row->conferenceApprover->prefix->title }} {{ @$row->conferenceApprover->givename }} {{ @$row->conferenceApprover->familyname }}</div>
                    <div>{{ DBToDate($row->approve_conference_date,'true','true') }}</div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@else

    {{-- แสดงผลแบบปฏิทิน --}}
    @include('include._color_status', ['type'=>'conference','from' => $from])
    @include('include._conference_status', ['type'=>'conference','from' => $from])

    @php
        $conference_path = request('is_conference') == 1 ? '&is_conference=1' : '';
    @endphp
    @if(!request('is_conference'))
    <div class="text-center" style="width:50%; margin: 0 auto;">
        <select class="selectpicker goUrl form-control" data-size="15" data-live-search="true" title="+ ห้องประชุม +">
            @foreach($st_rooms as $item)
                <option value="{{ url($action.'/show?st_room_id='.$item->id.'&search='.request('search').@$conference_path) }}" @if(@$req_st_room_id == $item->id) selected="selected" @endif>{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    @else
    <div class="text-center" style="width:50%; margin: 0 auto;">
        <h1>รายการห้อง Conference</h1>
    </div>
    @endif

    <div id='calendar'></div>

@endif

@endsection

@push('js')
<script>
$(document).ready(function(){
    if($("select.goUrl option:selected").val()){
        $('#roomName').text($("select.goUrl option:selected").text());
    }
});
</script>

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
    .bootstrap-select.btn-group .dropdown-toggle .filter-option{
        font-size: 25px;
    }
    .bootstrap-select > .dropdown-toggle{
        height: 55px !important;
    }
</style>
@endpush