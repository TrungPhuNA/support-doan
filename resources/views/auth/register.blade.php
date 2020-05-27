@extends('layouts.app_master_frontend')
@section('css')
    <style>
		<?php $style = file_get_contents('css/auth.min.css');echo $style;?>
    </style>
@stop
@section('content')
    <div class="container">
        <div class="breadcrumb">
            <ul>
                <li>
                    <a itemprop="url" href="/" title="Home"><span itemprop="title">Trang chủ</span></a>
                </li>
                <li>
                    <a itemprop="url" href="#" title="Đồng hồ chính hãng"><span itemprop="title">Account</span></a>
                </li>

                <li>
                    <a itemprop="url" href="#" title="Đăng ký"><span itemprop="title">Đăng ký</span></a>
                </li>

            </ul>
        </div>
        <div class="auth">
            <form class="auth-from" action="" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Name <span class="cRed">(*)</span></label>
                    <input name="name" id="name" type="text" value="{{  old('name') }}" class="form-control" placeholder="Nguyen Van A">
                    @if ($errors->first('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="name">Email <span class="cRed">(*)</span></label>
                    <input name="email" id="name" type="email" value="{{  old('email') }}" class="form-control" placeholder="nguyenvana@gmail.com">
                    @if ($errors->first('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="phone">Password <span class="cRed">(*)</span></label>
                    <input name="password" id="phone" type="password" placeholder="********" class="form-control">
                    @if ($errors->first('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="phone">Điện thoại <span class="cRed">(*)</span></label>
                    <input name="phone" id="phone" type="number" value="{{  old('phone') }}" placeholder="123456789" class="form-control">
                    @if ($errors->first('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-purple">Đăng ký</button>
                    <p>
                        <a href="{{ route('get.email_reset_password') }}" title="Quên mật khẩu" ref="nofollow">Quên mật khẩu</a>
                        <a href="{{ route('get.login') }}" title="Đăng nhập" ref="nofollow">Đăng nhập</a>
                    </p>
                    @include('auth.include.social')
                </div>
                <input type="hidden" id="ref" name="ref_id" value="">
                <input type="hidden" id="utm_source" name="utm_source" value="">
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        <?php $js = file_get_contents('js/auth.js');echo $js;?>
    </script>
@stop