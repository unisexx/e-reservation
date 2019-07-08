@extends('layouts.front')

@section('content')

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
                    text: '+ เพิ่มรายการ',
                    click: function() {
                        window.location.href = "/booking-room-front/create";
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
            select: function(arg) {
                // console.log(arg.startStr);
                window.location.href = "/booking-room-front/create?start_date=" + arg.startStr;
            },
            events: [
                @foreach($rs as $key => $row) {
                    shortTitle: '[{{ $row->code }}] {{ $row->title }} ({{ $row->status }})',
                    title: 'สถานะ: {{ $row->status }}\n{{ $row->title }}\nจำนวน: {{ $row->number }} คน\nห้องประชุม: {{ $row->st_room->name }}',
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
                    html: info.event.title.replace(/\n/g, "<br />")
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
 <a href="{{ url('') }}"><img src="{{ url('images/home.png') }}" class="vtip" title="หน้าแรก" width="32"></a>
</div>

<h3>จองห้องประชุม</h3>

<div id="search">
    <div id="searchBox">
        <form accept-charset="UTF-8" class="form-inline" role="search">

            <input id="searchTxt" type="text" class="form-control" style="width:370px;" placeholder="รหัสการจอง" name="search" value="{{ request('search') }}">

            <button id="searchRoomBtn" type="button" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>

        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#searchRoomBtn').click(function() {
            $.ajax({
                    url: '{{ url("ajaxGetBookingRoom") }}',
                    data: {
                        search: $("#searchTxt").val(),
                    }
                })
                .done(function(data) {
                    if (data.id) {
                        var url = '{{ url("booking-room-front/summary") }}' + '/' + data.id;
                        $.colorbox({
                            href: url,
                            open: true
                        });
                    } else {
                        $.colorbox({
                            html: " ไม่พบรหัสการจองนี้ในระบบ "
                        });
                    }
                });
        });
    });
</script>

@include('include._color_status')

<div id='calendar'></div>


@endsection