@extends('test::layouts.app_test_master')
@section('content-test')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Convert Pdf To Html</h1>
	</div>
	<div class="">
		<form action="" enctype="multipart/form-data" method="POST">
			<div class="input-group mb-3">
				<input type="text" name="file" value="{{ public_path('de-toan-ho-thuc-thuan-de-13-co-dap-an-da-doi.pdf') }}" class="form-control">
			</div>
			<img src="https://v2.convertapi.com/d/2c4a3a045cb43eef7fb0b8172573307c/hop-dong-dai-ly-doc-quyen.png" alt="">
			<button type="submit" class="btn btn-primary">Xác nhận</button>
		</form>
	</div>
@stop