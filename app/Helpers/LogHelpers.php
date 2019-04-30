<?php
if(!function_exists('thDescription'))
{
	function thDescription($engDescription){ 
		$th = array(
			'created'=>'เพิ่ม',
			'updated'=>'แก้ไข',
			'deleted'=>'ลบ'
		);
		return $th[$engDescription];
	}
}

if(!function_exists('modelNameTh'))
{
	function modelNameTh($model){ 
		$th = array(
			'App\Model\StVehicleType'   => 'ตั้งค่าประเภทรถ',
			'App\Model\StDriver'        => 'ตั้งค่าพนักงานขับรถ',
			'App\Model\StVehicle'       => 'ตั้งค่ายานพาหนะ',
			'App\Model\StRoom'       => 'ตั้งค่าห้องประชุม',
			'App\User'                  => 'ตั้งค่าผู้ใช้งาน',
			'App\Model\PermissionGroup' => 'ตั้งค่าสิทธิ์การใช้งาน',
		);
		return @$th[$model];
	}
}