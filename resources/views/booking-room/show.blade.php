@extends('layouts.admin')

@section('content')

<script>

document.addEventListener('DOMContentLoaded', function() {
    var colorEvent = {'รออนุมัติ': '#ffc107', 'อนุมัติ': '#28a745', 'ไม่อนุมัติ': '#dc3545', 'ยกเลิก': '#6c757d'};
    var initialLocaleCode = 'en';
    var localeSelectorEl = document.getElementById('locale-selector');
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
            // right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        // defaultDate: '2019-03-12',
        locale: 'th',
        buttonIcons: false, // show the prev/next text
        weekNumbers: true,
        navLinks: true, // can click day/week names to navigate views
        // editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: [
            // {
            //     title: 'All Day Event',
            //     start: '2019-03-01'
            // },
            // {
            //     title: 'Long Event',
            //     start: '2019-03-07',
            //     end: '2019-03-10'
            // },
            // {
            //     groupId: 999,
            //     title: 'Repeating Event',
            //     start: '2019-03-09T16:00:00'
            // },
            // {
            //     groupId: 999,
            //     title: 'Repeating Event',
            //     start: '2019-03-16T16:00:00'
            // },
            // {
            //     title: 'Conference',
            //     start: '2019-03-11',
            //     end: '2019-03-13'
            // },
            // {
            //     title: 'Meeting',
            //     start: '2019-03-12T10:30:00',
            //     end: '2019-03-12T12:30:00'
            // },
            // {
            //     title: 'Lunch',
            //     start: '2019-03-12T12:00:00'
            // },
            // {
            //     title: 'Meeting',
            //     start: '2019-03-12T14:30:00'
            // },
            // {
            //     title: 'Happy Hour',
            //     start: '2019-03-12T17:30:00'
            // },
            // {
            //     title: 'Dinner',
            //     start: '2019-03-12T20:00:00'
            // },
            // {
            //     title: 'Birthday Party',
            //     start: '2019-03-13T07:00:00'
            // },
            // {
            //     title: 'Click for Google',
            //     url: 'http://google.com/',
            //     start: '2019-03-28'
            // },
            @foreach($rs as $key=>$row)
            {
                title: '[{{ $row->code }}] {{ $row->title }} ({{ $row->status }})',
                start: '{{ $row->start_date }}T{{ $row->start_time }}',
                end: '{{ $row->end_date }}T{{ $row->end_time }}',
                color: colorEvent["{{ $row->status }}"],
            },
            @endforeach
        ]
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
max-width: 900px;
margin: 40px auto;
padding: 0 10px;
}
</style>

<h3>จองห้องประชุม</h3>

<!-- @foreach($rs as $key=>$row)
    {{ 'title = '.$row->title }}
    {{ 'start = '.$row->start_date }}
    {{ 'start_time = '.$row->start_time }}
    {{ 'end = '.$row->end_date }}
    {{ 'end_time = '.$row->end_time }}
@endforeach -->

<div id="btnBox">
 <a href="{{ url('booking-room') }}">	<img src="{{ url('images/view_list.png') }}" class="vtip" title="ดูมุมมองรายการ"></a>
</div>
<br clear="all">

<div id='calendar'></div>

@endsection