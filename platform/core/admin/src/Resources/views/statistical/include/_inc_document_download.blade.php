<div class="table-responsive">
	<table class="table no-margin">
		<thead>
		<tr>
			<th>ID</th>
			<th>Document</th>
			<th>Download</th>
			<th>Rating</th>
		</tr>
		</thead>
		<tbody>
		@if (isset($topDownloadDocument))
			@foreach($topDownloadDocument as $item)
				<tr>
					<td>{{ $item->id }}</td>
					<td>
						<a href="{{ route('get.document.detail', $item->dcm_slug.'-'. $item->id) }}"
						   target="_blank"
						   title="{{ $item->dcm_name }}">{{ $item->dcm_name }}</a>
					</td>
					<td class="text-center">{{ $item->dcm_download }}</td>
					<td class="text-center">
						<p class="ratings" style="width: 100px">
							@for ($i = 1; $i <= 5; $i ++)
								<span class="fa fa-star {{ $i <= $item->dcm_age_review ? 'active' : '' }}"></span>
							@endfor
						</p>
					</td>
				</tr>
			@endforeach
		@endif
		</tbody>
	</table>
</div>