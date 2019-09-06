@extends('layouts.admin')

@section('content')

<h3>จองทรัพยากรอื่นๆ</h3>

สรุปรายละเอียดการจองทรัพยากรอื่นๆ
<table class="table table-striped table-bordered">
<tr>
    <th>ทรัพยากร</th>
    <td>{{ $rs->stResource->name }}</td>
</tr>
<tr>
    <th>รหัสการจอง</th>
    <td>{{ $rs->code }}</td>
</tr>
<tr>
    <th>ชื่อเรื่อง</th>
    <td>{{ $rs->title }}</td>
</tr>
<tr>
    <th>วัน เวลา ที่ต้องการใช้ทรัพยากร</th>
    <td>ตั้งแต่วันที่ {{ DB2Date($rs->start_date) }} เวลา {{ date("H:i", strtotime($rs->start_time)) }} น. - ถึงวันที่ {{ DB2Date($rs->end_date) }} เวลา {{ date("H:i", strtotime($rs->end_time)) }} น.</td>
</tr>
<tr>
    <th>ข้อมูลการติดต่อผู้ขอใช้</th>
    <td>{{ $rs->request_name }}, {{ $rs->department->title }} {{ $rs->bureau->title }} {{ $rs->division->title }}, {{ $rs->request_tel }}, {{ $rs->request_email }}</td>
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
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/booking-resource') }}'" class="btn btn-default" style="width:100px;" />
</div>

@endsection