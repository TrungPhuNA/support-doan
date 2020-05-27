@extends('layouts.app_master_user')
@section('css')
    <style>
		<?php $style = file_get_contents('css/user.min.css');echo $style;?>
    </style>
@stop
@section('content')
    <section>
        <div class="title">Trang tổng quan cá nhân</div>
        <div class="row">
            <div class="col-6">
                <div class="box-count" style="background: #00c0ef">
                    <div class="count-text">{{ $totalTransactionSuccess }}</div>
                    <p class="count-name">Tổng số tài liệu đã </p>
                </div>
            </div>
        </div>
        <div class="title" style="margin-top: 5px">Link giới thiệu của bạn</div>
        <div class="row">
            <p style="background-color: #f2f2f2;display: flex;width: 100%">
                <input id="myInput" type="text" style="width: 100%;background: #f2f2f2;outline: none;border: none;max-width: 100%;" value="{{ route('get.register',['ref_id' => get_data_user('web')]) }}">
                <a href="" class="btn btn-xs btn-success" style="padding: 10px 15px;font-size: 15px;" onclick="myFunctionCopy()">
                    <i class="fa fa-clipboard"></i> Sao chép </a>
            </p>
        </div>

    </section>
    <script>
        function myFunctionCopy() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Bạn đã copy link thành công: " + copyText.value);
        }
    </script>
@stop
