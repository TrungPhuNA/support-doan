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
                <li itemscope="" >
                    <a itemprop="url" href="/" title="Home"><span itemprop="title">Trang chủ</span></a>
                </li>
                <li itemscope="" >
                    <a itemprop="url" href="#" title="Đồng hồ chính hãng"><span itemprop="title">Account</span></a>
                </li>

                <li itemscope="">
                    <a itemprop="url" href="#" title="Đồng hồ Diamond D"><span itemprop="title">Đăng nhập</span></a>
                </li>

            </ul>
        </div>
        <div class="auth" >
            <form class="auth-from" action="" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Email <span class="cRed">(*)</span></label>
                    <input name="email" id="name" type="email" class="form-control" placeholder="nguyenvana@gmail.com">
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
                    <button class="btn btn-purple">Đăng nhập</button>
                    <p>
                        <a href="{{ route('get.email_reset_password') }}" title="Quên mật khẩu" ref="nofollow">Quên mật khẩu</a>
                        <a href="{{ route('get.register') }}" ref="nofollow" title="Đăng ký">Đăng ký</a>
                    </p>
                    @include('auth.include.social')
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        <?php $js = file_get_contents('js/document.js');echo $js;?>
    </script>
@stop
