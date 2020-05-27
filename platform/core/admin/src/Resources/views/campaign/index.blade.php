@extends('layouts.app_master_admin')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Quản lý chiến dịch</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<div class="box-body">
					<div class="col-md-12">
						<table class="table">
							<tbody>
							<tr>
								<th style="width: 10px">#</th>
								<th>Name</th>
								<th>Source</th>
								<th>IP</th>
							</tr>
							</tbody>
							@if ($campaigns)
								@foreach($campaigns as $item)
									<tr>
										<td>{{ $item->id }}</td>
										<td><a href="{{ $item->cp_source }}" target="_blank">{{ $item->cp_source }}</a></td>
										<td><a href="{{ $item->cp_url }}" target="_blank">{{ $item->cp_url }}</a></td>
										<td>
											{{ $item->cp_ip }}
										</td>
									</tr>
								@endforeach
							@endif
						</table>
					</div>
				</div>
			</div>
			<div>
				{!! $campaigns->links() !!}
			</div>
			<!-- /.box -->
		</div>
	</section>
	<!-- /.content -->
@stop