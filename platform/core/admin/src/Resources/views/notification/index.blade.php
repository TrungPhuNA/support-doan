@extends('layouts.app_master_admin')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Quản lý thông báo</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"> List </li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->

		<div class="box">


			<div class="box-header with-border">
{{--				<div class="box-title">--}}
{{--					<form class="form-inline">--}}
{{--						<input type="text" class="form-control" value="{{ Request::get('phone') }}" name="phone" placeholder="phone">--}}
{{--						<input type="text" class="form-control" value="{{ Request::get('email') }}" name="email" placeholder="Email ...">--}}

{{--						<button type="submit" name="export" value="true" class="btn btn-info">--}}
{{--							<i class="fa fa-search"></i> Search--}}
{{--						</button>--}}
{{--					</form>--}}
{{--				</div>--}}
				<div class="box-body table-responsive">
					<table class="table">
						<tbody>
						<tr>
							<th style="width: 10px">#</th>
							<th>Nội dung </th>
							<th>Time</th>
{{--							<th>Action</th>--}}
						</tr>
						@if (isset($notifications))
							@foreach($notifications as $item)
								<tr>
									<td>{{ $item->id }}</td>
									<td>{!! $item->data !!}</td>
									<td>{!! $item->created_at !!}</td>
								</tr>
							@endforeach
						@endif
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					{!! $notifications->appends($query ?? [])->links() !!}
				</div>
				<!-- /.box-footer-->
			</div>
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
@stop