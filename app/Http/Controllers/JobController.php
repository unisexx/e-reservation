<?php
/**
 * คู่มือ queue for email
 * https://blog.mailtrap.io/laravel-mail-queue/
 * รันคำสั่ง php artisan queue:work ก่อนใช้งาน
 */
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Jobs\SendEmail;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
	public function enqueue(Request $request)
	{
		$details = ['email' => 'recipient@example.com'];
		SendEmail::dispatch($details);
	}

	// public function enqueue(Request $request)
    // {
    //     $details = ['email' => 'recipient@example.com'];
    //     $emailJob = (new      SendEmail($details))->delay(Carbon::now()->addMinutes(5));
    //     dispatch($emailJob);
    // }

	// public function enqueue(Request $request)
	// {
	// 	$details = ['email' => 'recipient@example.com'];
	// 	SendEmail::dispatchNow($details);
	// }

}