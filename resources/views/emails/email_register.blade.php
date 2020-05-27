@extends('layouts.app_master_email')
@section('content')
    <p>Xin Chào {{ $name }}</p>
    <p>Chúng tôi xin chân thành cảm ơn Bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi.</p>
    <p>Mời bạn <a href="{{ $link }}">click vào đây</a> để xác nhận tài khoản</p>
@stop