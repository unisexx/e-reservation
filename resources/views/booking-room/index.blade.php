@extends('layouts.admin')

@section('content')

<h3>จองห้องประชุม</h3>
<div id="search">
    <div id="searchBox">
        <form method="GET" action="{{ url('booking-room') }}" accept-charset="UTF-8" class="form-inline" role="search">

            <input type="text" class="form-control" style="width:370px;" placeholder="รหัสการจอง / หัวข้อการประชุม / ผู้ขอใช้ห้องประชุม" name="search" value="{{ request('search') }}">

            <select name="select" class="form-control">
                <option>วันที่เริ่ม</option>
                <option>วันที่สิ้นสุด</option>
            </select>

            <input type="text" class="form-control fdate" id="exampleInputEmail2" value="" style="width:100px;" />
            <img src="images/calendar.png" width="24" height="24" />

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

<table class="tblist">
    <tr>
        <th style="width:5%">ลำดับ</th>
        <th style="width:10%">รหัสการจอง</th>
        <th style="width:30%">หัวข้อการประชุม / ห้องประชุม</th>
        <th style="width:15%">วัน เวลา ที่ต้องการใช้ห้อง</th>
        <th style="width:15%">ผู้ขอใช้ห้องประชุม</th>
        <th style="width:5%">สถานะ</th>
        <th style="width:5%">จัดการ</th>
    </tr>
    <tr>
        <td>1</td>
        <td nowrap="nowrap">BR61058</td>
        <td>
            <div class="topicMeeting">ผลการดำเนินงานรอบสัปดาห์เพื่อใช้ในรายการคืนความสุขให้คนในชาติ</div>
            อาคาร ซี. พี. ทาวเวอร์ 3 (พญาไท) ห้องประชุมชั้น 7 <img src="{{ url('images/detail.png') }}" class="vtip" title="
  <u>จำนวนคนที่รับรองได้</u> 15 คน<br>
	<u>อุปกรณ์ที่ติดตั้งในห้อง</u> Projector 1 เครื่อง<br>
	<u>ผู้รับผิดชอบห้องประชุม</u> นายจำเริญ นิจจรัลกุล กลุ่มการพัฒนาระบบสารสนเทศ ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร สป.พม.<br>
	<u>ค่าใช้จ่าย/ค่าธรรมเนียมในการขอใช้ห้องประชุม</u> ไม่มี" />
        </td>
        <td>
            <div class="boxStartEnd"><span class="start">เริ่ม</span> 02/11/2561 08:30 น.</div>
            <div class="boxStartEnd"><span class="end">สิ้นสุด</span> 02/11/2561 12:00 น.</div>
        </td>
        <td>นางสาวจินตนา เอกอมร <img src="{{ url('images/detail.png') }}" class="vtip" title="กลุ่มการประเมินผล กองตรวจราชการ สำนักงานปลัดกระทรวง<br>
081-1586585  jintana.e@m-society.go.th" /></td>
        <td>รออนุมัติ</td>
        <td><a href="<?= basename($_SERVER['PHP_SELF']) ?>?act=form"><img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" /></a><img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้" /></td>
    </tr>
    @foreach($rs as $key=>$item)
    <!-- <tr @if(($key % 2)==1) class="odd" @endif>
        <td>{{ (($rs->currentPage() - 1 ) * $rs->perPage() ) + $loop->iteration }}</td>
        <td>{{ $item->name }}</td>
        <td>@if($item->status == 1) <img src="{{ url('images/icon_checkbox.png')}}" width="24" height="24" /> @endif</td>
        <td>

            {{-- @if(CanPerm('st-vehicle-type-edit')) --}}
            <a href="{{ url('booking-room/' . $item->id . '/edit') }}" title="Edit StAscc">
                <img src="{{ url('images/edit.png') }}" width="24" height="24" style="margin-right:10px;" class="vtip" title="แก้ไขรายการนี้" />
            </a>
            {{-- @endif --}}

            {{-- @if(CanPerm('st-vehicle-type-delete')) --}}
            <form method="POST" action="{{ url('booking-room' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" title="Delete StAscc" onclick="return confirm(&quot;Confirm delete?&quot;)" style="border:none; background:none;">
                    <img src="{{ url('images/remove.png') }}" width="24" height="24" class="vtip" title="ลบรายการนี้" />
                </button>
            </form>
            {{-- @endif --}}
        </td>
    </tr> -->
    @endforeach
</table>

<div class="pagination-wrapper">
    {!! $rs->appends(['search' => Request::get('search')])->render() !!}
</div>

@endsection