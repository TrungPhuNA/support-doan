<div class="box-body table-responsive">
	<table class="table">
		<tbody>
		<tr>
			<th style="width: 10px">#</th>
			<th>User</th>
			<th>Provider</th>
			<th>Money</th>
			<th>Status</th>
		</tr>
		@foreach($payIns as $pay)
			<tr>
				<td>{{ $pay->id }}</td>
				<td>{{ $pay->user->name ?? "[N\A]" }}</td>
				<td>
					<span class="label {{ $pay->getProvider($pay->pi_provider)['class'] }}">
						{{ $pay->getProvider($pay->pi_provider)['name'] }}
					</span>
				</td>
				<td>
					<b>{{ number_format($pay->pi_money,0,',','.') }} <sup>VNĐ</sup></b>
				</td>
				<td>
					<span class="label {{ $pay->getStatus($pay->pi_status)['class'] }}">{{ $pay->getStatus($pay->pi_status)['name'] }}</span>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>