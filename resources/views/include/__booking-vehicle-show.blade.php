@extends( $from == 'backend' ? 'layouts.admin' : 'layouts.front')

@section('content')

@php
    $action = ($from == 'backend' ? 'booking-vehicle' : 'booking-vehicle-front');
    $st_vehicles = App\Model\StVehicle::where('status', 'พร้อมใช้')->orderBy('id', 'asc')->get();
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'list'],
            buttonText: {
                list: 'รายการ',
                prev: 'เดือนก่อนหน้า',
                next: 'เดือนถัดไป',
            },
            customButtons: {
                addBtn: {
                    text: '+ ขอจองยานพาหนะ',
                    click: function() {
                        window.location.href = "/{{ $action }}/create";
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
            displayEventTime: false,
            select: function(arg) {
                // console.log(arg.startStr);
                window.location.href = "/{{ $action }}/create?start_date=" + arg.startStr;
            },
            events: [
                @foreach($rs as $key => $row) {
                    {!! getVehicleCboxDetail($row) !!}
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
                $.colorbox({
                    html: '<div style="padding:15px;">'+info.event.title.replace(/\n/g, "<br />")+'</div>',
                    width: "50%",
                });
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
 <a href="{{ $from == 'backend' ? url('booking-vehicle') : url('') }}"><img src="{{ $from == 'backend' ? url('images/view_list.png') : url('images/home.png') }}" class="vtip" title="หน้าแรก" width="32"></a>
</div>

<h3>จองยานพาหนะ</h3>

<div id="search">
    <div id="searchBox">
        <form accept-charset="UTF-8" class="form-inline" role="search">

            <select name="st_vehicle_id" class="selectpicker" data-size="5" data-live-search="true" title="+ ยานพาหนะ +">
                <option value="">+ ยานพาหนะ +</option>
                @foreach($st_vehicles as $item)
                    <option value="{{ $item->id }}" @if(request('st_vehicle_id') == $item->id) selected="selected" @endif>
                        {{ @$item->st_vehicle_type->name }} {{ @$item->brand }} {{ !empty(@$item->seat) ? @$item->seat : '-' }} ที่นั่ง สี{{ @$item->color }} ทะเบียน {{ @$item->reg_number }}
                    </option>
                @endforeach
            </select>

            <input id="searchTxt" type="text" class="form-control" style="width:370px;" placeholder="รหัสการจอง" name="search" value="{{ request('search') }}">

            <button id="searchRoomBtn" type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>

        </form>
    </div>
</div>

@include('include._color_status')

<div id='calendar'></div>

@endsection