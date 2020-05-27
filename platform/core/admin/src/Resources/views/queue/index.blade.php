@extends('layouts.app_master_admin')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Quản lý Queue</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<a href="{{ route('admin.queue.restart') }}" class="btn btn-primary">Restart Queue</a>
				<div class="box-body table-responsive">
					<table class="table">
						<tbody>
						<tr>
							<th style="width: 10px">#</th>
							<th>Queue</th>
							<th>Payload</th>
						</tr>
						@if (isset($queues))
							@foreach($queues as $item)
								<tr>
									<td>{{ $item->id }}</td>
									<td>{{ $item->queue }}</td>
									<td>{{ $item->payload }}</td>
								</tr>
							@endforeach
						@endif
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					{!! $queues->links() !!}
				</div>
				<!-- /.box-footer-->
			</div>
			<!-- /.box -->
	</section>
	<!-- /.content -->
@stop