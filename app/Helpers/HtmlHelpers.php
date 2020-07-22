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
            $txtVehicleDetail = "<br>รายละเอียดรถ: " . @$row->st_vehicle->st_vehicle_type->name . " " . @$row->st_vehicle->brand . " " . @$row->st_vehicle->seat . " ที่นั่ง " . @$row->st_vehicle->color . " ทะเบียน " . @$row->st_vehicle->reg_number . "<br>ผู้รับผิดชอบยานพาหนะ : " . @$row->st_vehicle->res_name . ",  โทร. : " . @$row->st_vehicle->res_tel;
        }

        $txt = '';
        $txt .= "shortTitle: '[" . displyDateTime($row->start_date, $row->start_time, $row->end_date, $row->end_time) . "] [" . $row->code . "] " . $row->gofor . " (" . $row->status . ")',";
        $txt .= "title: '" . $row->code . "<br>สถานะ: " . $row->status . "<br>ไปเพื่อ: " . $row->gofor . "<br>สถานที่ขึ้นรถ " . $row->point_place . " เวลา " . $row->point_time . " น.<br>สถานที่ไป: " . $row->destination . @$txtVehicleDetail . "',";
        $txt .= "start: '" . $row->start_date . "T" . $row->start_time . "',";
        $txt .= "end: '" . $row->end_date . "T" . $row->end_time . "',";
        $txt .= "color: '" . colorStatus($row->status) . "',";

        return $txt;
    }
}
