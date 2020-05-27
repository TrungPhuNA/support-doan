<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['namespace' => 'Api','middleware' => ['cors']], function (){
	Route::apiResource('menus', 'ApiMenuController');
	Route::apiResource('articles', 'ApiArticleController');
	Route::get('articles/menu/{menuID}','ApiArticleController@getArticleByMenuId');
    Route::get('articles/relate/{menuID}','ApiArticleController@getArticleRelateByMenuId');
});


