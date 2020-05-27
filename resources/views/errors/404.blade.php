@extends('layouts.app_master_frontend')
@section('css')
	<link rel="stylesheet" href="{{ asset('css/static.min.css') }}">
@stop
@section('content')
	<div class="container">
		<div class="breadcrumb">
			<ul>
				<li >
					<a href="/" title="Home"><span itemprop="title">Trang chủ</span></a>
				</li>

				<li >
					<a href="javascript://" title="404"><span itemprop="title">404</span></a>
				</li>
			</ul>
		</div>
		<div class="blog-main" style="margin-bottom: 20px;">
			<div class="left">
				<div class="post-detail">
					<div class="post-detail__content" style="margin: 10px auto;text-align: center;min-height: 35vh;background-color: white">
						<p style="font-size: 20px;color: #333;margin-bottom: 15px;padding-top: 20px;">Trang bạn tìm không tồn tại</p>
						<a href="/" title="Trang chủ" class="btn btn-primary">Về trang chủ</a>
					</div>

				</div>
			</div>
			<div class="right">

			</div>
		</div>
	</div>
@stop
@section('script')
	<script src="{{ asset('js/blog_detail.js') }}" type="text/javascript"></script>
@stop