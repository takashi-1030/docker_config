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

//ユーザー閲覧画面
Route::get('/', 'ReserveController@reserveTop');
Route::post('/reserve_seat', 'ReserveController@reserveSeat');
Route::post('/guest_info', 'ReserveController@postInfo');
Route::post('/check', 'ReserveController@reserveCheck');
Route::post('/reserve_done', 'ReserveController@reserveDone');

//管理者閲覧画面
Route::get('/admin', 'AdminController@getIndex');
Route::get('/admin/reserve/{id}', 'AdminController@getReserve');
Route::get('/admin/edit/{id}', 'AdminController@reserveEdit');
Route::post('/admin/edit/{id}', 'AdminController@editCheck');
Route::post('/admin/edit/done/{id}', 'AdminController@editDone');
Route::get('/admin/add', 'AdminController@addReserve');
Route::post('/admin/add', 'AdminController@reserveCheck');
Route::post('/admin/add/done', 'AdminController@addDone');
Route::get('/admin/confirm/{id}', 'AdminController@reserveConfirm');

//Event取得
Route::get('/setEvent', 'EventController@setEvent');

//zoom API
Route::get('/meetings', 'MeetingController@show');
Route::get('/meetings/create', 'MeetingController@create');
Route::post('/meetings/create' ,'MeetingController@store');