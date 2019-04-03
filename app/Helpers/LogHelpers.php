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
			'App\Model\StAscc'=>'ตั้งค่าแผนงาน ASCC พ.ศ.2568 (109 มาตรการ)',
			'App\Model\StCulturalPole'=>'ตั้งค่าแผนงานเสาสังคมและวัฒนธรรมของไทย',
			'App\Model\StNationalStrategy'=>'ตั้งค่ายุทธศาสตร์ชาติ',
			'App\Model\StReformPlan'=>'ตั้งค่าแผนปฏิรูปประเทศ 11 ด้าน',
			'App\Model\StEcoDevPlan'=>'ตั้งค่าแผนพัฒนาเศรษฐกิจและสังคมแห่งชาติฉบับที่ 12',
			'App\Model\StDevGoal'=>'ตั้งค่าเป้าหมายการพัฒนาที่ยั่งยืน',
			'App\Model\StDriveBoard'=>'ตั้งค่าคณะกรรมการขับเคลื่อนและปฏิรูปการบริหารราชการแผ่นดิน',
			'App\Model\StIssue'=>'ตั้งค่าประเด็น',
			'App\Model\StBranch'=>'ตั้งค่าสาขาเสาสังคม',
			'App\User'=>'ตั้งค่าผู้ใช้งาน',
			'App\Model\PermissionGroup'=>'ตั้งค่าสิทธิ์การใช้งาน',
			'App\Model\Plan'=>'แผนงาน',
		);
		return @$th[$model];
	}
}