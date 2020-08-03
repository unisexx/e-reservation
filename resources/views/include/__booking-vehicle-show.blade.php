@extends( $from == 'backend' ? 'layouts.admin' : 'layouts.front')

@section('content')

@php
    $action = ($from == 'backend' ? 'booking-vehicle' : 'booking-vehicle-front');
    $st_vehicles = App\Model\StVehicle::where('status', 'พร้อมใช้')->orderBy('id', 'asc')->get();

    // หน่วยงานที่รับผิดชอบ
    $st_departments = App\Model\StDepartment::orderBy('code', 'asc')->get();
    $st_department_code = request('st_department_code') ?? @old('st_department_code');
    $st_bureau_code = request('st_bureau_code') ?? @old('st_bureau_code');

    if ($st_department_code) $st_bureaus = App\Model\StBureau::where('code', 'like', $st_department_code . '%')->orderBy('code', 'asc')->get();
    if ($st_bureau_code) $st_divisions = App\Model\StDivision::where('code', 'like', $st_bureau_code . '%')->orderBy('code', 'asc')->get();
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

                // ถ้าเป็นหน้าลิสรายการ
                if (info.view.type == 'listMonth') {
                    // console.log($(info.el).find('a').html(info.event.title));
                    $(info.el).find('a').html(info.event.title)
                }		   

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

            {{-- <select name="st_vehicle_id" class="selectpicker" data-size="5" data-live-search="true" title="+ ยานพาหนะ +">
                <option value="">+ ยานพาหนะ +</option>
                @foreach($st_vehicles as $item)
                    <option value="{{ $item->id }}" @if(request('st_vehicle_id') == $item->id) selected="selected" @endif>
                        {{ @$item->st_vehicle_type->name }} {{ @$item->brand }} {{ !empty(@$item->seat) ? @$item->seat : '-' }} ที่นั่ง สี{{ @$item->color }} ทะเบียน {{ @$item->reg_number }}
                    </option>
                @endforeach
            </select> --}}

            <input id="searchTxt" type="text" class="form-control" style="width:370px;" placeholder="รหัสการจอง" name="search" value="{{ request('search') }}">

            <span class="form-inline dep-chain-group">
                <select name="st_department_code"  class="chain-department selectpicker" data-live-search="true" title="กรม" required>
                    <option value="">+ กรม +</option>
                    @foreach($st_departments as $item)
                    <option value="{{ $item->code }}" @if($item->code == (request('st_department_code') ?? @old('st_department_code'))) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                </select>

                <select name="st_bureau_code"  class="chain-bureau selectpicker" data-live-search="true" title="สำนัก" required>
                    <option value="">+ สำนัก +</option>
                    @if($st_department_code))
                    @foreach($st_bureaus as $item)
                    <option value="{{ $item->code }}" @if($item->code == (request('st_bureau_code') ?? @old('st_bureau_code'))) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>

                <select name="st_division_code"  class="chain-division selectpicker" data-live-search="true" title="กลุ่ม" required>
                    <option value="">+ กลุ่ม +</option>
                    @if($st_bureau_code)
                    @foreach($st_divisions as $item)
                    <option value="{{ $item->code }}" @if($item->code == (request('st_division_code') ?? @old('st_division_code'))) selected="selected" @endif>{{ $item->title }}</option>
                    @endforeach
                    @endif
                </select>
            </span>

            <button id="searchRoomBtn" type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>

        </form>
    </div>
</div>

@include('include._color_status', [ 'allrow' => $rs_all ])

<div id='calendar'></div>

@endsection