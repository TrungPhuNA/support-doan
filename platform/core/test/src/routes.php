<?php

Route::group(['prefix' => 'system-test'], function(){
	Route::get('/','HomeTestController@index')->name('get.test.home');
	Route::group(['prefix' => 'upload-multiple-document'], function(){
		Route::get('/add','UploadMultipleDocumentTestController@add')
			->name('get.test.upload_multiple_document.add');
		Route::post('/add','UploadMultipleDocumentTestController@store');
	});

	Route::get('file-to-png','ConvertFileToPngController@index')->name('get.test.file_to_png');
	Route::post('file-to-png','ConvertFileToPngController@convertFileToPng');

	Route::post('callback/data/{id}','ConvertFileToPngController@callbackApi')->name('get.callback_data');

	Route::get('pdf-to-html','ConvertPdfToHtml@index')->name('get.test.pdf_to_html');
	Route::post('pdf-to-html','ConvertPdfToHtml@store');
	Route::get('word-to-pdf','ConvertFileController@convertWordToPdf')->name('get.test.word_to_pdf');
	Route::get('create-thumbnail','CreateThumbnailImage@index')->name('get.test.create_thumbnail');

	Route::group(['prefix' => 'pusher'], function(){
		Route::get('','PusherTestController@index')->name('get.test.pusher_index');
		Route::get('success','PusherTestController@renderView');
		Route::post('','PusherTestController@submitMessages');
	});

	Route::group(['prefix' => 'email'], function(){
		Route::get('','EmailTestController@index')->name('get.test.email');
		Route::post('save-send-email','EmailTestController@sendEmail')->name('post.test.send_email');
	});
});