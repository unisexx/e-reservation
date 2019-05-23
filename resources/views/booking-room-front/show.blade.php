@extends('layouts.front')

@section('content')

<script>

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        buttonText: {
            list:   'รายการ',
            prev:   'เดือนก่อนหน้า',
            next:   'เดือนถัดไป',
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
            window.location.href = "/booking-room-front/create?start_date="+arg.startStr;
        },
        events: [
            @foreach($rs as $key=>$row)
            {
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
            alert(info.event.title);
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

.fc-addBtn-button{
    color: #fff !important;
    background-color: #5cb85c !important;
    border-color: #4cae4c !important;
}

.fc-day-grid-event .fc-content{
    white-space: normal;
}
</style>

<h3>จองห้องประชุม</h3>

<div id='calendar'></div>

@endsection