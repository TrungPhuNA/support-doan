@extends('layouts.app_master_admin')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Cấu Hình Cơ Bản</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<form role="form" action="" method="POST" enctype="multipart/form-data">
			@csrf
			<!-- Default box -->
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">API Convert File</h3>
				</div>
				<div class="box-body">
					<div class="form-group col-sm-3">
						<label for="exampleInputEmail1">Content</label>
						<input type="text" required name="convert_file_api_secret" value="{{ $data['api']['convert_file_api_secret'] ?? '' }}" class="form-control">
					</div>
					<div class="form-group col-sm-2">
						<label for="exampleInputEmail1">Time còn lại</label>
						<input type="text" disabled name="" value="{{ $time }} s" class="form-control">
					</div>
				</div>
			</div>
			<div class="box-footer text-center">
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Cập nhật </button> </div>
		</form>
	</section>
	<!-- /.content -->
@stop