@extends('layouts.app_master_frontend')
@section('css')
	<style>
		<?php $style = file_get_contents('css/blog_insights.min.css');echo $style;?>
	</style>
@stop
@section('content')
	<div class="container">
		<div class="breadcrumb">
			<ul itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="{{ route('get.blog.home') }}" title="Tin tức">
						<span itemprop="name">Tin tức</span>
						<meta itemprop="position" content="1">
					</a>
				</li>
				@if (isset($menu))
					<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
						<span itemprop="name">{{ $menu->mn_name }}</span>
						<meta itemprop="position" content="2">
					</li>
				@endif
				@if (isset($tag))
					<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
						<span itemprop="name">{{ $tag->t_name }}</span>
						<meta itemprop="position" content="{{ isset($menu) ? 3 : 2 }}">
					</li>
				@endif
			</ul>
		</div>
		<div class="blog-main">
			<div class="left">
				@if (isset($articlesHotTop))
					<div class="post-hot">
						@if ($articleTop = $articlesHotTop->first())
							<div class="hot-left">
								<div class="avatar">
									<a href="{{ route('get.render_url_seo_blog',$articleTop->a_slug.'-'.'a-'.$articleTop->id) }}"
									   title="{{  $articleTop->a_name }}" class="image cover">
										<img class="lazyload" alt="" src="{{ pare_url_file($articleTop->a_avatar) }}">
									</a>
								</div>
								<a href="{{ route('get.render_url_seo_blog',$articleTop->a_slug.'-'.'a-'.$articleTop->id) }}"
								   title="{{  $articleTop->a_name }}" class="title">{{  $articleTop->a_name }}</a>
								<p class="intro-short">{{  $articleTop->a_description }}</p>
							</div>
						@endif
						<div class="hot-right">
							@foreach($articlesHotTop->forget(0) as $i => $item)
								@if ($i == 0)
									<div class="top">
										<div class="avatar">
											<a href="{{ route('get.render_url_seo_blog',$item->a_slug.'-'.'a-'.$item->id) }}"
											   title="{{ $item->a_name }}" class="image cover">
												<img class="lazyload" alt="" src="{{ pare_url_file($item->a_avatar) }}">
											</a>
										</div>
										<a href="{{ route('get.render_url_seo_blog',$item->a_slug.'-'.'a-'.$item->id) }}"
										   title="{{ $item->a_name }}" class="title">{{  $item->a_name }}</a>
									</div>
								@else
									<div class="bot">
										<a href="{{ route('get.render_url_seo_blog',$item->a_slug.'-'.'a-'.$item->id) }}"
										   title="{{ $item->a_name }}" class="">{{ $item->a_name }}</a>
									</div>
								@endif
							@endforeach
						</div>
					</div>
				@endif
				<div class="post-list">
					@foreach($articles as $article)
						@include('blog::home.include._inc_blog_item', ['article' => $article])
					@endforeach
					<div style="display: block;">
						{!! $articles->appends([])->links() !!}
					</div>
				</div>
			</div>
			<div class="right">
				@include('blog::components.menu',['menus' => $menus ?? []])
				@include('blog::components.tag',['tags' => $tags ?? []])
				@include('blog::components.articles_hot_sidebar_top',['articles' => $articlesHotSidebarTop ?? []])
{{--				@include('frontend.components.top_product',['products' => $productTopPay ?? []])--}}
				@include('blog::components.hot_article',['articles'  => $articlesHot ?? []])
			</div>
		</div>
	</div>
@stop
@section('script')
	<script type="text/javascript">
		var CSS = "{{ asset('css/blog.min.css') }}";
		<?php $js = file_get_contents('js/blog.js');echo $js;?>
	</script>
@stop
