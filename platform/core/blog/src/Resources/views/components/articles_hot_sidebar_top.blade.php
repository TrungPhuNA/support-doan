@if (isset($articles))
	<div class="top-question">
		<div class="title">Bài viết hot</div>
		<ul>
			@foreach($articles as $key => $item)
				<li>
					<span class="stt">{{ $key + 1 }}</span>
					<a href="{{ route('get.render_url_seo_blog',$item->a_slug.'-'.'a-'.$item->id) }}" title="{{ $item->a_name }}">
						{{ $item->a_name }}</a>
				</li>
			@endforeach
		</ul>
	</div>
@endif