<?php

if(!function_exists('colorStatus'))
{
	function colorStatus($status_txt){ 
		$color = array("รออนุมัติ"=>"#ff9800", "อนุมัติ"=>"#4caf50", "ไม่อนุมัติ"=>"#f44336", "ยกเลิก"=>"#999999");
		return $color[$status_txt];
	}
}