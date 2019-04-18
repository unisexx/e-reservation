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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// หน้าแรก
Route::get('/home', 'HomeController@index')->name('home');

// ajax
Route::get('ajaxGetBureau', 'AjaxController@ajaxGetBureau');
Route::get('ajaxGetDivision', 'AjaxController@ajaxGetDivision');

// ตั้งค่า
Route::resource('setting/st-room', 'Setting\\StRoomController');
Route::resource('setting/st-vehicle', 'Setting\\StVehicleController');
Route::resource('setting/st-vehicle-type', 'Setting\\StVehicleTypeController');
Route::resource('setting/st-driver', 'Setting\\StDriverController');

