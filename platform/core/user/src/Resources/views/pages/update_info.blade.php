@extends('layouts.app_master_user')
@section('css')
    <style>
		<?php $style = file_get_contents('css/user.min.css');echo $style;?>
    </style>
@stop
@section('content')
    <section>
        <div class="title">Cập nhật thông tin</div>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" placeholder="">
                @if ($errors->first('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" placeholder="Enter email">
                @if ($errors->first('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="">Phone</label>
                <input type="number" name="phone" class="form-control" value="{{ Auth::user()->phone }}" placeholder="Enter email">
                @if ($errors->first('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="">Address</label>
                <input type="text" name="address" class="form-control" value="{{ Auth::user()->address }}" placeholder="Địa chỉ">
                @if ($errors->first('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
            </div>
            <div class="from-group" style="display: flex;align-items: center">
                <div class="upload-btn-wrapper">
                    <button class="btn-upload">Chọn avatar</button>
                    <input type="file" name="avatar" id="imgInp" />
                </div>
                <div class="image" style="width: 80px;height: 80px;margin-left: 10px;">
                    <img src="{{ pare_url_file(get_data_user('web','avatar')) }}"  id="blah"
                         onerror="this.onerror=null;this.src='{{ asset('images/default/user-default.png') }}'"
                         style="width: 80px;height: 80px;border-radius: 50%;border: 1px solid #f2f2f2" alt="">
                </div>
            </div>

            <button type="submit" class="btn btn-blue btn-md">Submit</button>
        </form>
    </section>
@stop
