<?php

if (!function_exists('colorStatus')) {
    function colorStatus($status_txt)
    {
        // $color = array("รออนุมัติ" => "#f8b239", "อนุมัติ" => "#3fc075", "ไม่อนุมัติ" => "#f6675f", "ยกเลิก" => "#999999");
        $color = array("รออนุมัติ" => "#fcdda7", "อนุมัติ" => "#d5e8d1", "ไม่อนุมัติ" => "#f7a9a9", "ยกเลิก" => "#e2e3e3");

        return $color[$status_txt];
    }
}

if (!function_exists('colorStatus2')) {
    function colorStatus2($status_txt)
    {
        $color = array("รออนุมัติ" => "#f4c158", "อนุมัติ" => "#aed0a0", "ไม่อนุมัติ" => "#e5615f", "ยกเลิก" => "#c0c3c3");

        return $color[$status_txt];
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
