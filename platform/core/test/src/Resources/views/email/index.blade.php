@extends('test::layouts.app_test_master')
@section('content-test')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Send email</h1>
	</div>
	<div class="">
		<form action="{{ route('post.test.send_email') }}" enctype="multipart/form-data" method="POST">
			@csrf
			<div class="input-group mb-3">
				<input type="email" name="email" value="phupt.humg.94@gmail.com" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary">Xác nhận</button>
		</form>
	</div>
@stop