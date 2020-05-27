@extends('layouts.app_master_user')
@section('css')
    <style>
		<?php $style = file_get_contents('css/user.min.css');echo $style;?>
    </style>
@stop
@section('content')
    <section>
        <div class="title">Danh sách đơn hàng</div>
        <form class="form-inline">
            <div class="form-group " style="margin-right: 10px;">
                <input type="text" class="form-control" value="{{ Request::get('id') }}" name="id" placeholder="ID">
            </div>
{{--            <div class="form-group" style="margin-right: 10px;">--}}
{{--                <select name="status" class="form-control">--}}
{{--                    <option value="">Trạng thái</option>--}}
{{--                    <option value="1" {{ Request::get('status') == 1 ? "selected='selected'" : "" }}>Tiếp nhận</option>--}}
{{--                    <option value="2" {{ Request::get('status') == 2 ? "selected='selected'" : "" }}>Đang vận chuyển--}}
{{--                    </option>--}}
{{--                    <option value="3" {{ Request::get('status') == 3 ? "selected='selected'" : "" }}>Đã bàn giao--}}
{{--                    </option>--}}
{{--                    <option value="-1" {{ Request::get('status') == -1 ? "selected='selected'" : "" }}>Huỷ bỏ</option>--}}
{{--                </select>--}}
{{--            </div>--}}
            <div class="form-group" style="margin-right: 10px;">
                <button type="submit" class="btn btn-pink btn-sm">Tìm kiếm</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Mã đơn</th>
                        <th scope="col" style="width: 30%">Name</th>
                        <th scope="col">Money</th>
                        <th scope="col">Type</th>
                        <th scope="col">Time</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)
                    @php
                        if ($transaction->tst_document_id) {
                            $link = route('get.document.preview_download_document', [
                                    '_token' => $transaction->_token
                                ]);
                        }else {
	                        $link = route('get.view.download_combo', [
						'_token' => $transaction->_token]);
                        }

                    @endphp
                    <tr>
                        <td scope="row" class="text-center">
                            <a href="{{ $link }}">DH{{ $transaction->id }}</a>
                        </td>
                        <td class="text-center">
                            @if ($transaction->tst_document_id)

                                <a target="_blank"
                                        href="{{ $link }}">
                                    {{ $transaction->document->dcm_name }}
                                </a>
                            @else
                                <a target="_blank"
                                        href="{{ $link }}">
                                    {{ $transaction->combo->cd_name }}
                                </a>
                            @endif
                        </td>
                        <td class="text-center">{{ number_format($transaction->tst_total_money,0,',','.') }} đ</td>
                        <td class="text-center">
                            @if ($transaction->tst_document_id)
                                <span class="label-success label">Document</span>
                            @else
                                <span class="label label-light">Combo</span>
                            @endif
                        </td>
                        <td class="text-center">{{  $transaction->created_at }}</td>
                        <td class="text-center">
                            <span><i class="fa fa-circle"></i> Thành công</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($transactions->nextPageUrl())
            <a class="btn btn-pink btn-radius btn-next-page" href="{{ $transactions->nextPageUrl() }}">Xem thêm <i class="fa fa-long-arrow-right"></i></a>
        @endif
    </section>
@stop
