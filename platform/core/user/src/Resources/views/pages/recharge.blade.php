@extends('layouts.app_master_user')
@section('css')
	<style>
		<?php $style = file_get_contents('css/user.min.css');echo $style;?>
		.money span {
			font-weight: bold;
			margin-left: 10px;
		}
		.money span:first-child{
			color: red;
		}
	</style>
@stop
@section('content')
	<section>
		<div class="title">Yêu cầu nạp tiền</div>
		<form action="" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="">Số tiền nạp</label>
				<input type="text" name="money" id="money" data-type="currency" class="form-control" value="{{ old('money') }}" placeholder="400,000">
				@if ($errors->first('money'))
					<span class="text-danger">{{ $errors->first('money') }}</span>
				@endif
				<p class="money" style="margin-top: 10px;">
					<span>Mệnh giá</span>
					<a href="#" class="btn btn-xs btn-light js-add-money" >100,000</a>
					<a href="#" class="btn btn-xs btn-light js-add-money" >200,000</a>
					<a href="#" class="btn btn-xs btn-light js-add-money" >300,000</a>
					<a href="#" class="btn btn-xs btn-light js-add-money" >500,000</a>
				</p>
			</div>
			<div class="form-group">
				<select name="provider" id="" class="form-control">
					<option value="1">Chuyển Khoản</option>
					<option value="2">Momo</option>
				</select>
			</div>
			<div class="form-group">
				<label for="">Mô tả</label>
				<input type="text" name="meta" class="form-control" value="{{ old('meta') }}" placeholder="Stk xxx nạp xxx vnđ: SĐT 0988......">
				@if ($errors->first('meta'))
					<span class="text-danger">{{ $errors->first('meta') }}</span>
				@endif
			</div>


			<button type="submit" class="btn btn-blue btn-md">Xác nhận</button>
		</form>

	</section>
@stop
