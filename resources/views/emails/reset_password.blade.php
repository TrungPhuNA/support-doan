@extends('layouts.app_master_email')
@section('content')
    <p>Bạn có một yêu cầu thay đổi mật khẩu <a href="{{ $link }}" >click vào đây</a> để truy cập đường dẫn thay đổi mật khẩu.</p>
    <p><i>Chú ý</i> :  Đường dẫn sẽ bị xoá sau 5 phút</p>
@stop