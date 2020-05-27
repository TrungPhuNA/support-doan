<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    {!! isset($metaSeo) ? $metaSeo->renderMetaSeo() : '' !!}
    @yield('css')

    {{-- Thông báo --}}
    @if(session('toastr'))
        <script>
			var TYPE_MESSAGE = "{{session('toastr.type')}}";
			var MESSAGE = "{{session('toastr.message')}}";
        </script>
    @endif
    @include('components.load_library.onesignal')
</head>
<body>
@include('components.header')
<div class="container-fluid user">
    <div class="left">
        <div class="header">
            <img src="{{ pare_url_file(Auth::user()->avatar) }}" alt="">
            <p>
                <span>Tài khoản của</span>
                <span>{{ Auth::user()->name }}</span>
            </p>
        </div>
        <p class="user-info-item"><span>Mã TK</span> <span><b>#{{ Auth::user()->id }}</b></span></p>
        <p class="user-info-item"><span>Số dư TK</span> <span><b>{{ number_format(Auth::user()->balance,0,',','.') }} đ</b></span></p>
        <div class="content">
            <ul class="left-nav">
                @foreach(config('user') as $item)
                    <li>
                        <a href="{{ route($item['route']) }}" class="{{ \Request::route()->getName() == $item['route'] ? 'active' : '' }}">
                            <i class="{{ $item['icon'] }}"></i>
                            <span>{{ $item['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="right">
        @yield('content')
    </div>
    <div class="" style="clear: both"></div>
</div>
@include('components.footer')
@if (get_data_user('web') && (!get_data_user('web','phone') || !get_data_user('web','email')))
    @include('components.popup._inc_popup_alter_update_info')
@endif
@include('components.popup._inc_popup_wallet')
<script>
	var DEVICE = '{{  device_agent() }}'
</script>
<script src="{{ asset('js/user.js') }}" type="text/javascript"></script>

@yield('script')
</body>
</html>
