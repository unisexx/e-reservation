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
    <h3>สรุปสถานะการจองห้องประชุม/อบรม</h3>
    <table border="1">
        <tr>
            <th>รหัสการจอง</th>
            <td>{{ @$rs->code }}</td>
        </tr>
        <tr>
            <th>หัวข้อการประชุม</th>
            <td>{{ @$rs->title }}</td>
        </tr>
        <tr>
            <th>ห้องประชุม</th>
            <td>{{ @$rs->st_room->name }}</td>
        </tr>
        <tr>
            <th>สถานะการจอง</th>
            <td>{{ @$rs->status }}</td>
        </tr>
    </table>
    <br>
    สามารถดูรายละเอียดการจองได้ที่: <a href="{{ url('booking-room-front/show') }}" target="_blank">http://msobooking.m-society.go.th/</a>
@endif


@if($type == 'booking-vehicle')
    <h3>สรุปสถานะการจองยานพาหนะ</h3>

    <table border="1">
    <tr>
        <th>รหัสการจอง</th>
        <td>{{ @$rs->code }}</td>
    </tr>
    <tr>
        <th>ไปเพื่อ</th>
        <td>{{ isset($rs->gofor) ? $rs->gofor : '-' }}</td>
    </tr>
    <tr>
        <th>สถานที่ขึ้นรถ</th>
        <td>{{ isset($rs->point_place) ? $rs->point_place : '-' }}</td>
    </tr>
    <tr>
        <th>สถานะ</th>
        <td>{{ @$rs->status }}</td>
    </tr>
    </table>
    <br>
    สามารถดูรายละเอียดการจองได้ที่: <a href="{{ url('booking-vehicle/show') }}" target="_blank">http://msobooking.m-society.go.th/</a>
@endif


@if($type == 'booking-resource')
    <h3>สรุปสถานะการจองทรัพยากร</h3>

    <table border="1">
    <tr>
        <th>รหัสการจอง</th>
        <td>{{ @$rs->code }}</td>
    </tr>
    <tr>
        <th>ทรัพยากร</th>
        <td>{{ @$rs->stResource->name }}</td>
    </tr>
    <tr>
        <th>หัวข้อ</th>
        <td>{{ @$rs->title }}</td>
    </tr>
    <tr>
        <th>สถานะการจอง</th>
        <td>{{ @$rs->status }}</td>
    </tr>
    </table>
    <br>
    สามารถดูรายละเอียดการจองได้ที่: <a href="{{ url('booking-resource-front/show') }}" target="_blank">http://msobooking.m-society.go.th/</a>
@endif

@if($type == 'booking-boss')
    <h3>สรุปสถานะการจองวาระผู้บริหาร</h3>

    <table border="1">
    <tr>
        <th>รหัสการจอง</th>
        <td>{{ @$rs->code }}</td>
    </tr>
    <tr>
        <th>ผู้บริหาร</th>
        <td>{{ @$rs->stBoss->name }}</td>
    </tr>
    <tr>
        <th>หัวข้อ</th>
        <td>{{ @$rs->title }}</td>
    </tr>
    <tr>
        <th>สถานะการจอง</th>
        <td>{{ @$rs->status }}</td>
    </tr>
    </table>
    <br>
    สามารถดูรายละเอียดการจองได้ที่: <a href="{{ url('booking-boss-front/show') }}" target="_blank">http://msobooking.m-society.go.th/</a>
@endif

</body>
</html>
