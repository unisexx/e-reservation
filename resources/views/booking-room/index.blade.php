@extends('layouts.admin')

@section('content')

<h3>จองห้องประชุม</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('booking-room') }}" accept-charset="UTF-8" class="form-inline" role="search">

            <input type="text" class="form-control" style="width:370px;" placeholder="รหัสการจอง / หัวข้อการประชุม / ผู้ขอใช้ห้องประชุม" name="search" value="{{ request('search') }}">

            <select name="date_type" class="form-control">
                <option value="start_date" @if(request('date_type') == 'start_date') selected @endif>วันที่เริ่ม</option>
                <option value="end_date" @if(request('date_type') == 'end_date') selected @endif>วันที่สิ้นสุด</option>
            </select>

            <input name="date_select" type="text" class="form-control fdate datepicker" value="{{ request('date_select') }}" style="width:100px;" />

            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>


    </div>
</div>

{{-- @if(CanPerm('st-vehicle-type-create')) --}}
<div id="btnBox"> <a href="{{ url('/booking-room/calendar') }}"><img src="{{ url('images/view_calendar.png') }}" class="vtip" title="ดูมุมมองปฎิทิน" /></a>
    <input type="button" title="export excel" value="export excel" class="btn vtip" />
    <input type="button" title="จองห้องประชุม" value="จองห้องประชุม" onclick="document.location='{{ url('/booking-room/create') }}'" class="btn btn-success vtip" />
</div>
{{-- @endif --}}

<div class="pagination-wrapper">
    {!! $rs->appends(['search' => Request::get('search')])->render() !!}
</div>

<table class="table table-bordered table-striped sortable tblist">
    <thead>
    <tr>
        <th style="width:5%" class="nosort" data-sortcolumn="0" data-sortkey="0-0">ลำดับ</th>
        <th style="width:10%" class="nosort" data-sortcolumn="1" data-sortkey="1-0">รหัสการจอง</th>
        <th style="width:30%" class="nosort" data-sortcolumn="2" data-sortkey="2-0">หัวข้อการประชุม / ห้องประชุม</th>
        <th style="width:15%" class="nosort" data-sortcolumn="3" data-sortkey="3-0">วัน เวลา ที่ต้องการใช้ห้อง</th>
        <th style="width:15%" class="nosort" data-sortcolumn="4" data-sortkey="4-0">ผู้ขอใช้ห้องประชุม</th>
        <th style="width:5%" class="nosort" data-sortcolumn="5" data-sortkey="5-0">สถานะ</th>
        <th style="width:5%" class="nosort" data-sortcolumn="6" data-sortkey="6-0">จัดการ</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rs as $key=>$row)
    <tr @if(($key % 2)==1) class="odd" @endif>
        <td>{{ (($rs->currentPage() - 1 ) * $rs->perPage() ) + $loop->iteration }}</td>
        <td nowrap="nowrap">{{ $row->code }}</td>
        <td>
            <div class="topicMeeting">{{ $row->title }}</div>
            {{ $row->st_room->name }} <img src="{{ url('images/detail.png') }}" class="vtip" title="
            <u>จำนวนคนที่รับรองได้</u> {{ $row->st_room->people }} คน<br>
            <u>อุปกรณ์ที่ติดตั้งในห้อง</u> {{ $row->st_room->equipment }}<br>
            <u>ผู้รับผิดชอบห้องประชุม</u> {{ $row->st_room->res_name }} {{ $row->st_room->department->title }} {{ $row->st_room->bureau->title }}<br>{{ $row->st_room->division->title }}<br>
            <u>ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม</u> {{ $row->st_room->fee }}" />
        </td>
        <td>
            <div class="boxStartEnd"><span class="start">เริ่ม</span> {{ DB2Date($row->start_date) }} {{ date("H:i", strtotime($row->start_time)) }} น.</div>
            <div class="boxStartEnd"><span class="end">สิ้นสุด</span> {{ DB2Date($row->end_date) }} {{ date("H:i", strtotime($row->end_time)) }} น.</div>
        </td>
        <td>{{ $row->request_name }} <img src="{{ url('images/detail.png') }}" class="vtip" title="{{ $row->department->title }} {{ $row->bureau->title }} {{ $row->division->title }}<br>
        {{ $row->request_tel }} {{ $row->request_email }}" /></td>
        <td>{{ $row->status }}</td>
        <td>
            {{-- @if(CanPerm('st-vehicle-type-edit')) --}}
            <a href="{{ url('booking-room/' . $row->id . '/edit') }}" title="แก้ไขรายการนี้">
                <img src="{{ url('images/edit.png') }}" width="24" height="24" class="vtip" title="แก้ไขรายการนี้" />
            </a>
            {{-- @endif --}}
            
            
            {{-- @if(CanPerm('st-vehicle-type-delete')) --}}
            <form method="POST" action="{{ url('booking-room' . '/' . $row->id) }}" accept-charset="UTF-8" style="display:inline">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" title="ลบรายการนี้" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none; padding:0px;">
                    <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้" />
                </button>
            </form>
            {{-- @endif --}}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

<div class="pagination-wrapper">
    {!! $rs->appends(['search' => Request::get('search')])->render() !!}
</div>

@endsection