@extends( $from == 'backend' ? 'layouts.admin' : 'layouts.front')

@section('content')

@php
    $action = ($from == 'backend' ? 'booking-room' : 'booking-room-front');
    $st_rooms = App\Model\StRoom::where('status', 1)->orderBy('name', 'asc')->get();
    $req_st_room_id = request('st_room_id') ?? App\Model\StRoom::where('is_default', 1)->first()->id;
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
                    text: '+ ขอจองห้องประชุม/อบรม',
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
                    title: 'สถานะ: {{ $row->status }}\nเรื่อง/หัวข้อการประชุม-อบรม: {{ $row->title }}\nประธานการประชุม: {{ $row->president_name }} ({{ $row->president_position }}) \nวัน-เวลา: {{ displyDateTime2($row->start_date,$row->start_time,$row->end_date,$row->end_time) }}\nผู้ขอใช้: {{ $row->request_name }} {{ $row->department->title }}, {{ $row->bureau->title }}, {{ $row->division->title }}\nโทรศัพท์: {{ $row->request_tel }}\nอีเมล์: {{ $row->request_email }}\nจำนวน: {{ $row->number }} คน\nห้องประชุม: {{ $row->st_room->name }}\nผู้รับผิดชอบห้องประชุม: {{ $row->st_room->res_name }}, โทร: {{ $row->st_room->res_tel }}',
                    start: '{{ $row->start_date }}T{{ $row->start_time }}',
                    end: '{{ $row->end_date }}T{{ $row->end_time }}',
                    color: "{{ colorStatus($row->status) }}",
                },
                @endforeach
            ],
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
            },
            eventRender: function(info) {
                $(info.el.childNodes).find('.fc-title').text(info.event.extendedProps.shortTitle);
            },
            eventClick: function(info) {
                // alert(info.event.title);
                $.colorbox({
                    html: '<div style="padding:15px;">'+info.event.title.replace(/\n/g, "<br />")+'</div>',
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
</style>

<div id="btnBox">
    <a href="{{ $from == 'backend' ? url('booking-room') : url('') }}"><img src="{{ $from == 'backend' ? url('images/view_list.png') : url('images/home.png') }}" class="vtip" title="หน้าแรก" width="32"></a>
</div>

<h3>จองห้องประชุม/อบรม</h3>

<div id="search">
    <div id="searchBox">
        <form accept-charset="UTF-8" class="form-inline" role="search">
            <select class="selectpicker goUrl" data-size="5" data-live-search="true" title="+ ห้องประชุม +">
                <option value="">+ ห้องประชุม +</option>
                @foreach($st_rooms as $item)
                    <option value="{{ url('booking-room-front/show?st_room_id='.$item->id.'&search='.request('search')) }}" @if(@$req_st_room_id == $item->id) selected="selected" @endif>{{ $item->name }}</option>
                @endforeach
            </select>
            <input type="hidden" name="st_room_id" value="{{ request('st_room_id') }}">
            <input id="searchTxt" type="text" class="form-control" style="width:370px;" placeholder="รหัสการจอง" name="search" value="{{ request('search') }}">
            <button id="searchRoomBtn" type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>
    </div>
</div>

@include('include._color_status')

<div class="text-center"><h1 id="roomName"></h1></div>
<div id='calendar'></div>

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