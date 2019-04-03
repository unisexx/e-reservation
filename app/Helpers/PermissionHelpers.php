<?php

// ใช้ใน blade
if(!function_exists('CanPerm'))
{
	function CanPerm($name=false)
	{
		// permission(plan-view);
		$rs = App\Model\Permission::where('name',$name)
				->WhereHas('permission_roles',function($q){
					$q->where('permission_group_id',Auth::user()->permission_group_id);
				})->first();
    	return @$rs->id != '' ? true : false ;
	}
}

// ใช้ใน controller
if(!function_exists('ChkPerm'))
{
	function ChkPerm($name=false, $url_redirect = 'plan')
	{
		// permission(plan-view);
		$rs = App\Model\Permission::where('name',$name)
				->WhereHas('permission_roles',function($q){
					$q->where('permission_group_id',Auth::user()->permission_group_id);
				})->first();

		if(@$rs->id == ''){
			set_notify('error', 'คุณไม่มีสิทธิ์การใช้งานในส่วนนี้');
			Redirect::to($url_redirect)->send();
		}
	}
}