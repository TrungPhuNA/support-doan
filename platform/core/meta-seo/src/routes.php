<?php

	Route::group(['prefix' => 'platform','namespace' => 'Core\MetaSeo\Http\Controllers'], function(){
		Route::get('core','DemoPlatformController@index');
	});