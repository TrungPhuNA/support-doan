@extends('layouts.app_master_frontend')
@section('css')
	<style>
		<?php $style = file_get_contents('css/blog_detail_insights.min.css');echo $style;?>
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

				@if( isset($article->menu->mn_name))
					<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
						<a itemprop="name" href="{{ route('get.render_url_seo_blog',$article->menu->mn_slug.'-'.'m-'.$article->a_menu_id) }}"
						   title="{{ $article->menu->mn_name }}">
							<span itemprop="name">{{ $article->menu->mn_name }}</span>
							<meta itemprop="position" content="2">
						</a>
					</li>
				@endif
				<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
					<span itemprop="name">{{ $article->a_name }}</span>
					<meta itemprop="position" content="{{ isset($article->menu->mn_name) ? 3 : 2 }}">
				</li>
			</ul>
		</div>
		<div class="blog-main">
			<div class="left">
				<div class="post-detail">
					<h1 class="post-detail__title">{{ $article->a_name }}</h1>
					<p class="post-detail__auth">
						@if( isset($article->menu->mn_name))
							Chuyên mục <a title="{{ $article->menu->mn_name }}"
								href="{{ route('get.render_url_seo_blog',$article->menu->mn_slug.'-'.'m-'.$article->a_menu_id) }}">{{ $article->menu->mn_name }}</a> -
						@endif

						<span>{{ $article->admin->name ?? "[N\A]" }}</span> - {{ $article->created_at }}</p>
					<p class="post-detail__intro">{{  $article->a_description }}</p>
					<div class="post-detail__content">
						{!! $article->a_content !!}
					</div>
					<div class="post-detail__social">
						<span class="title">Chia sẻ:</span>
							<div class="fb-share-button"
								 data-href="{{ \Request::url() }}"
								 data-layout="button_count">
							</div>
					</div>
					<div class="post-detail__comment">
						<h3>Để lại bình luận của bạn</h3>
						<div class="fb-comments" data-href="{{ \Request::url() }}" data-numposts="5" data-width="100%"></div>
					</div>
					<div class="post-detail_suggest" style="margin: 10px 0">
						<h3 >Bài viết liên quan</h3>
						<ul>
							@foreach($articleSuggest as $key => $item)
								<li><a href="{{ route('get.render_url_seo_blog',$item->a_slug.'-'.'a-'.$item->id) }}" title="{{ $item->a_name }}">
										<span >{{ ($key + 1) }}</span> {{ $item->a_name }}</a>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="right">
				@include('blog::components.menu',['menus' => $menus ?? []])
				@include('blog::components.articles_hot_sidebar_top',['articles' => $articlesHotSidebarTop ?? []])
				@include('blog::components.hot_article',['articles'  => $articlesHot ?? []])
			</div>
		</div>
	</div>
@stop
@section('script')
	<script type="text/javascript">
		var CSS = "{{ asset('css/blog_detail.min.css') }}";
		<?php $js = file_get_contents('js/blog.js');echo $js;?>
	</script>
@stop
