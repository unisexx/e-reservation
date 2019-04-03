<?php
if(!function_exists('DB2Date'))
{
	function DB2Date($Dt){ 
		if(($Dt!=NULL)&&($Dt != '0000-00-00')){
			@list($date,$time) = explode(" ",$Dt);
			list($y,$m,$d) = explode("-",$date);
			return $d."/".$m."/".($y+543);
		}else{
			$Dt = "";
			return $Dt; 
		}
	}
}

if(!function_exists('Date2DB'))
{
	function Date2DB($Dt){
		if(($Dt!="")&&($Dt != '0000-00-00')){
			@list($date,$time) = explode(" ",$Dt);
			list($d,$m,$y) = explode("/",$date);
			return ($y-543)."-".$m."-".$d;
		}else{ return $Dt; }
	}
}

if (!function_exists('DBToDate')) {
	function DBToDate($date = null, $is_date_thai = true, $showTime = false)
	{
		if (!$date ||
			$date == '0000-00-00' ||
			$date == '0000-00-00 00:00:00') {
			return null;
		}
		//year tyep (buddha or christ).
		$year = ($is_date_thai) ? (date('Y', strtotime($date)) + 543) : date('Y', strtotime($date));
		return ($showTime) ? date('d/m/', strtotime($date)) . $year . ' ' . date('H:i:s', strtotime($date)) : date('d/m/', strtotime($date)) . $year;
	}
}