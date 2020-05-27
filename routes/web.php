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

// Login admin
Route::group(['prefix' => 'admin-auth','namespace' => 'Auth'], function() {
	Route::get('login','AdminLoginController@getLoginAdmin')->name('get.login.admin');
	Route::post('login','AdminLoginController@postLoginAdmin');
	Route::get('logout','AdminLoginController@getLogoutAdmin')->name('get.logout.admin');
});

Route::get('/',function (){
	return " Xin Chao Phan Trung Phu";
});