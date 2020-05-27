<?php
Route::group(['prefix' => 'api-admin','middleware' => 'check_admin_login'], function() {
	Route::group(['prefix' => 'permission'], function () {
		Route::get('/','AclPermissionController@index')->name('admin.permission.list')
		;// ->middleware('permission:permission_list|full');

		Route::get('create','AclPermissionController@create')->name('admin.permission.create')
		;// ->middleware('permission:permission_create|full');

		Route::post('create','AclPermissionController@store');

		Route::get('update/{id}','AclPermissionController@edit')->name('admin.permission.update')
		;// ->middleware('permission:permission_update|full');

		Route::post('update/{id}','AclPermissionController@update');

		Route::get('delete/{id}','AclPermissionController@delete')->name('admin.permission.delete')
		;// ->middleware('permission:permission_delete|full');
	});

	Route::group(['prefix' => 'role'], function () {
		Route::get('/','AclRoleController@index')->name('admin.role.list')
		;// ->middleware('permission:role_create|full');

		Route::get('create','AclRoleController@create')->name('admin.role.create')
		;// ->middleware('permission:role_create|full');

		Route::post('create','AclRoleController@store');

		Route::get('update/{id}','AclRoleController@edit')->name('admin.role.update')
		;// ->middleware('permission:role_update|full');

		Route::post('update/{id}','AclRoleController@update');

		Route::get('delete/{id}','AclRoleController@delete')->name('admin.role.delete')
		;// ->middleware('permission:role_delete|full');
	});

	Route::group(['prefix' => 'admin'], function () {
		Route::get('/','AclAdminController@index')->name('admin.admin.list')
		;// ->middleware('permission:admin_list|full');

		Route::get('create','AclAdminController@create')->name('admin.admin.create')
		;// ->middleware('permission:admin_create|full');

		Route::post('create','AclAdminController@store');

		Route::get('update/{id}','AclAdminController@edit')->name('admin.admin.update')
		;// ->middleware('permission:admin_update|full');

		Route::post('update/{id}','AclAdminController@update');

		Route::get('delete/{id}','AclAdminController@delete')->name('admin.admin.delete')
		;// ->middleware('permission:admin_delete|full');;

		Route::get('status/{id}','AclAdminController@changeStatus')->name('admin.admin.status');
	});
});