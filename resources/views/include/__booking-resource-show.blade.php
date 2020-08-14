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
                    title: '{{ $row->code }}\nสถานะ: {{ $row->status }}\nทรัพยากร: {{ $row->stResource->name }}\n{{ $row->title }}',
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

            <button id="searchRoomBtn" type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>

        </form>
    </div>
</div>

@include('include._color_status', [ 'allrow' => $rs_all ])

<div id='calendar'></div>

@endsection