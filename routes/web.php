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

// Booking
Route::get('booking-room-front/summary/{id}', 'BookingRoomFrontController@summary');
Route::resource('booking-room-front', 'BookingRoomFrontController');

Route::get('booking-vehicle-front/summary/{id}', 'BookingVehicleFrontController@summary');
Route::resource('booking-vehicle-front', 'BookingVehicleFrontController');

Route::get('booking-resource-front/summary/{id}', 'BookingResourceFrontController@summary');
Route::resource('booking-resource-front', 'BookingResourceFrontController');

// Dashboard
Route::get('/home', 'HomeController@index')->name('home');

// ajax
Route::get('ajaxGetBureau', 'AjaxController@ajaxGetBureau');
Route::get('ajaxGetDivision', 'AjaxController@ajaxGetDivision');
Route::get('ajaxGetRoom', 'AjaxController@ajaxGetRoom');
Route::get('ajaxGetVehicle', 'AjaxController@ajaxGetVehicle');
Route::get('ajaxRoomChkOverlap', 'AjaxController@ajaxRoomChkOverlap');
Route::get('ajaxVehicleChkOverlap', 'AjaxController@ajaxVehicleChkOverlap');
Route::get('ajaxResourceChkOverlap', 'AjaxController@ajaxResourceChkOverlap');


// ตั้งค่า
Route::resource('setting/user', 'Setting\\UserController');
Route::resource('setting/permission-group', 'Setting\\PermissionGroupController');
Route::resource('setting/st-room', 'Setting\\StRoomController');
Route::resource('setting/st-vehicle', 'Setting\\StVehicleController');
Route::resource('setting/st-vehicle-type', 'Setting\\StVehicleTypeController');
Route::resource('setting/st-driver', 'Setting\\StDriverController');
Route::resource('setting/st-resource', 'Setting\\StResourceController');

// จองห้องประชุม
Route::get('booking-room/summary/{id}', 'BookingRoomController@summary');
Route::resource('booking-room', 'BookingRoomController');

// จองยานพาหนะ
Route::get('booking-vehicle/summary/{id}', 'BookingVehicleController@summary');
Route::resource('booking-vehicle', 'BookingVehicleController');

// จองทรัพยากร
Route::get('booking-resource/summary/{id}', 'BookingResourceController@summary');
Route::resource('booking-resource', 'BookingResourceController');

// log
Route::resource('log', 'LogController');

// รายงาน
Route::get('report1', 'ReportController@report1');
Route::get('report2', 'ReportController@report2');

