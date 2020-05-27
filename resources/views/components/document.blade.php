<div class="list">
	@foreach($documents as $document)
		<div class="item" style="{{ $customer_style ?? "" }}">
			<div class="box">
				<a href="{{ route('get.document.detail', $document->dcm_slug.'-'. $document->id) }}" class="image" title="{{ $document->dcm_name }}">
					<img src="{{ asset(config('img.lazy')) }}" class="lazy"
						 data-src="{{ pare_url_file($document->dcm_avatar,'uploads_preview') }}" alt="{{ $document->dcm_name }}">
				</a>
				<h4>
					<a href="{{ route('get.document.detail', $document->dcm_slug.'-'. $document->id) }}"
					   title="{{ $document->dcm_name }}">{{ mb_strtolower($document->dcm_name) }}</a>
				</h4>
				@if (strpos($document->dcm_ext,'doc') !== false || strpos($document->dcm_ext,'docx') !== false)
					<img class="ext" src="{{ asset('images/icon/word.png') }}" alt="{{ $document->dcm_name }}">
				@elseif (strpos($document->dcm_ext,'pptx') !== false || strpos($document->dcm_ext,'ppt') !== false)
					<img class="ext" src="{{ asset('images/icon/ppf.png') }}" alt="{{ $document->dcm_name }}">
				@else
					<img class="ext" src="{{ asset('images/icon/pdf.png') }}" alt="{{ $document->dcm_name }}">
				@endif
				<div class="flex justify-between align-center">
					@if (isset($document->admin->name))
						<a title="{{ $document->admin->name }}"
						   href="{{ route('get.profile.document',\Str::slug($document->admin->name).'-'.$document->admin->slug) }}"
						   class="auth">{{ $document->admin->name ?? "[N\A]" }}</a>
					@endif
					@if ($document->dcm_price && !get_data_user('web'))
						<a href="" title="{{ $document->dcm_name }}"
						   data-type="1" data-code="{{ $document->id }}"
						   data-price="{{ number_format($document->dcm_price,0,',','.') }}"
						   ref="nofollow" class="quick-purchase js-quick-purchase"><i class="fa fa-shopping-bag"></i> Mua nhanh</a>
					@endif
				</div>
				<p class="footer">
					<a href="javascript:;void(0)" title="Số trang" ref="nofollow"><i class="fa fa-file-text-o"></i> {{ $document->dcm_number }}</a>
					<a href="javascript:;void(0)" title="Lượt xem" ref="nofollow"><i class="fa fa-eye"></i> {{ $document->dcm_view }}</a>
					<a href="javascript:;void(0)" title="Lượt tải" ref="nofollow"><i class="fa fa-download"></i> {{ $document->dcm_download }}</a>
				</p>

			</div>
		</div>
	@endforeach
</div>