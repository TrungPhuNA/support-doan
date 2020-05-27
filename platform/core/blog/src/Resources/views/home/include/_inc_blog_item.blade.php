<div class="blog-item">
	<div class="avatar">
		<a href="{{ route('get.render_url_seo_blog',$article->a_slug.'-'.'a-'.$article->id) }}" title="{{  $article->a_name }}" class="image cover">
			<img class="lazyload lazy" alt="" src="{{  asset('images/preloader.gif') }}"  data-src="{{ pare_url_file($article->a_avatar) }}">
		</a>
	</div>
	<div class="info">
		<a href="{{ route('get.render_url_seo_blog',$article->a_slug.'-'.'a-'.$article->id) }}" title="{{  $article->a_name }}"
		>{{ $article->a_name }}</a>
		<p>{{  $article->a_description }}</p>
		<div class="auth flex align-center">
			@if (isset($article->admin->name))
				<a href="">
					<img src="{{ pare_url_file($article->admin->avatar) }}" alt="{{ $article->admin->name }}">
				</a>
				<span>{{ $article->admin->name }}</span>
			@endif
			<span>{{ $article->created_at }}</span>
		</div>
	</div>
</div>