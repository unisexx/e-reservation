<?php

if(!function_exists('colorStatus'))
{
	function colorStatus($status_txt){ 
		$color = array("รออนุมัติ"=>"#ffc107", "อนุมัติ"=>"#28a745", "ไม่อนุมัติ"=>"#dc3545", "ยกเลิก"=>"#6c757d");
		return $color[$status_txt];
	}
}