@extends('layouts.app_master_user')
@section('css')
	<style>
		<?php $style = file_get_contents('css/user.min.css');echo $style;?>
	</style>
@stop
@section('content')
	<section>
		<div class="title">Danh sách bạn bè</div>
		<form class="form-inline">
			<div class="form-group " style="margin-right: 10px;">
				<input type="text" class="form-control" value="{{ Request::get('id') }}" name="id" placeholder="ID">
			</div>
			<div class="form-group" style="margin-right: 10px;">
				<button type="submit" class="btn btn-pink btn-sm">Tìm kiếm</button>
			</div>
		</form>
		<div class="table-responsive">
			<div class="pull-left">
				Hiển thị: <b>{{ $users->firstItem() }}</b> to <b>{{ $users->lastItem() }}</b>
				/ Tổng <b>{{ $users->total() }}</b> record
			</div>
			<table class="table table-striped">
				<thead>
				<tr>
					<th scope="col">Mã TV</th>
					<th scope="col">Name</th>
					<th scope="col">Email</th>
					<th scope="col">Phone</th>
					<th scope="col">Status</th>
					<th scope="col">Ngày tạo</th>
				</tr>
				</thead>
				<tbody>
				@foreach($users as $item)
					<tr>
						<td scope="row" class="text-center">
							<a href="">{{  $item->id }}</a>
						</td>
						<td class="text-center">{{ $item->name  }}</td>
						<td class="text-center">{{ $item->email  }}</td>
						<td class="text-center">{{ $item->phone  }}</td>
						<td class="text-center">
							<span
							   class="label label-{{ $item->getStatus($item->status)['class'] }}">
								{{ $item->getStatus($item->status)['name'] }}</span>
						</td>
						<td class="text-center">{{  $item->created_at }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<div class="pull-left">
				Hiển thị: <b>{{ $users->firstItem() }}</b> to <b>{{ $users->lastItem() }}</b>
				/ Tổng <b>{{ $users->total() }}</b> record
			</div>
		</div>
		@if ($users->nextPageUrl())
			<a class="btn btn-pink btn-radius btn-next-page" href="{{ $users->appends($query)->nextPageUrl() }}">Xem thêm <i class="fa fa-long-arrow-right"></i></a>
		@endif
	</section>
@stop
