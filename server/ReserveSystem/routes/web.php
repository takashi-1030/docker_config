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

//ajax
Route::get('/seat', 'ReserveController@ajax');

//管理者ログイン
Route::get('/admin/login', 'AdminController@adminGetIndex');
Route::post('/admin/login', 'AdminController@adminPostIndex');

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

//管理者登録・削除・一覧画面
Route::get('/admin/list', 'AdminController@adminList');
Route::get('/admin/adminCreate', 'AdminController@adminCreate');
Route::post('/admin/adminCreate', 'AdminController@adminCreateCheck');
Route::post('/admin/adminCreate/done', 'AdminController@adminCreateDone');
Route::get('/admin/adminDelete/{id}', 'AdminController@adminDelete');
Route::post('/admin/adminDelete/done/{id}', 'AdminController@adminDeleteDone');

//Event取得
Route::get('/setEvent', 'EventController@setEvent');