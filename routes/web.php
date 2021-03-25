<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();

Route::get('/', function () {
    // return view('welcome');
    return view('booking');
});

// ่jquery load view
Route::get('load-bossres', function () {
    return view('include.___res_form');
});

// คู่มือ
Route::get('download/admin', function () {
    $file = public_path() . "/manual/admin.pdf";
    $headers = array(
        'Content-Type: application/pdf',
    );

    return Response::download($file, 'ระบบการขอใช้ทรัพยากร (e-Reservation)-ผู้ดูเเลระบบ.pdf', $headers);
});

Route::get('download/user', function () {
    $file = public_path() . "/manual/user.pdf";
    $headers = array(
        'Content-Type: application/pdf',
    );

    return Response::download($file, 'ระบบการขอใช้ทรัพยากร (e-Reservation)-ผู้ใช้งาน.pdf', $headers);
});

Route::get('download/permform', function () {
    $file = public_path() . "/manual/permission_form.pdf";
    $headers = array(
        'Content-Type: application/pdf',
    );

    return Response::download($file, 'แบบกำหนดสิทธิ MSOBooking_new26082563.pdf', $headers);
});

// Booking
Route::get('booking-room-front/province', 'BookingRoomFrontController@province');
Route::get('booking-room-front/summary/{id}', 'BookingRoomFrontController@summary');
Route::get('booking-room-front/print/{id}', 'BookingRoomFrontController@print');
Route::resource('booking-room-front', 'BookingRoomFrontController');

Route::get('booking-vehicle-front/province', 'BookingVehicleFrontController@province');
Route::get('booking-vehicle-front/summary/{id}', 'BookingVehicleFrontController@summary');
Route::get('booking-vehicle-front/print/{id}', 'BookingVehicleFrontController@print');
Route::resource('booking-vehicle-front', 'BookingVehicleFrontController');

Route::get('booking-resource-front/summary/{id}', 'BookingResourceFrontController@summary');
Route::resource('booking-resource-front', 'BookingResourceFrontController');

Route::get('booking-boss-front/summary/{id}', 'BookingBossFrontController@summary');
Route::get('booking-boss-front/print/{id}', 'BookingBossFrontController@print');
Route::get('booking-boss-front/schedule', 'BookingBossFrontController@schedule');
Route::resource('booking-boss-front', 'BookingBossFrontController');

// Dashboard
Route::get('/home', 'HomeController@index')->name('home');

// ajax
Route::get('ajaxGetBureau', 'AjaxController@ajaxGetBureau');
Route::get('ajaxGetDivision', 'AjaxController@ajaxGetDivision');
Route::get('ajaxGetRoom', 'AjaxController@ajaxGetRoom');
Route::get('ajaxGetRoomDetail', 'AjaxController@ajaxGetRoomDetail');
Route::get('ajaxGetVehicle', 'AjaxController@ajaxGetVehicle');
Route::get('ajaxRoomChkOverlap', 'AjaxController@ajaxRoomChkOverlap');
Route::get('ajaxVehicleChkOverlap', 'AjaxController@ajaxVehicleChkOverlap');
Route::get('ajaxResourceChkOverlap', 'AjaxController@ajaxResourceChkOverlap');
Route::get('ajaxGetBookingRoom', 'AjaxController@ajaxGetBookingRoom');
Route::get('ajaxGetDriver', 'AjaxController@ajaxGetDriver');
Route::get('ajaxGetBureauVehicle', 'AjaxController@ajaxGetBureauVehicle');
Route::get('ajaxGetDivisionVehicle', 'AjaxController@ajaxGetDivisionVehicle');
Route::get('ajaxSetDefaultRoom', 'AjaxController@ajaxSetDefaultRoom');
Route::get('ajaxBossChkOverlap', 'AjaxController@ajaxBossChkOverlap');
Route::get('ajaxGetBoss', 'AjaxController@ajaxGetBoss');

// test email
Route::get('email-room-front/{bookingId}', 'BookingRoomFrontController@testEmail');
Route::get('email-room-back/{bookingId}', 'BookingRoomController@testEmail');
Route::get('email-boss-front/{bookingId}', 'BookingBossFrontController@testEmail');
Route::get('email-boss-back/{bookingId}', 'BookingBossController@testEmail');
Route::get('email-vehicle-front/{bookingId}', 'BookingVehicleFrontController@testEmail');
Route::get('email-vehicle-back/{bookingId}', 'BookingVehicleController@testEmail');
Route::get('email-resource-front/{bookingId}', 'BookingResourceFrontController@testEmail');
Route::get('email-resource-back/{bookingId}', 'BookingResourceController@testEmail');

Route::middleware(['auth'])->group(function () {
    // ตั้งค่า
    Route::resource('setting/user', 'Setting\\UserController');
    Route::resource('setting/permission-group', 'Setting\\PermissionGroupController');
    Route::resource('setting/st-room', 'Setting\\StRoomController');
    Route::resource('setting/st-vehicle', 'Setting\\StVehicleController');
    Route::resource('setting/st-vehicle-type', 'Setting\\StVehicleTypeController');
    Route::resource('setting/st-driver', 'Setting\\StDriverController');
    Route::resource('setting/st-resource', 'Setting\\StResourceController');
    Route::resource('setting/st-boss', 'Setting\\StBossController');
    Route::resource('setting/st-position-level', 'Setting\\StPositionLevelController');
    Route::resource('setting/st-position-meeting', 'Setting\\StPositionMeetingController');

    // จองห้องประชุม/อบรม
    Route::get('booking-room/summary/{id}', 'BookingRoomController@summary');
    Route::resource('booking-room', 'BookingRoomController');

    // จองห้องประชุม conference
    Route::resource('booking-room-conference', 'BookingRoomConferenceController');

    // จองยานพาหนะ
    Route::get('booking-vehicle/summary/{id}', 'BookingVehicleController@summary');
    Route::resource('booking-vehicle', 'BookingVehicleController');

    // จองทรัพยากรอื่นๆ
    Route::get('booking-resource/summary/{id}', 'BookingResourceController@summary');
    Route::resource('booking-resource', 'BookingResourceController');

    // จองวาระผู้บริหาร
    Route::get('booking-boss/summary/{id}', 'BookingBossController@summary');
    Route::resource('booking-boss', 'BookingBossController');

    // log
    Route::resource('log', 'LogController');

    // รายงาน
    Route::get('report1', 'ReportController@report1');
    Route::get('report1_detail', 'ReportController@report1_detail');
    Route::get('report2', 'ReportController@report2');
    Route::get('report2_detail', 'ReportController@report2_detail');
    Route::get('report3', 'ReportController@report3');
    Route::get('report3_detail', 'ReportController@report3_detail');
    Route::get('report4', 'ReportController@report4');
    Route::get('report4_detail', 'ReportController@report4_detail');

    // profile
    Route::get('profile', 'HomeController@profile');
    Route::patch('profile_save', 'HomeController@profile_save');

});

// Route::get('email-test', function(){
//     $details['email'] = 'unisexx@gmail.com';
//     dispatch(new App\Jobs\SendEmailJob($details));
//     dd('done');
// });

// Route::get('test-email', 'JobController@enqueue');

// Route::get('command', function () {
//     /* php artisan migrate */
//     \Artisan::call('queue:work');
//     dd("Done");
// });

Route::any('captcha-test', function () {
    if (request()->getMethod() == 'POST') {
        $rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(request()->all(), $rules);
        if ($validator->fails()) {
            echo '<p style="color: #ff0000;">Incorrect!</p>';
        } else {
            echo '<p style="color: #00ff30;">Matched :)</p>';
        }
    }

    $form = '<form method="post" action="captcha-test">';
    $form .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    $form .= '<p>' . captcha_img() . '</p>';
    $form .= '<p><input type="text" name="captcha"></p>';
    $form .= '<p><button type="submit" name="check">Check</button></p>';
    $form .= '</form>';

    return $form;
});

// Route::any('test', 'HomeController@test');
