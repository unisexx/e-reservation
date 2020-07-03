<!DOCTYPE html>
<html>
<head>
    <title>ระบบการขอใช้ทรัพยากร (MSOBOOKING)</title>
</head>
<body>
<style>
table, th, td {
    border: 1px solid #dddddd;
    border-collapse: collapse;
}

th, td{
    text-align: left;
    padding: 5px;
}

tr:nth-child(even) {background: #f9f9f9}
</style>

@if($type == 'booking-room')
    <h3>สรุปรายละเอียดการจองห้องประชุม/อบรม</h3>
    <table border="1">
        <tr>
            <th>รหัสการจอง</th>
            <td>{{ @$rs->code }}</td>
        </tr>
        <tr>
            <th>ห้องประชุม</th>
            <td>{{ @$rs->st_room->name }}</td>
        </tr>
        <tr>
            <th>ชื่อเรื่อง / หัวข้อการประชุม</th>
            <td>{{ @$rs->title }}</td>
        </tr>
        <tr>
            <th>ประธานการประชุม</th>
            <td>{{ @$rs->president_name }} ({{ @$rs->president_position }})</td>
        </tr>
        <tr>
            <th>วัน เวลา ที่ต้องการใช้ห้องประชุม</th>
            <td>ตั้งแต่วันที่ {{ @DB2Date($rs->start_date) }} เวลา {{ @date("H:i", strtotime($rs->start_time)) }} น. -
                ถึงวันที่ {{ @DB2Date($rs->end_date) }} เวลา {{ @date("H:i", strtotime($rs->end_time)) }} น.</td>
        </tr>
        <tr>
            <th>จำนวนผู้เข้าร่วมประชุม (คน)</th>
            <td>{{ @$rs->number }}</td>
        </tr>
        <tr>
            <th>ขอ User เพื่อเข้าใช้งานอินเทอร์เน็ต (คน)</th>
            <td>{{ @$rs->internet_number }}</td>
        </tr>
        <tr>
            <th>ข้อมูลการติดต่อผู้ขอใช้</th>
            <td>
                {{ @$rs->request_name }} ({{ @$rs->request_position }})<br>
                {{ @$rs->department->title }} {{ @$rs->bureau->title }} {{ @$rs->division->title }}<br>
                {{ @$rs->request_tel }}, {{ @$rs->request_email }}
            </td>
        </tr>
        <tr>
            <th>หมายเหตุ / ความต้องการเพิ่มเติมอื่นๆ</th>
            <td>{{ isset($rs->note) ? $rs->note : '-' }}</td>
        </tr>
        <tr>
            <th>สถานะ</th>
            <td>{{ @$rs->status }}</td>
        </tr>
    </table>
@endif


@if($type == 'booking-vehicle')
    <h3>สรุปรายละเอียดการจองยานพาหนะ</h3>
    <table border="1">
    <tr>
        <th>รหัสการจอง</th>
        <td>{{ @$rs->code }}</td>
    </tr>
    <tr>
        <th>ขอใช้ยานพาหนะของหน่วยงาน</th>
        <td>{{ @$rs->departmentVehicle->title }} {{ @$rs->bureauVehicle->title }} {{ @$rs->divisionVehicle->title }}</td>
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
            {{ @$rs->request_name }} ({{ @$rs->request_position }})<br>
            {{ @$rs->department->title }} {{ @$rs->bureau->title }} {{ @$rs->division->title }}<br>
            {{ @$rs->request_tel }}, {{ @$rs->request_email }}
        </td>
    </tr>
    <tr>
        <th>หมายเหตุ หรือรายละเอียดอื่นๆ</th>
        <td>{{ isset($rs->note) ? $rs->note : '-' }}</td>
    </tr>
    <tr>
        <th>สถานะ</th>
        <td>{{ @$rs->status }}</td>
    </tr>
    </table>
@endif

@if($type == 'booking-resource')
    <h3>สรุปรายละเอียดการจองทรัพยากร</h3>
    <table border="1">
    <tr>
        <th>ทรัพยากร</th>
        <td>{{ @$rs->stResource->name }}</td>
    </tr>
    <tr>
        <th>รหัสการจอง</th>
        <td>{{ @$rs->code }}</td>
    </tr>
    <tr>
        <th>ชื่อเรื่อง</th>
        <td>{{ @$rs->title }}</td>
    </tr>
    <tr>
        <th>วัน เวลา ที่ต้องการใช้ทรัพยากร</th>
        <td>ตั้งแต่วันที่ {{ @DB2Date($rs->start_date) }} เวลา {{ @date("H:i", strtotime($rs->start_time)) }} น. - ถึงวันที่ {{ @DB2Date($rs->end_date) }} เวลา {{ @date("H:i", strtotime($rs->end_time)) }} น.</td>
    </tr>
    <tr>
        <th>ข้อมูลการติดต่อผู้ขอใช้</th>
        <td>
            {{ @$rs->request_name }} ({{ @$rs->request_position }})<br>
            {{ @$rs->department->title }} {{ @$rs->bureau->title }} {{ @$rs->division->title }}<br>
            {{ @$rs->request_tel }}, {{ @$rs->request_email }}
        </td>
    </tr>
    <tr>
        <th>หมายเหตุ หรือรายละเอียดอื่นๆ</th>
        <td>{{ isset($rs->note) ? $rs->note : '-' }}</td>
    </tr>
    <tr>
        <th>สถานะ</th>
        <td>{{ @$rs->status }}</td>
    </tr>
    </table>
@endif

</body>
</html>
