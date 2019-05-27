@extends('layouts.admin')

@section('content')

<h3>จองยานพาหนะ</h3>

สรุปรายละเอียดการจองยานพาหนะ
<table class="table table-striped table-bordered">
<tr>
    <th>รหัสการจอง</th>
    <td>{{ $rs->code }}</td>
</tr>
<tr>
    <th>ยานพาหนะ</th>
    <td>
        @if(isset($rs->st_vehicle_id))
            {{ isset($rs->st_vehicle->st_vehicle_type->name) ? $rs->st_vehicle->st_vehicle_type->name : '-' }} 
            {{ isset($rs->st_vehicle->brand) ? $rs->st_vehicle->brand : '-' }}
            {{ isset($rs->st_vehicle->seat) ? $rs->st_vehicle->seat : '-' }} ที่นั่ง
            สี {{ isset($rs->st_vehicle->color) ? $rs->st_vehicle->color : '-' }} 
            ทะเบียน {{ isset($rs->st_vehicle->reg_number) ? $rs->st_vehicle->reg_number : '-' }}
        @else
            -
        @endif
    </td>
</tr>
<tr>
    <th>ไปเพื่อ</th>
    <td>{{ isset($rs->gofor) ? $rs->gofor : '-' }}</td>
</tr>
<tr>
    <th>จำนวนผู้โดยสาร</th>
    <td>{{ isset($rs->number) ? $rs->number : '-' }} คน</td>
</tr>
<tr>
    <th>วันที่ขอใช้</th>
    <td>{{ isset($rs->request_date) ? DB2Date($rs->request_date) : '-' }} เวลา {{ isset($rs->request_time) ? date("H:i", strtotime($rs->request_time)) : '-' }} น.</td>
</tr>
<tr>
    <th>วันที่ไป</th>
    <td>{{ isset($rs->start_date) ? DB2Date($rs->start_date) : '-' }} เวลา {{ isset($rs->start_time) ? date("H:i", strtotime($rs->start_time)) : '-' }} น.</td>
</tr>
<tr>
    <th>วันที่กลับ</th>
    <td>{{ isset($rs->end_date) ? DB2Date($rs->end_date) : '-' }} เวลา {{ isset($rs->end_time) ? date("H:i", strtotime($rs->end_time)) : '-' }} น.</td>
</tr>
<tr>
    <th>สถานที่ขึ้นรถ / เวลา</th>
    <td>{{ isset($rs->point_place) ? $rs->point_place : '-' }} เวลา {{ isset($rs->point_time) ? date("H:i", strtotime($rs->point_time)) : '-' }} น.</td>
</tr>
<tr>
    <th>สถานที่ไป</th>
    <td>{{ isset($rs->destination) ? $rs->destination : '-' }}</td>
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
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ url('/booking-vehicle') }}'" class="btn btn-default" style="width:100px;" />
</div>

@endsection