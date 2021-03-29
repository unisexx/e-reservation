@extends( $from == 'backend' ? 'layouts.admin' : 'layouts.front')

@section('content')






@if($type == 'resource')
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
    <td>
        {{ $rs->request_name }} ({{ $rs->request_position }})<br>
        {{ $rs->department->title }} {{ $rs->bureau->title }} {{ $rs->division->title }}<br>
        {{ $rs->request_tel }}, {{ $rs->request_email }}
    </td>
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
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ $from == 'backend' ? url('/booking-resource') : url('/booking-resource-front/show') }}'" class="btn btn-default" style="width:100px;" />
</div>
@endif





@if($type == 'room')
<h3>จองห้องประชุม/อบรม</h3>

สรุปรายละเอียดการจองห้องประชุม/อบรม
<table class="table table-striped table-bordered">
<tr>
    <th>จังหวัด</th>
    <td>{{ @$rs->st_province_code == 10 ? 'ส่วนกลาง' : @getProviceName(@$rs->st_province_code) }}</td>
</tr>
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
    <th>ประธานการประชุม</th>
    <td>{{ @$rs->president_name }} ({{ @$rs->president_position }})</td>
</tr>
<tr>
    <th>วัน เวลา ที่ต้องการใช้ห้องประชุม</th>
    <td>ตั้งแต่วันที่ {{ DB2Date($rs->start_date) }} เวลา {{ date("H:i", strtotime($rs->start_time)) }} น. - ถึงวันที่ {{ DB2Date($rs->end_date) }} เวลา {{ date("H:i", strtotime($rs->end_time)) }} น.</td>
</tr>
<tr>
    <th>จำนวนผู้เข้าร่วมประชุม (คน)</th>
    <td>{{ $rs->number }}</td>
</tr>
@if($rs->st_room->is_internet == 1)
<tr>
    <th>ขอ User เพื่อเข้าใช้งานอินเทอร์เน็ต (คน)</th>
    <td>{{ $rs->internet_number ?? '-' }}</td>
</tr>
@endif
@if($rs->st_room->is_conference == 1)
<tr>
    <th>ขอใช้งานระบบ Conference</th>
    <td>{{ $rs->getConferenceTxt() }}</td>
</tr>
@endif
<tr>
    <th>ข้อมูลการติดต่อผู้ขอใช้</th>
    <td>
        {{ $rs->request_name }} ({{ $rs->request_position }})<br>
        {{ $rs->department->title }} {{ $rs->bureau->title }} {{ $rs->division->title }}<br>
        {{ $rs->request_tel }}, {{ $rs->request_email }}
    </td>
</tr>
<tr>
    <th>หมายเหตุ / ความต้องการเพิ่มเติมอื่นๆ</th>
    <td>{{ isset($rs->note) ? $rs->note : '-' }}</td>
</tr>
<tr>
    <th>สถานะ</th>
    <td>{{ $rs->status }}</td>
</tr>
</table>

<div id="btnBoxAdd">
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ $from == 'backend' ? url('/booking-room') : url('/booking-room-front/show?st_province_code='.@$rs->st_province_code) }}'" class="btn btn-default" style="width:100px;" />

    <a href="{{ url('booking-room-front/print/'.$rs->id) }}" target="_blank"><img src="{{ asset('images/printer.png') }}" alt="พิมพ์ใบจอง" style="width:48px; margin-left:10px;"></a>
</div>
@endif






@if($type == 'vehicle')
<h3>จองยานพาหนะ</h3>

สรุปรายละเอียดการจองยานพาหนะ
<table class="table table-striped table-bordered">
<tr>
    <th>รหัสการจอง</th>
    <td>{{ $rs->code }}</td>
</tr>
<tr>
    <th>ขอใช้ยานพาหนะของหน่วยงาน</th>
    <td>{{ $rs->departmentVehicle->title }} {{ $rs->bureauVehicle->title }} {{ $rs->divisionVehicle->title }}</td>
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
    <td>
        {{ $rs->request_name }} ({{ $rs->request_position }})<br>
        {{ $rs->department->title }} {{ $rs->bureau->title }} {{ $rs->division->title }}<br>
        {{ $rs->request_tel }}, {{ $rs->request_email }}
    </td>
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
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ $from == 'backend' ? url('/booking-vehicle') : url('/booking-vehicle-front/show?st_province_code='.@$rs->st_province_code) }}'" class="btn btn-default" style="width:100px;" />

    <a href="{{ url('booking-vehicle-front/print/'.$rs->id) }}" target="_blank"><img src="{{ asset('images/printer.png') }}" alt="พิมพ์ใบจอง" style="width:48px; margin-left:10px;"></a>
</div>
@endif




@if($type == 'boss')
<h3>จองวาระผู้บริหาร</h3>

สรุปรายละเอียดการจองวาระผู้บริหาร
<table class="table table-striped table-bordered">
<tr>
    <th>รหัสการจอง</th>
    <td>{{ @$rs->code }}</td>
</tr>
<tr>
    <th>เลือกผู้บริหาร</th>
    <td>{{ @$rs->stBoss->name }}</td>
</tr>
<tr>
    <th>สถานะ</th>
    <td>{{ @$rs->getBossStatusTxt() }}</td>
</tr>
<tr>
    <th>ชื่อเรื่อง / หัวข้อการประชุม</th>
    <td>{{ @$rs->title }}</td>
</tr>
<tr>
    <th>ชื่อห้องประชุม</th>
    <td>{{ @$rs->room_name }}</td>
</tr>
<tr>
    <th>สถานที่</th>
    <td>{{ @$rs->place }}</td>
</tr>
<tr>
    <th>ชื่อเจ้าของงาน</th>
    <td>{{ @$rs->owner }}</td>
</tr>
<tr>
    <th>เบอร์</th>
    <td>{{ @$rs->tel }}</td>
</tr>
<tr>
    <th>วันที่เริ่มต้น</th>
    <td>{{ isset($rs->start_date) ? DB2Date($rs->start_date) : '-' }} เวลา {{ isset($rs->start_time) ? date("H:i", strtotime($rs->start_time)) : '-' }} น.</td>
</tr>
<tr>
    <th>วันที่สินสุด</th>
    <td>{{ isset($rs->end_date) ? DB2Date($rs->end_date) : '-' }} เวลา {{ isset($rs->end_time) ? date("H:i", strtotime($rs->end_time)) : '-' }} น.</td>
</tr>
<tr>
    <th>ข้อมูลการติดต่อผู้ขอใช้</th>
    <td>
        {{ $rs->request_name }} ({{ $rs->request_position }})<br>
        {{ $rs->department->title }} {{ $rs->bureau->title }} {{ $rs->division->title }}<br>
        {{ $rs->request_tel }}, {{ $rs->request_email }}
    </td>
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
    <input name="input2" type="button" title="ย้อนกลับ" value="ย้อนกลับ" onclick="document.location='{{ $from == 'backend' ? url('/booking-boss') : url('/booking-boss-front/show') }}'" class="btn btn-default" style="width:100px;" />

    {{-- <a href="{{ url('booking-boss-front/print/'.$rs->id) }}" target="_blank"><img src="{{ asset('images/printer.png') }}" alt="พิมพ์ใบจอง" style="width:48px; margin-left:10px;"></a> --}}
</div>
@endif






@endsection