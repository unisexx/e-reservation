@extends('layouts.admin')

@section('content')

<h3>จองยานพาหนะ</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('booking-room') }}" accept-charset="UTF-8" class="form-inline" role="search">

            <input type="text" class="form-control" style="width:370px;" placeholder="รหัสการจอง / ทะเบียนรถ / ชื่อคนขับ" name="search" value="{{ request('search') }}">

            <select name="date_type" class="form-control">
                <option value="request_date" @if(request('date_type') == 'request_date') selected @endif>วันที่ขอใช้</option>
                <option value="start_date" @if(request('date_type') == 'start_date') selected @endif>วันที่ไป</option>
                <option value="end_date" @if(request('date_type') == 'end_date') selected @endif>วันที่กลับ</option>
            </select>

            <input name="date_select" type="text" class="form-control fdate datepicker" value="{{ request('date_select') }}" style="width:100px;" />

            <button type="submit" class="btn btn-info"><img src="{{ url('images/search.png') }}" width="16" height="16" />ค้นหา</button>
        </form>


    </div>
</div>

{{-- @if(CanPerm('st-vehicle-type-create')) --}}
<div id="btnBox"> <a href="{{ url('/booking-room/calendar') }}"><img src="{{ url('images/view_calendar.png') }}" class="vtip" title="ดูมุมมองปฎิทิน" /></a>
    <input type="button" title="export excel" value="export excel" class="btn vtip" />
    <input type="button" title="จองยานพาหนะ" value="จองยานพาหนะ" onclick="document.location='{{ url('/booking-room/create') }}'" class="btn btn-success vtip" />
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
        <th style="width:25%" class="nosort" data-sortcolumn="2" data-sortkey="2-0">ไปเพื่อ / รายละเอียดรถ / ชื่อผู้ขับ</th>
        <th style="width:15%" class="nosort" data-sortcolumn="3" data-sortkey="3-0">วันที่</th>
        <th style="width:15%" class="nosort" data-sortcolumn="4" data-sortkey="4-0">จุดขึ้นรถ / สถานที่ไป</th>
        <th style="width:10%" class="nosort" data-sortcolumn="5" data-sortkey="5-0">ผู้ขอใช้ยานพาหนะ</th>
        <th style="width:5%" class="nosort" data-sortcolumn="6" data-sortkey="6-0">สถานะ</th>
        <th style="width:10%" class="nosort" data-sortcolumn="7" data-sortkey="7-0">จัดการ</th>
    </tr>
    </thead>
    <tbody>


    <tr>
        <td data-value="1">1</td>
        <td nowrap="nowrap" data-value="BR61058">BR61058</td>
        <td data-value="
  ไปประชุมคณะอนุกรรมการขับเคลื่อนการแก้ปัญหาการรุกลำน้ำสาธารณะ
  ">
            <div class="topicMeeting">ไปประชุมคณะอนุกรรมการขับเคลื่อนการแก้ปัญหาการรุกลำน้ำสาธารณะ</div>
        </td>
        <td data-value="
  ขอใช้ 17/10/2561 10:00 น.
  ไป 24/10/2561 09:00 น.
    กลับ 24/10/2561 12:00 น.">
            <div class="boxStartEnd"><span class="request">ขอใช้</span> 17/10/2561 10:00 น.</div>
            <div class="boxStartEnd"><span class="start">ไป</span> 24/10/2561 09:00 น.</div>
            <div class="boxStartEnd"><span class="end">กลับ</span> 24/10/2561 12:00 น.</div>
        </td>
        <td data-value="อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) เวลา 08:30 น. 
กระทรวงการพัฒนาสังคมฯ ">อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) เวลา 08:30 น. <br><br>
            กระทรวงการพัฒนาสังคมฯ </td>
        <td data-value="นางสาวจินตนา  เอกอมร ">นางสาวจินตนา เอกอมร <img
                src="http://demo_e-reservation.test/images/detail.png" class="vtip" title="กลุ่มการประเมินผล กองตรวจราชการ สำนักงานปลัดกระทรวง<br>
081-1586585  jintana.e@m-society.go.th"></td>
        <td data-value="รออนุมัติ">รออนุมัติ</td>
        <td data-value=""><a href="index.php?act=form"><img src="http://demo_e-reservation.test/images/edit.png"
                    width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้"></a><img
                src="http://demo_e-reservation.test/images/remove.png" width="24" height="24" class="vtip"
                title="ลบรายการนี้"></td>
    </tr>



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