<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; background-color: #f8fafc; color: #74787e; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
    <style>
        @media  only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media  only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; background-color: #f8fafc; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
        <tr>
            <td align="center" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box;">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                    <tr>
    <td class="header" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; padding: 25px 0; text-align: center;">
        <a href="http://msobooking.m-society.go.th" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
            ระบบการขอใช้ทรัพยากร (E-RESERVATION)
        </a>
    </td>
</tr>

                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; background-color: #ffffff; border-bottom: 1px solid #edeff2; border-top: 1px solid #edeff2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">

                            <table class="inner-body" align="center" width="1024" cellpadding="0" cellspacing="0" role="presentation" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; background-color: #ffffff; margin: 0 auto; padding: 0; width: 1024px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 1024px;">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; padding: 35px;">
                                        





@if($type == 'booking-room')
    <h3>สรุปรายละเอียดการจองห้องประชุม/อบรม</h3>
    <table class="table" style="padding-left:5px;">
        <tr>
            <th align="right">รหัสการจอง:</th>
            <td style="padding-left:5px;">{{ @$rs->code }}</td>
        </tr>
        <tr>
            <th align="right">ห้องประชุม:</th>
            <td style="padding-left:5px;">{{ @$rs->st_room->name }}</td>
        </tr>
        <tr>
            <th align="right">ชื่อเรื่อง/หัวข้อการประชุม:</th>
            <td style="padding-left:5px;">{{ @$rs->title }}</td>
        </tr>
        <tr>
            <th align="right">ประธานการประชุม:</th>
            <td style="padding-left:5px;">{{ @$rs->president_name }} ({{ @$rs->president_position }})</td>
        </tr>
        <tr>
            <th align="right">วัน เวลา ที่ต้องการใช้ห้องประชุม:</th>
            <td style="padding-left:5px;">ตั้งแต่วันที่ {{ @DB2Date($rs->start_date) }} เวลา {{ @date("H:i", strtotime($rs->start_time)) }} น. -
                ถึงวันที่ {{ @DB2Date($rs->end_date) }} เวลา {{ @date("H:i", strtotime($rs->end_time)) }} น.</td>
        </tr>
        <tr>
            <th align="right">จำนวนผู้เข้าร่วมประชุม (คน):</th>
            <td style="padding-left:5px;">{{ @$rs->number }}</td>
        </tr>
        @if($rs->st_room->is_internet == 1)
        <tr>
            <th align="right">ขอ User เพื่อเข้าใช้งานอินเทอร์เน็ต (คน):</th>
            <td style="padding-left:5px;">{{ $rs->internet_number ?? '-' }}</td>
        </tr>
        @endif
        @if($rs->st_room->is_conference == 1)
        <tr>
            <th align="right">ขอใช้งานระบบ Conference:</th>
            <td style="padding-left:5px;">{{ $rs->getConferenceTxt() }}</td>
        </tr>
        @endif
        <tr>
            <th align="right">ข้อมูลการติดต่อผู้ขอใช้:</th>
            <td style="padding-left:5px;">
                {{ @$rs->request_name }} ({{ @$rs->request_position }})<br>
                {{ @$rs->department->title }} {{ @$rs->bureau->title }} {{ @$rs->division->title }}<br>
                {{ @$rs->request_tel }}, {{ @$rs->request_email }}
            </td>
        </tr>
        <tr>
            <th align="right">หมายเหตุ/ความต้องการเพิ่มเติมอื่นๆ:</th>
            <td style="padding-left:5px;">{{ isset($rs->note) ? $rs->note : '-' }}</td>
        </tr>
        <tr>
            <th align="right">สถานะการจอง:</th>
            <td style="padding-left:5px;">{{ @$rs->status }}</td>
        </tr>
    </table>

    <br>
    สามารถดูรายละเอียดการจองได้ที่: <a href="{{ url('booking-room-front/show') }}" target="_blank">http://msobooking.m-society.go.th/</a>
@endif





@if($type == 'booking-vehicle')
    <h3>สรุปรายละเอียดการจองยานพาหนะ</h3>
    <table class="table">
    <tr>
        <th align="right">รหัสการจอง:</th>
        <td style="padding-left:5px;">{{ @$rs->code }}</td>
    </tr>
    <tr>
        <th align="right">ขอใช้ยานพาหนะของหน่วยงาน:</th>
        <td style="padding-left:5px;">{{ @$rs->departmentVehicle->title }} {{ @$rs->bureauVehicle->title }} {{ @$rs->divisionVehicle->title }}</td>
    </tr>
    <tr>
        <th align="right">ยานพาหนะ:</th>
        <td style="padding-left:5px;">
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
        <th align="right">ไปเพื่อ:</th>
        <td style="padding-left:5px;">{{ isset($rs->gofor) ? $rs->gofor : '-' }}</td>
    </tr>
    <tr>
        <th align="right">จำนวนผู้โดยสาร:</th>
        <td style="padding-left:5px;">{{ isset($rs->number) ? $rs->number : '-' }} คน</td>
    </tr>
    <tr>
        <th align="right">วันที่ขอใช้:</th>
        <td style="padding-left:5px;">{{ isset($rs->request_date) ? DB2Date($rs->request_date) : '-' }} เวลา {{ isset($rs->request_time) ? date("H:i", strtotime($rs->request_time)) : '-' }} น.</td>
    </tr>
    <tr>
        <th align="right">วันที่ไป:</th>
        <td style="padding-left:5px;">{{ isset($rs->start_date) ? DB2Date($rs->start_date) : '-' }} เวลา {{ isset($rs->start_time) ? date("H:i", strtotime($rs->start_time)) : '-' }} น.</td>
    </tr>
    <tr>
        <th align="right">วันที่กลับ:</th>
        <td style="padding-left:5px;">{{ isset($rs->end_date) ? DB2Date($rs->end_date) : '-' }} เวลา {{ isset($rs->end_time) ? date("H:i", strtotime($rs->end_time)) : '-' }} น.</td>
    </tr>
    <tr>
        <th align="right">สถานที่ขึ้นรถ/เวลา:</th>
        <td style="padding-left:5px;">{{ isset($rs->point_place) ? $rs->point_place : '-' }} เวลา {{ isset($rs->point_time) ? date("H:i", strtotime($rs->point_time)) : '-' }} น.</td>
    </tr>
    <tr>
        <th align="right">สถานที่ไป:</th>
        <td style="padding-left:5px;">{{ isset($rs->destination) ? $rs->destination : '-' }}</td>
    </tr>
    <tr>
        <th align="right">ข้อมูลการติดต่อผู้ขอใช้:</th>
        <td style="padding-left:5px;">
            {{ @$rs->request_name }} ({{ @$rs->request_position }})<br>
            {{ @$rs->department->title }} {{ @$rs->bureau->title }} {{ @$rs->division->title }}<br>
            {{ @$rs->request_tel }}, {{ @$rs->request_email }}
        </td>
    </tr>
    <tr>
        <th align="right">หมายเหตุ หรือรายละเอียดอื่นๆ:</th>
        <td style="padding-left:5px;">{{ isset($rs->note) ? $rs->note : '-' }}</td>
    </tr>
    <tr>
        <th align="right">สถานะการจอง:</th>
        <td style="padding-left:5px;">{{ @$rs->status }}</td>
    </tr>
    </table>

    <br>
    สามารถดูรายละเอียดการจองได้ที่: <a href="{{ url('booking-vehicle-front/show') }}" target="_blank">http://msobooking.m-society.go.th/</a>
@endif





@if($type == 'booking-resource')
    <h3>สรุปรายละเอียดการจองทรัพยากร</h3>
    <table class="table">
    <tr>
        <th align="right">ทรัพยากร:</th>
        <td style="padding-left:5px;">{{ @$rs->stResource->name }}</td>
    </tr>
    <tr>
        <th align="right">รหัสการจอง:</th>
        <td style="padding-left:5px;">{{ @$rs->code }}</td>
    </tr>
    <tr>
        <th align="right">ชื่อเรื่อง:</th>
        <td style="padding-left:5px;">{{ @$rs->title }}</td>
    </tr>
    <tr>
        <th align="right">วัน เวลา ที่ต้องการใช้ทรัพยากร:</th>
        <td style="padding-left:5px;">ตั้งแต่วันที่ {{ @DB2Date($rs->start_date) }} เวลา {{ @date("H:i", strtotime($rs->start_time)) }} น. - ถึงวันที่ {{ @DB2Date($rs->end_date) }} เวลา {{ @date("H:i", strtotime($rs->end_time)) }} น.</td>
    </tr>
    <tr>
        <th align="right">ข้อมูลการติดต่อผู้ขอใช้:</th>
        <td style="padding-left:5px;">
            {{ @$rs->request_name }} ({{ @$rs->request_position }})<br>
            {{ @$rs->department->title }} {{ @$rs->bureau->title }} {{ @$rs->division->title }}<br>
            {{ @$rs->request_tel }}, {{ @$rs->request_email }}
        </td>
    </tr>
    <tr>
        <th align="right">หมายเหตุ หรือรายละเอียดอื่นๆ:</th>
        <td style="padding-left:5px;">{{ isset($rs->note) ? $rs->note : '-' }}</td>
    </tr>
    <tr>
        <th align="right">สถานะการจอง:</th>
        <td style="padding-left:5px;">{{ @$rs->status }}</td>
    </tr>
    </table>

    <br>
    สามารถดูรายละเอียดการจองได้ที่: <a href="{{ url('booking-resource-front/show') }}" target="_blank">http://msobooking.m-society.go.th/</a>
@endif





@if($type == 'booking-boss')
<h3>จองวาระผู้บริหาร</h3>

สรุปรายละเอียดการจองวาระผู้บริหาร
<table class="table">
    <tr>
        <th align="right">รหัสการจอง:</th>
        <td style="padding-left:5px;">{{ @$rs->code }}</td>
    </tr>
    <tr>
        <th align="right">เลือกผู้บริหาร:</th>
        <td style="padding-left:5px;">{{ @$rs->stBoss->name }}</td>
    </tr>
    <tr>
        <th align="right">สถานะผู้บริหาร:</th>
        <td style="padding-left:5px;">{{ @$rs->getBossStatusTxt() }}</td>
    </tr>
    <tr>
        <th align="right">ชื่อเรื่อง/หัวข้อการประชุม:</th>
        <td style="padding-left:5px;">{{ @$rs->title }}</td>
    </tr>
    <tr>
        <th align="right">ชื่อห้องประชุม:</th>
        <td style="padding-left:5px;">{{ @$rs->room_name }}</td>
    </tr>
    <tr>
        <th align="right">สถานที่:</th>
        <td style="padding-left:5px;">{{ @$rs->place }}</td>
    </tr>
    <tr>
        <th align="right">ชื่อเจ้าของงาน:</th>
        <td style="padding-left:5px;">{{ @$rs->owner }}</td>
    </tr>
    <tr>
        <th align="right">เบอร์:</th>
        <td style="padding-left:5px;">{{ @$rs->tel }}</td>
    </tr>
    <tr>
        <th align="right">วันที่เริ่มต้น:</th>
        <td style="padding-left:5px;">{{ isset($rs->start_date) ? DB2Date($rs->start_date) : '-' }} เวลา {{ isset($rs->start_time) ? date("H:i", strtotime($rs->start_time)) : '-' }} น.</td>
    </tr>
    <tr>
        <th align="right">วันที่เริ่มสินสุด:</th>
        <td style="padding-left:5px;">{{ isset($rs->end_date) ? DB2Date($rs->end_date) : '-' }} เวลา {{ isset($rs->end_time) ? date("H:i", strtotime($rs->end_time)) : '-' }} น.</td>
    </tr>
    <tr>
        <th align="right">ข้อมูลการติดต่อผู้ขอใช้:</th>
        <td style="padding-left:5px;">
            {{ $rs->request_name }} ({{ $rs->request_position }})<br>
            {{ $rs->department->title }} {{ $rs->bureau->title }} {{ $rs->division->title }}<br>
            {{ $rs->request_tel }}, {{ $rs->request_email }}
        </td>
    </tr>
    <tr>
        <th align="right">หมายเหตุ หรือรายละเอียดอื่นๆ:</th>
        <td style="padding-left:5px;">{{ isset($rs->note) ? $rs->note : '-' }}</td>
    </tr>
    <tr>
        <th align="right">สถานะการจอง:</th>
        <td style="padding-left:5px;">{{ $rs->status }}</td>
    </tr>
</table>

<br>
    สามารถดูรายละเอียดการจองได้ที่: <a href="{{ url('booking-boss-front/show') }}" target="_blank">http://msobooking.m-society.go.th/</a>
@endif

                                        





                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
    <td style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box;">
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
            <tr>
                <td class="content-cell" align="center" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; padding: 35px;">
                    <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #aeaeae; font-size: 12px; text-align: center;">© 2021 ระบบการขอใช้ทรัพยากร (E-RESERVATION). All rights reserved.</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>