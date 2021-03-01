<?php

if (!function_exists('colorStatus')) {
    function colorStatus($status_txt)
    {
        $color = array("รออนุมัติ" => "#fcdda7", "อนุมัติ" => "#d5e8d1", "ไม่อนุมัติ" => "#f7a9a9", "ยกเลิก" => "#e2e3e3");

        return @$color[@$status_txt];
    }
}

if (!function_exists('colorStatus2')) {
    function colorStatus2($status_txt)
    {
        $color = array("รออนุมัติ" => "#f4c158", "อนุมัติ" => "#aed0a0", "ไม่อนุมัติ" => "#e5615f", "ยกเลิก" => "#c0c3c3");

        return @$color[@$status_txt];
    }
}

if (!function_exists('getHour')) {
    function getHour()
    {
        for ($i = 0; $i <= 23; ++$i) {
            $hour[] = sprintf('%02d', $i);
        }

        return $hour;
    }
}

if (!function_exists('getMinute')) {
    function getMinute()
    {
        for ($i = 0; $i <= 59; ++$i) {
            $minute[] = sprintf('%02d', $i);
        }

        return $minute;
    }
}

if (!function_exists('getVehicleCboxDetail')) {
    function getVehicleCboxDetail($booking_vehicle_row)
    {
        $row = $booking_vehicle_row;

        if ($row->status == 'อนุมัติ') {
            $txtVehicleDetail = "<br><span style=\"color:#c9884c; font-size:16px;\">รายละเอียดรถ:</span> " . @$row->st_vehicle->st_vehicle_type->name . " " . @$row->st_vehicle->brand . " " . @$row->st_vehicle->seat . " ที่นั่ง " . @$row->st_vehicle->color . " ทะเบียน " . @$row->st_vehicle->reg_number . "<br><span style=\"color:#c9884c; font-size:16px;\">ผู้รับผิดชอบยานพาหนะ:</span> " . @$row->st_vehicle->res_name . ",  โทร " . @$row->st_vehicle->res_tel;
        }

        $txt = '';
        $txt .= "shortTitle: '[" . displyDateTime($row->start_date, $row->start_time, $row->end_date, $row->end_time) . "] [" . $row->code . "] " . $row->gofor . " (" . $row->status . ")',";
        $txt .= "title: '" . $row->code .
        "<br><span style=\"color:#c9884c; font-size:16px;\">สถานะ:</span> " . $row->status .
        "<br><span style=\"color:#c9884c; font-size:16px;\">ขอใช้ยานพาหนะของหน่วยงาน:</span> " . $row->departmentVehicle->title . ", " . $row->bureauVehicle->title . ", " .
        $row->divisionVehicle->title .
        "<br><span style=\"color:#c9884c; font-size:16px;\">ไปเพื่อ:</span> " . $row->gofor .
        "<br><span style=\"color:#c9884c; font-size:16px;\">จำนวนผู้โดยสาร:</span> " . $row->number . " คน " .
        "<br><span style=\"color:#c9884c; font-size:16px;\">วันที่ขอใช้:</span> " . DB2Date($row->request_date) . @date("H:i", strtotime($row->request_time)) . " น. " .
        "<br><span style=\"color:#c9884c; font-size:16px;\">วันที่ไป:</span> " . DB2Date($row->start_date) . @date("H:i", strtotime($row->start_time)) . " น. " .
        "<br><span style=\"color:#c9884c; font-size:16px;\">วันที่กลับ:</span> " . DB2Date($row->end_date) . @date("H:i", strtotime($row->end_time)) . " น. " .
        "<br><span style=\"color:#c9884c; font-size:16px;\">สถานที่ขึ้นรถ:</span> " . $row->point_place . " เวลา " . $row->point_time . " น." .
        "<br><span style=\"color:#c9884c; font-size:16px;\">สถานที่ไป:</span> " . $row->destination . @$txtVehicleDetail .
        "<br><span style=\"color:#c9884c; font-size:16px;\">ผู้ขอใช้:</span> " . $row->request_name . " " . $row->request_position .
        "<br><span style=\"color:#c9884c; font-size:16px;\">หน่วยงานผู้ขอใช้:</span> " . $row->department->title . ", " . $row->bureau->title . ", " . $row->bureau->title .
        "<br><span style=\"color:#c9884c; font-size:16px;\">โทรศัพท์:</span> " . $row->request_tel .
        "<br><span style=\"color:#c9884c; font-size:16px;\">อีเมล์:</span> " . $row->request_email .
        "<br><span style=\"color:#c9884c; font-size:16px;\">หมายเหตุ:</span> " . $row->note . " ',";
        $txt .= "start: '" . $row->start_date . "T" . $row->start_time . "',";
        $txt .= "end: '" . $row->end_date . "T" . $row->end_time . "',";
        $txt .= "color: '" . colorStatus($row->status) . "',";

        return $txt;
    }
}

if (!function_exists('getBossCboxDetail')) {
    function getBossCboxDetail($booking_boss_row)
    {
        $row = $booking_boss_row;

        if ($row->status == 'อนุมัติ') {
            $txtVehicleDetail = "<br><span style=\"color:#c9884c; font-size:16px;\">รายละเอียดรถ:</span> " . @$row->st_vehicle->st_vehicle_type->name . " " . @$row->st_vehicle->brand . " " . @$row->st_vehicle->seat . " ที่นั่ง " . @$row->st_vehicle->color . " ทะเบียน " . @$row->st_vehicle->reg_number . "<br><span style=\"color:#c9884c; font-size:16px;\">ผู้รับผิดชอบยานพาหนะ:</span> " . @$row->st_vehicle->res_name . ",  โทร " . @$row->st_vehicle->res_tel;
        }

        $txt = '';
        $txt .= "shortTitle: '[" . displyDateTime($row->start_date, $row->start_time, $row->end_date, $row->end_time) . "] [" . $row->code . "] " . $row->stBoss->name . " (" . @$row->stBoss->stBossPosition->name . ") (" . $row->status . ")',";
        $txt .= "title: '" . $row->code .
        "<br><span style=\"color:#c9884c; font-size:16px;\">สถานะการจอง:</span> " . @$row->status .
        "<br><span style=\"color:#c9884c; font-size:16px;\">ผู้บริหาร:</span> " . @$row->stBoss->name .
        "<br><span style=\"color:#c9884c; font-size:16px;\">สถานะผู้บริหาร:</span> " . @$row->getBossStatusTxt() .
        "<br><span style=\"color:#c9884c; font-size:16px;\">ชื่อเรื่อง / หัวข้อการประชุม:</span> " . @$row->title .
        "<br><span style=\"color:#c9884c; font-size:16px;\">ชื่อห้องประชุม:</span> " . @$row->room_name .
        "<br><span style=\"color:#c9884c; font-size:16px;\">สถานที่:</span> " . @$row->place .
        "<br><span style=\"color:#c9884c; font-size:16px;\">ชื่อเจ้าของงาน:</span> " . @$row->owner .
        "<br><span style=\"color:#c9884c; font-size:16px;\">เบอร์:</span> " . @$row->tel .
        "<br><span style=\"color:#c9884c; font-size:16px;\">วันที่เริ่ม:</span> " . DB2Date($row->start_date) . @date("H:i", strtotime($row->start_time)) . " น. " .
        "<br><span style=\"color:#c9884c; font-size:16px;\">วันที่สิ้นสุด:</span> " . DB2Date($row->end_date) . @date("H:i", strtotime($row->end_time)) . " น. " .
        "<br><span style=\"color:#c9884c; font-size:16px;\">ผู้ขอใช้:</span> " . $row->request_name . " " . $row->request_position .
        "<br><span style=\"color:#c9884c; font-size:16px;\">หน่วยงานผู้ขอใช้:</span> " . $row->department->title . ", " . $row->bureau->title . ", " . $row->bureau->title .
        "<br><span style=\"color:#c9884c; font-size:16px;\">โทรศัพท์:</span> " . $row->request_tel .
        "<br><span style=\"color:#c9884c; font-size:16px;\">อีเมล์:</span> " . $row->request_email .
        "<br><span style=\"color:#c9884c; font-size:16px;\">หมายเหตุ:</span> " . $row->note . " ',";
        $txt .= "start: '" . $row->start_date . "T" . $row->start_time . "',";
        $txt .= "end: '" . $row->end_date . "T" . $row->end_time . "',";
        $txt .= "color: '" . colorStatus($row->status) . "',";

        return $txt;
    }
}

if (!function_exists('getProviceName')) {
    function getProviceName($id)
    {
        $rs = \App\Model\StProvince::find($id);

        return $rs->name;
    }
}
