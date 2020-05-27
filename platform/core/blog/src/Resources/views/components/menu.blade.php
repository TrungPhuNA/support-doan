@if (isset($menus))
	<div class="top-question">
		<div class="title">Chuyên mục</div>
		<ul>
			@foreach($menus as $key => $item)
				<li>
					<a href="{{ route('get.render_url_seo_blog',$item->mn_slug.'-'.'m-'.$item->id) }}"
					   title="{{ $item->mn_name }}">
						<i class="fa fa-angle-right"></i> {{ $item->mn_name }}</a>
				</li>
			@endforeach
		</ul>
	</div>
@endif