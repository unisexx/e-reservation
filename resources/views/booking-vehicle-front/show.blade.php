@extends('layouts.front')

@section('content')

<script>

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'list' ],
        buttonText: {
            list:   'รายการ',
            prev:   'เดือนก่อนหน้า',
            next:   'เดือนถัดไป',
        },
        customButtons: {
            addBtn: {
                text: '+ เพิ่มรายการ',
                click: function() {
                    window.location.href = "/booking-vehicle-front/create";
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
        select: function(arg) {
            // console.log(arg.startStr);
            window.location.href = "/booking-vehicle-front/create?start_date="+arg.startStr;
        },
        events: [
            @foreach($rs as $key=>$row)
            {
                shortTitle: '[{{ $row->code }}] {{ $row->gofor }} ({{ $row->status }})',
                title: '({{ $row->status }})\n{{ $row->gofor }}\nรายละเอียดรถ: {{ @$row->st_vehicle->st_vehicle_type->name }} {{ @$row->st_vehicle->brand }} {{ @$row->st_vehicle->seat }} ที่นั่ง {{ @$row->st_vehicle->color }} ทะเบียน {{ @$row->st_vehicle->reg_number }}\nสถานที่ขึ้นรถ: {{ $row->point_place }} เวลา {{ $row->point_time }}\nสถานที่ไป: {{ $row->destination }}',
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
            // console.log(info.view.type);
            // console.log(info.el.childNodes);
            // console.log(info.event.extendedProps.description);
            $(info.el.childNodes).find('.fc-title').text(info.event.extendedProps.shortTitle);
        },
        eventClick: function(info) {
            alert('Event: ' + info.event.title);
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

<div id='calendar'></div>

@endsection