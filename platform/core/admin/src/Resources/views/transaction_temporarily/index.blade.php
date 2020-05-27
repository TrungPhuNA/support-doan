@extends('layouts.app_master_admin')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Quản lý khách hàng mua nhanh</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="{{  route('admin.transaction.index') }}"> Transaction</a></li>
			<li class="active"> List </li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<div class="box-title">
					<form class="form-inline">
						<input type="text" class="form-control" value="{{ Request::get('phone') }}" name="phone" placeholder="Phone ...">
					</form>
				</div>
				<div class="box-body table-responsive">
					<table class="table">
						<tbody>
						<tr>
							<th style="width: 10px">#</th>
							<th>Phone</th>
							<th style="width: 100px">Money</th>
							<th style="width: 40%"> Document / Combo</th>
							<th> Status </th>
							<th>Time</th>
							<th>Action</th>
						</tr>
						@if (isset($transactionTemporarily))
							@foreach($transactionTemporarily as $transaction)
								<tr>
									<td>DH{{ $transaction->id }}</td>
									<td>{{ $transaction->tt_phone }}</td>
									@if ($transaction->tt_type == 1)
									<td>{{ number_format($transaction->document->dcm_price,0,',','.') }} đ</td>
									<td>
										<a href="">{{ $transaction->document->dcm_name }}</a>
									</td>
									@else
										<td>{{ number_format($transaction->combo->cd_price,0,',','.') }} đ</td>
										<td>
											<a href="">{{ $transaction->combo->cd_name }}</a>
										</td>
									@endif
									<td>
										<span class="label label-{{ $transaction->getStatus($transaction->tt_status)['class']  }}">{{ $transaction->getStatus($transaction->tt_status)['name'] }}</span>
									</td>

									<td>{{  $transaction->created_at }}</td>
									<td>
										@if ($transaction->tt_status != 2)
											<a href="{{ route('admin.cancel.transaction_temporarily', $transaction->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-times"></i> Huỷ</a>
											<a href="{{ route('admin.success.transaction_temporarily', $transaction->id) }}" class="btn btn-xs btn-success js-process-buy"><i class="fa fa-resistance"></i> Duyệt</a>
											<a href="{{  route('admin.transaction_temporarily.delete', $transaction->id) }}" class="btn btn-xs btn-danger js-delete-confirm"><i class="fa fa-trash"></i> Delete</a>
										@endif
									</td>
								</tr>
							@endforeach
						@endif
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					{!! $transactionTemporarily->appends($query ?? [])->links() !!}
				</div>
				<!-- /.box-footer-->
			</div>
			<!-- /.box -->
		</div>
	</section>
@stop
