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
