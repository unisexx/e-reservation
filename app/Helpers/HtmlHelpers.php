<?php

if (!function_exists('colorStatus')) {
    function colorStatus($status_txt)
    {
        $color = array("รออนุมัติ" => "#ff9800", "อนุมัติ" => "#4caf50", "ไม่อนุมัติ" => "#f44336", "ยกเลิก" => "#999999");

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
        $txt .= "title: '" . $row->code . "<br><span style=\"color:#c9884c; font-size:16px;\">สถานะ:</span> " . $row->status . "<br><span style=\"color:#c9884c; font-size:16px;\">ไปเพื่อ:</span> " . $row->gofor . "<br><span style=\"color:#c9884c; font-size:16px;\">สถานที่ขึ้นรถ:</span> " . $row->point_place . " เวลา " . $row->point_time . " น.<br><span style=\"color:#c9884c; font-size:16px;\">สถานที่ไป:</span> " . $row->destination . @$txtVehicleDetail . "',";
        $txt .= "start: '" . $row->start_date . "T" . $row->start_time . "',";
        $txt .= "end: '" . $row->end_date . "T" . $row->end_time . "',";
        $txt .= "color: '" . colorStatus($row->status) . "',";

        return $txt;
    }
}
