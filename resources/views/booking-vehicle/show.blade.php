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
        locale: 'th',
        buttonIcons: false, // show the prev/next text
        weekNumbers: false,
        navLinks: true, // can click day/week names to navigate views
        // editable: true,
        eventLimit: false, // allow "more" link when too many events
        events: [
            @foreach($rs as $key=>$row)
            {
                shortTitle: '[{{ $row->code }}] {{ $row->gofor }} ({{ $row->status }})',
                title: 'สถานะ: {{ $row->status }}\n{{ $row->gofor }}\nรายละเอียดรถ: {{ @$row->st_vehicle->st_vehicle_type->name }} {{ @$row->st_vehicle->brand }} {{ @$row->st_vehicle->seat }} ที่นั่ง {{ @$row->st_vehicle->color }} ทะเบียน {{ @$row->st_vehicle->reg_number }}\nสถานที่ขึ้นรถ: {{ $row->point_place }} เวลา {{ $row->point_time }}\nสถานที่ไป: {{ $row->destination }}',
                start: '{{ $row->start_date }}T{{ $row->start_time }}',
                end: '{{ $row->end_date }}T{{ $row->end_time }}',
                color: "{{ colorStatus($row->status) }}",
            },
            @endforeach
        ],
        eventTimeFormat: { // like '14:30:00'
            hour: '2-digit',
            minute: '2-digit',
            // second: '2-digit'
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

<h3>จองยานพาหนะ</h3>

<div id="btnBox">
 <a href="{{ url('booking-vehicle') }}">	<img src="{{ url('images/view_list.png') }}" class="vtip" title="ดูมุมมองรายการ"></a>
</div>
<br clear="all">

@include('include._color_status')

<div id='calendar'></div>

@endsection