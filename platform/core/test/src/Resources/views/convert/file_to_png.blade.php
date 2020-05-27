@extends('test::layouts.app_test_master')
@section('content-test')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Convert File To PNG</h1>
	</div>
	<div class="">
		<form action="" enctype="multipart/form-data" method="POST">
			<div class="input-group mb-3">
				<input type="text" name="url" value="{{ public_path('hop-dong-dai-ly-doc-quyen.pdf') }}" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary">Xác nhận</button>
		</form>
	</div>
@stop