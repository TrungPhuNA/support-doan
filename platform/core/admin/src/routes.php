<?php

Route::group(['prefix' => 'laravel-filemanager','middleware' => 'check_admin_login'], function () {
	\UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['prefix' => 'api-admin','middleware' => 'check_admin_login'], function() {
	Route::get('','AdminController@index')->name('get.admin.index');

	Route::get('statistical','AdminStatisticalController@index')->name('admin.statistical');
	Route::get('contact','AdminContactController@index')->name('admin.contact');
	Route::get('contact/delete/{id}','AdminContactController@delete')->name('admin.contact.delete');

	Route::get('profile','AdminProfileController@index')->name('admin.profile.index');
	Route::post('profile/{id}','AdminProfileController@update')->name('admin.profile.update');
	Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.logs.index');
	Route::get('restart-error-system', 'AdminApiDriverController@restartFlagErrorSystem')->name('admin.restart.flag_errors_system');
	Route::get('thong-bao', 'AdminNotificationController@index')->name('admin.notification');

	/**
	 * Route danh mục sản phẩm
	 **/
	Route::group(['prefix' => 'system-pay','namespace' => 'SystemPay'], function(){
		Route::group(['prefix' => 'pay-in'], function(){
			Route::get('','AdminPayInController@index')->name('admin.system_pay_in.index');
			Route::get('create','AdminPayInController@create')->name('admin.system_pay_in.create');
			Route::post('create','AdminPayInController@store');

			Route::get('update/{id}','AdminPayInController@edit')->name('admin.system_pay_in.update');
			Route::post('update/{id}','AdminPayInController@update');

			Route::get('delete/{id}','AdminPayInController@delete')->name('admin.system_pay_in.delete');

			Route::get('cancel/{id}','AdminPayInController@cancel')->name('admin.system_pay_in.cancel');
			Route::get('process/{id}','AdminPayInController@process')->name('admin.system_pay_in.process');
			Route::get('success/{id}','AdminPayInController@success')->name('admin.system_pay_in.success');
		});
	});

	Route::group(['prefix' => 'document'], function(){
		Route::get('','AdminDocumentController@index')->name('admin.document.index');
		Route::get('create','AdminDocumentController@create')->name('admin.document.create');
		Route::post('create','AdminDocumentController@store');
		Route::get('update/{id}','AdminDocumentController@edit')->name('admin.document.update');
		Route::post('update/{id}','AdminDocumentController@update');
		Route::get('delete/{id}','AdminDocumentController@delete')->name('admin.document.delete');
		Route::get('active/{id}','AdminDocumentController@active')->name('admin.document.active');
		Route::get('hot/{id}','AdminDocumentController@hot')->name('admin.document.hot');
		Route::get('restart-convert/{id}','AdminDocumentController@restartConvertFile')
			->name('admin.document.restart_convert');
		Route::get('convert-avatar/{id}','AdminDocumentController@convertImages')
			->name('admin.document.convert_images');

		Route::get('restart-convert-all','AdminDocumentController@convertAll')->name('admin.document.convert_all');
		Route::get('response/{id}','AdminDocumentController@getDataResponse');
	});

	Route::group(['prefix' => 'combo-document'], function(){
		Route::get('','AdminComboDocumentController@index')->name('admin.combo_document.index');
		Route::get('create','AdminComboDocumentController@create')->name('admin.combo_document.create');
		Route::post('create','AdminComboDocumentController@store');
		Route::get('update/{id}','AdminComboDocumentController@edit')->name('admin.combo_document.update');
		Route::post('update/{id}','AdminComboDocumentController@update');
		Route::get('delete/{id}','AdminComboDocumentController@delete')->name('admin.combo_document.delete');
		Route::get('active/{id}','AdminComboDocumentController@active')->name('admin.combo_document.active');
		Route::get('hot/{id}','AdminComboDocumentController@hot')->name('admin.combo_document.hot');
		Route::get('response/{id}','AdminComboDocumentController@getDataResponse');
	});

	/**
	 * Route danh mục sản phẩm
	 **/
	Route::group(['prefix' => 'category'], function(){
		Route::get('','AdminCategoryController@index')->name('admin.category.index');
//			->middleware('permission:permission_category_list|full');
		Route::get('create','AdminCategoryController@create')->name('admin.category.create');
		Route::post('create','AdminCategoryController@store');

		Route::get('update/{id}','AdminCategoryController@edit')->name('admin.category.update');
		Route::post('update/{id}','AdminCategoryController@update');

		Route::get('active/{id}','AdminCategoryController@active')->name('admin.category.active');
		Route::get('hot/{id}','AdminCategoryController@hot')->name('admin.category.hot');
		Route::get('delete/{id}','AdminCategoryController@delete')->name('admin.category.delete');

	});

	Route::group(['prefix' => 'keyword'], function(){
		Route::get('','AdminKeywordController@index')->name('admin.keyword.index');
		Route::get('create','AdminKeywordController@create')->name('admin.keyword.create');
		Route::post('create','AdminKeywordController@store');

		Route::get('update/{id}','AdminKeywordController@edit')->name('admin.keyword.update');
		Route::post('update/{id}','AdminKeywordController@update');
		Route::get('hot/{id}','AdminKeywordController@hot')->name('admin.keyword.hot');

		Route::get('delete/{id}','AdminKeywordController@delete')->name('admin.keyword.delete');

	});

	Route::group(['prefix' => 'user'], function(){
		Route::get('','AdminUserController@index')->name('admin.user.index');

		Route::get('update/{id}','AdminUserController@edit')->name('admin.user.update');
		Route::post('update/{id}','AdminUserController@update');

		Route::get('delete/{id}','AdminUserController@delete')->name('admin.user.delete');
		Route::get('faking/{id}','AdminUserController@fakingLogin')->name('admin.user.faking_login');
		Route::get('status/{id}','AdminUserController@changeStatus')->name('admin.user.status');
		Route::get('very-account/{id}','AdminUserController@veryAccount')->name('admin.user.very_account');
		Route::get('restart-password/{id}','AdminUserController@changePassword')->name('admin.user.password');
	});

	Route::group(['prefix' => 'transaction'], function(){
		Route::get('','AdminTransactionController@index')->name('admin.transaction.index');
		Route::get('delete/{id}','AdminTransactionController@delete')->name('admin.transaction.delete');
		Route::get('order-delete/{id}','AdminTransactionController@deleteOrderItem')->name('ajax_admin.transaction.order_item');
		Route::get('view-transaction/{id}','AdminTransactionController@getTransactionDetail')->name('ajax.admin.transaction.detail');
		Route::get('action/{action}/{id}','AdminTransactionController@getAction')->name('admin.action.transaction');
	});

	Route::group(['prefix' => 'campaign'], function(){
		Route::get('','AdminCampaignController@index')->name('admin.campaign.index');
	});

	Route::group(['prefix' => 'transaction-temporarily'], function(){
		Route::get('','AdminTransactionTemporarily@index')->name('admin.transaction_temporarily.index');
		Route::get('delete/{id}','AdminTransactionTemporarily@delete')->name('admin.transaction_temporarily.delete');
		Route::get('action/cancel/{id}','AdminTransactionTemporarily@cancel')->name('admin.cancel.transaction_temporarily');
		Route::get('action/success/{id}','AdminTransactionTemporarily@success')->name('admin.success.transaction_temporarily');
	});


	Route::group(['prefix' => 'rating'], function(){
		Route::get('','AdminRatingController@index')->name('admin.rating.index');
		Route::get('delete/{id}','AdminRatingController@delete')->name('admin.rating.delete');
	});

	Route::group(['prefix' => 'menu'], function(){
		Route::get('','AdminMenuController@index')->name('admin.menu.index');
		Route::get('create','AdminMenuController@create')->name('admin.menu.create');
		Route::post('create','AdminMenuController@store');

		Route::get('update/{id}','AdminMenuController@edit')->name('admin.menu.update');
		Route::post('update/{id}','AdminMenuController@update');

		Route::get('active/{id}','AdminMenuController@active')->name('admin.menu.active');
		Route::get('hot/{id}','AdminMenuController@hot')->name('admin.menu.hot');
		Route::get('delete/{id}','AdminMenuController@delete')->name('admin.menu.delete');
	});
	Route::group(['prefix' => 'comment'], function(){
		Route::get('','AdminCommentController@index')->name('admin.comment.index');
		Route::get('delete/{id}','AdminCommentController@delete')->name('admin.comment.delete');
	});

	Route::group(['prefix' => 'tag'], function(){
		Route::get('','AdminTagController@index')->name('admin.tag.index');
		Route::get('create','AdminTagController@create')->name('admin.tag.create');
		Route::post('create','AdminTagController@store');

		Route::get('update/{id}','AdminTagController@edit')->name('admin.tag.update');
		Route::post('update/{id}','AdminTagController@update');

		Route::get('active/{id}','AdminTagController@active')->name('admin.tag.active');
		Route::get('hot/{id}','AdminTagController@hot')->name('admin.tag.hot');
		Route::get('delete/{id}','AdminTagController@delete')->name('admin.tag.delete');
	});

	Route::group(['prefix' => 'article'], function(){
		Route::get('','AdminArticleController@index')->name('admin.article.index');
		Route::get('create','AdminArticleController@create')->name('admin.article.create');
		Route::post('create','AdminArticleController@store');

		Route::get('update/{id}','AdminArticleController@edit')->name('admin.article.update');
		Route::post('update/{id}','AdminArticleController@update');

		Route::get('active/{id}','AdminArticleController@active')->name('admin.article.active');
		Route::get('hot/{id}','AdminArticleController@hot')->name('admin.article.hot');
		Route::get('delete/{id}','AdminArticleController@delete')->name('admin.article.delete');
	});

	Route::group(['prefix' => 'slide'], function(){
		Route::get('','AdminSlideController@index')->name('admin.slide.index');
		Route::get('create','AdminSlideController@create')->name('admin.slide.create');
		Route::post('create','AdminSlideController@store');

		Route::get('update/{id}','AdminSlideController@edit')->name('admin.slide.update');
		Route::post('update/{id}','AdminSlideController@update');

		Route::get('active/{id}','AdminSlideController@active')->name('admin.slide.active');
		Route::get('hot/{id}','AdminSlideController@hot')->name('admin.slide.hot');
		Route::get('delete/{id}','AdminSlideController@delete')->name('admin.slide.delete');
	});

	Route::group(['prefix' => 'event'], function(){
		Route::get('','AdminEventController@index')->name('admin.event.index');
		Route::get('create','AdminEventController@create')->name('admin.event.create');
		Route::post('create','AdminEventController@store');

		Route::get('update/{id}','AdminEventController@edit')->name('admin.event.update');
		Route::post('update/{id}','AdminEventController@update');

		Route::get('delete/{id}','AdminEventController@delete')->name('admin.event.delete');
	});

	Route::group(['prefix' => 'page-static'], function(){
		Route::get('','AdminStaticController@index')->name('admin.static.index');
		Route::get('create','AdminStaticController@create')->name('admin.static.create');
		Route::post('create','AdminStaticController@store');

		Route::get('update/{id}','AdminStaticController@edit')->name('admin.static.update');
		Route::post('update/{id}','AdminStaticController@update');

		Route::get('delete/{id}','AdminStaticController@delete')->name('admin.static.delete');
	});

	Route::get('queue','AdminQueueController@index')->name('admin.queue.index');
	Route::get('queue/restart','AdminQueueController@restart')->name('admin.queue.restart');
	Route::get('api-drive','AdminApiDriverController@index')->name('admin.api_drive.index');
	Route::post('api-drive','AdminApiDriverController@saveSetting');

	Route::get('setting','AdminSettingController@index')->name('admin.setting');
	Route::post('setting','AdminSettingController@saveSetting');

	Route::group(['prefix' => 'ajax'], function(){
		Route::get('/get-pay','AdminGetDataAjaxController@getPayIn')->name('ajax_admin.get_pay_in');
		Route::get('/get-download-document','AdminGetDataAjaxController@getTopDownload')->name('ajax_admin.get_top_download');
		Route::get('/get-dashboard-char','AdminGetDataAjaxController@getCharDashboard')->name('ajax_admin.get_dashboard_char');
	});
});
