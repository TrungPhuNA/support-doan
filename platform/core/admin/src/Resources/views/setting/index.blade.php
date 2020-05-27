@extends('layouts.app_master_admin')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Cấu Hình Website</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<form role="form" action="" method="POST" enctype="multipart/form-data">
		@csrf
		<!-- Default box -->
			<div class="row">
				<div class="col-sm-6">
					<div class="box box-warning">
						<div class="box-header with-border">
							<h3 class="box-title">Cấu hình email</h3>
						</div>
						<div class="box-body">
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1">Loại</label>
								<input type="text" required name="mail_driver" value="{{ $email->mail_driver ?? "" }}" class="form-control">
							</div>
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1">Cổng</label>
								<input type="text"  name="mail_port" value="{{ $email->mail_port ?? "" }}" class="form-control">
							</div>
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1">Máy chủ</label>
								<input type="text"  name="mail_host" value="{{ $email->mail_host ?? "" }}" class="form-control">
							</div>
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1">Tên đăng nhập</label>
								<input type="text"  name="mail_username" value="{{ $email->mail_username ?? "" }}" class="form-control">
							</div>
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1">Mật khẩu</label>
								<input type="text"  name="mail_password" value="{{ $email->mail_password ?? "" }}" class="form-control">
							</div>
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1">Tên miền</label>
								<input type="text"  name="mail_domain" value="{{ $email->mail_domain ?? "" }}" class="form-control">
							</div>
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1">Người gửi</label>
								<input type="text"  name="mail_from_address" value="{{ $email->mail_from_address ?? "" }}" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="box box-warning">
						<div class="box-header with-border">
							<h3 class="box-title">Cấu hình money</h3>
						</div>
						<div class="box-body">
							<div class="form-group col-sm-12">
								<label for="exampleInputEmail1">% hoa hồng mua tài liệu người gt</label>
								<input type="number" required name="cfg_percent_rose" value="{{ $configuration->cfg_percent_rose ?? "0" }}" class="form-control">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer text-center">
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Cập nhật </button>
			</div>
		</form>
	</section>
	<!-- /.content -->
@stop