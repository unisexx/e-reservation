@extends('layouts.bs5')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="row">
            <div class="card-body">
                <h1 class="name-table">ปฏิทินงาน</h1>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    @import url("https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

    html,
    body {
      margin: 0;
      padding: 0;
      font-family: "Sarabun" !important;
      font-size: 1.1em;
      font-weight: 600;
    }

    #calendar {
      margin: 40px auto;
    }
    .fc .fc-toolbar-title { font-size: 1.5em;}
    .name-table{ font-family: "Prompt"; font-size: 2.5em; color: #7033c2; font-weight: 200; }
    .fc-scrollgrid-section-header th {  font-family: "Sarabun", sans-serif;  background: #9675ce !important;  color: #fff;  text-decoration: none !important;}
    .fc-timeline-event { border-radius: 4px; margin:2px; vertical-align: middle;}
    .fc .fc-datagrid-cell-cushion{font-weight: 700;}
    .fc .fc-timeline-header-row-chrono .fc-timeline-slot-frame {  justify-content: center;}
    .fc-resource-timeline-divider .table-active{border: 1px solid #ddd !important;}
    .fc-h-event .fc-event-main {color:black;padding: 2px; }
    .fc-theme-bootstrap a:not([href]) { text-decoration: none;}
    .fc td, .fc th{padding: 0;  vertical-align: top;}
    .fc td {border: 1px solid #ddd;border-bottom: 1px solid #ddd !important;}
</style>
@endpush

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                right: 'resourceTimelineDay,resourceTimelineWeek prev,next',
                left: 'title',
            },
            now: '{{ date('Y-m-d') }}',
            aspectRatio: 2.2,
            themeSystem: 'bootstrap',
            initialView: 'resourceTimelineDay', //รูปแบบการแสดงผล 
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',//ระบุ license ใช้งาน license ประเภทใด
            timeZone: 'Asia/Bangkok',
            locale: 'th',    // กำหนดให้แสดงภาษาไทย

            titleFormat: { // something like "Tuesday, September 18, 2564"
                month: 'long',
                year: 'numeric',
                day: 'numeric',
                weekday: 'long'
            },
            firstDay: 1, // กำหนดวันแรกในปฏิทินเป็นวันอาทิตย์ 0 เป็นวันจันทร์ 1

            slotDuration: '00:30:00', // 1/2 hours
            scrollTime: '00:00',
            slotMinTime: '06:00', //start time to be shown in the grid
            slotMaxTime: '24:00', //end time to be shown in the grid 
            slotLabelFormat: {
                hour: 'numeric',
                minute: '2-digit',
                omitZeroMinute: false,
                hour12: false,

            },
            views: {
                resourceTimelineDay: {
                    buttonText: 'วันนี้',
                    slotDuration: '00:30'
                },
                resourceTimelineWeek: {
                    type: "resourceTimelineWeek",
                    slotDuration: { days: 1 },
                    slotLabelInterval: { days: 1 },
                    slotLabelFormat: [
                        { day: 'numeric' } // lower level of text
                    ],
                    buttonText: 'สัปดาห์'
                }
            },

            // ข้อมูลตัวอย่าง
            resourceAreaHeaderContent: 'ผู้บริหาร',
            resources: [
                @foreach($bosses as $boss)
                {
                    id: 'boss-{{ $boss->id }}',
                    title: '{{ $boss->name }}',
                    eventColor: '#75c5e3'
                },
                @endforeach
            ],
            events: [
                @foreach($bookingbosses as $bookingboss)
                {
                    id: '{{ $bookingboss->id }}',
                    resourceId: 'boss-{{ $bookingboss->st_boss_id }}',
                    start: '{{ $bookingboss->start_date }}T{{ $bookingboss->start_time }}',
                    end: '{{ $bookingboss->end_date }}T{{ $bookingboss->end_time }}',
                    title: '{{ $bookingboss->title }}',
                    // className: 'info'
                },
                @endforeach
            ],

        });

        calendar.render();

    });
</script>
@endpush