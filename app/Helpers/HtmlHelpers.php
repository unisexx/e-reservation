<?php

if(!function_exists('auto_running_number'))
{
	function auto_running_number($st_branch_id){ 
		/**
		 * คำนวนจาก รหัสสาขา + autorunningnumber 4 หลัก
		 * 1. หา row สุดท้ายของสาขา ในตาราง plans เพื่อหาเลขล่าสุด
		 * 2. นำเลขล่าสุดที่ได้มา +1 จะได้เป็นรหัสเพื่อนำไปใช้
		 */

		// 1. หา row สุดท้ายของสาขา ในตาราง plans เพื่อหาเลขล่าสุด
		$rs = App\Model\Plan::where('st_branch_id', $st_branch_id)->orderBy('orderlist','desc')->first();
	
		// 2. นำเลบล่าสุดที่ได้มา +1 จะได้เป็นรหัสเพื่อนำไปใช้
		$last_number = @$rs->orderlist + 1;

		return $last_number;
	}
}