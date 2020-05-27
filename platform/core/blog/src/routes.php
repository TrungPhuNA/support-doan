<?php

Route::group(['prefix' => 'tin-tuc'], function(){
	Route::get('/','HomeBlogController@index')->name('get.blog.home');
	Route::get('{slug}','BlogHubController@renderUrl')->name('get.render_url_seo_blog');
});