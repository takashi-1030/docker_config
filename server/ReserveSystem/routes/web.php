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
Route::get('/reserve_seat', 'ReserveController@reserveSeat');
Route::get('/guest_info', 'ReserveController@postInfo');
Route::post('/check', 'ReserveController@reserveCheck');
Route::post('/reserve_done', 'ReserveController@reserveDone');

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
Route::get('/admin/delete/{id}', 'AdminController@delete');
Route::get('/admin/confirm/{id}', 'AdminController@reserveConfirm');
Route::get('/admin/reject/{id}', 'AdminController@reserveReject');
Route::get('/admin/config', 'AdminController@config');
Route::post('/admin/config/time', 'AdminController@configTime');

//管理者登録・削除・一覧画面
Route::get('/admin/list', 'AdminController@adminList');
Route::get('/admin/admincreate', 'AdminController@adminCreate');
Route::post('/admin/admincreate', 'AdminController@adminCreateCheck');
Route::post('/admin/admincreate/done', 'AdminController@adminCreateDone');
Route::get('/admin/admindelete/{id}', 'AdminController@adminDelete');
Route::post('/admin/admindelete/done/{id}', 'AdminController@adminDeleteDone');

//お客様一覧
Route::get('/admin/customerList', 'AdminController@customerList');

//お客様検索
Route::get('admin/search', 'AdminController@search');
Route::post('admin/search/done', 'AdminController@searchDone');

//ajax
Route::get('/seat', 'ReserveController@ajax');
Route::get('admin/seat', 'AdminController@editAjax');
Route::get('admin/add/seat', 'AdminController@addAjax');

//Event取得
Route::get('/setEvent', 'EventController@setEvent');