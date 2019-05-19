@extends('layouts.admin')

@section('content')

<h3>จองห้องประชุม</h3>

สรุปรายละเอียดการจองห้องประชุม
<table class="table table-striped table-bordered">
<tr>
    <th>รหัสการจอง</th>
    <td>{{ $rs->code }}</td>
</tr>
<tr>
    <th>ห้องประชุม</th>
    <td>{{ $rs->st_room->name }}</td>
</tr>
<tr>
    <th>ชื่อเรื่อง / หัวข้อการประชุม</th>
    <td>{{ $rs->title }}</td>
</tr>
<tr>
    <th>วัน เวลา ที่ต้องการใช้ห้องประชุม</th>
    <td>ตั้งแต่วันที่ {{ DB2Date($rs->start_date) }} เวลา {{ date("H:i", strtotime($rs->start_time)) }} น. - ถึงวันที่ {{ DB2Date($rs->end_date) }} เวลา {{ date("H:i", strtotime($rs->end_time)) }} น.</td>
</tr>
<tr>
    <th>จำนวนผู้เข้าร่วมประชุม</th>
    <td>{{ $rs->number }}</td>
</tr>
<tr>
    <th>ข้อมูลการติดต่อผู้ขอใช้</th>
    <td>{{ $rs->request_name }}, {{ $rs->st_room->department->title }} {{ $rs->st_room->bureau->title }} {{ $rs->st_room->division->title }}, {{ $rs->request_tel }}, {{ $rs->request_email }}</td>
</tr>
<tr>
    <th>หมายเหตุ หรือรายละเอียดอื่นๆ</th>
    <td>{{ isset($rs->note) ? $rs->note : '-' }}</td>
</tr>
<tr>
    <th>สถานะ</th>
    <td>{{ $rs->status }}</td>
</tr>
</table>

<div id="btnBoxAdd">
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/booking-room') }}'" class="btn btn-default" style="width:100px;" />
</div>

@endsection