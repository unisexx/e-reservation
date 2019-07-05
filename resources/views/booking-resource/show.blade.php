@extends('layouts.admin')

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
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
        },
        // defaultDate: '2019-03-12',
        locale: 'th',
        buttonIcons: false, // show the prev/next text
        weekNumbers: false,
        navLinks: true, // can click day/week names to navigate views
        // editable: true,
        eventLimit: false, // allow "more" link when too many events
        events: [
            @foreach($rs as $key=>$row)
            {
                shortTitle: '[{{ $row->code }}] {{ $row->title }} ({{ $row->status }})',
                title: 'สถานะ: {{ $row->status }}\nทรัพยากร: {{ $row->stResource->name }}\n{{ $row->title }}',
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

<h3>จองทรัพยกรอื่นๆ</h3>

<div id="btnBox">
 <a href="{{ url('booking-resource') }}">	<img src="{{ url('images/view_list.png') }}" class="vtip" title="ดูมุมมองรายการ"></a>
</div>
<br clear="all">

<div id='calendar'></div>

@endsection