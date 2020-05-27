@if (isset($tags))
	<div class="top-tags">
		<div class="title">Chủ đề hot</div>
		<ul>
			@foreach($tags as $key => $tag)
				<li>
					<a href="{{ route('get.render_url_seo_blog',$tag->t_slug.'-'.'t-'.$tag->id) }}" title="{{ $tag->t_name }}">
						{{ $tag->t_name }}</a>
				</li>
			@endforeach
		</ul>
	</div>
@endif