<?php

Route::group(['prefix' => 'account','middleware' => ['check_user_login','web']], function() {
	Route::get('','UserDashboardController@dashboard')->name('get.user.dashboard');

	Route::get('update-info','UserInfoController@updateInfo')->name('get.user.update_info');
	Route::post('update-info','UserInfoController@saveUpdateInfo');

	Route::get('transaction','UserTransactionController@index')->name('get.user.transaction');
	Route::get('order/view/{id}','UserTransactionController@viewOrder')->name('get.user.order');

	Route::get('rating','UserRatingController@index')->name('get.user.rating');
	Route::get('log-login','LogLoginUserController@index')->name('get.user.log_login');

	Route::get('friend','UserFriendController@getListFriendById')->name('get.user.friend');

	Route::get('tracking/view/{id}','UserTransactionController@getTrackingTransaction')->name('get.user.tracking_order');
	Route::get('favourite','UserFavouriteController@index')->name('get.user.favourite');
	Route::get('favourite-delete/{id}','UserFavouriteController@delete')->name('get.user.favourite.delete');

	Route::get('management-transaction','UserManagementTransaction@index')->name('get.user.management_transaction');

	Route::post('ajax-favourite/{idProduct}','UserFavouriteController@addFavourite')->name('ajax_get.user.add_favourite');
	Route::post('ajax-rating','UserRatingController@addRatingProduct')->name('ajax_post.user.rating.add');
	Route::post('captcha', 'CaptchaController@authCaptchaResume')->name('ajax_post.captcha.resume');


//	Route::get('nap-tien','UserRechargeController@getRacherge')->name('get.user.recharge');
	Route::post('nap-tien','UserRechargeController@postRacherge')->name('post.user.recharge');

	// Xử lý check và download document
	Route::get('render-download-document','UserDownloadDocumentController@renderViewDownloadDocument')
		->name('get.document.preview_download_document');

	Route::get('download-document','UserDownloadDocumentController@downloadDocument')
		->name('get.document.download');

	// User mua combo
	Route::post('ajax-pay-combo/{id}','UserComboDocumentController@initPayCombo')->name('ajax_post.combo.pay');
	Route::get('render-view-download-combo','UserComboDocumentController@renderViewDownloadCombo')
		->name('get.view.download_combo');
	Route::get('download-item-combo','UserComboDocumentController@downloadItemDocumentCombo')->name('get.download_document_combo');

	Route::group(['prefix' => 'ajax'], function(){
		Route::post('update-info/{id}','UserInfoController@updateInfoAjax')
			->name('ajax_post.user.update_info');
	});
});