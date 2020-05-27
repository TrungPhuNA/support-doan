@extends('layouts.app_master_admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Quản lý đơn hàng</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{  route('admin.transaction.index') }}"> Transaction</a></li>
            <li class="active"> List </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <div class="box-title">
                    <form class="form-inline">
                        <input type="text" class="form-control" value="{{ Request::get('id') }}" name="id" placeholder="ID">
                        <input type="text" class="form-control" value="{{ Request::get('email') }}" name="email" placeholder="Email ...">
{{--                        <select name="type" class="form-control">--}}
{{--                            <option value="0">Phân loại khách</option>--}}
{{--                            <option value="1" {{ Request::get('type') == 1 ? "selected='selected'" : "" }}>Thành viên</option>--}}
{{--                            <option value="2" {{ Request::get('type') == 2 ? "selected='selected'" : "" }}>Khách</option>--}}
{{--                        </select>--}}
{{--                        <select name="status" class="form-control">--}}
{{--                            <option value="">Trạng thái</option>--}}
{{--                            <option value="1" {{ Request::get('status') == 1 ? "selected='selected'" : "" }}>Tiếp nhận</option>--}}
{{--                            <option value="2" {{ Request::get('status') == 2 ? "selected='selected'" : "" }}>Đang vận chuyển</option>--}}
{{--                            <option value="3" {{ Request::get('status') == 3 ? "selected='selected'" : "" }}>Đã bàn giao</option>--}}
{{--                            <option value="-1" {{ Request::get('status') == -1 ? "selected='selected'" : "" }}>Huỷ bỏ</option>--}}
{{--                        </select>--}}
{{--                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>--}}
{{--                        <button type="submit" name="export" value="true" class="btn btn-info">--}}
{{--                            <i class="fa fa-save"></i> Export--}}
{{--                        </button>--}}
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 30%">Info</th>
                                    <th>Money</th>
                                    <th>Account</th>
                                    <th > Document / Combo</th>
                                    <th style="width: 150px;">Time</th>
                                </tr>
                                @if (isset($transactions))
                                    @foreach($transactions as $transaction)
{{--                                        {{ dd($transaction) }}--}}
                                        <tr>
                                            <td>DH{{ $transaction->id }}</td>
                                            <td>
                                                <ul>
                                                    <li>Name: {{ $transaction->user->name ?? "[N\A]" }}</li>
                                                    <li>Email: {{ $transaction->user->email ?? "[N\A]" }}</li>
                                                    <li>Phone: {{ $transaction->user->phone ?? "[N\A]" }}</li>
                                                </ul>
                                            </td>
                                            <td>{{ number_format($transaction->tst_total_money,0,',','.') }} đ</td>
                                            <td>
                                                @if ($transaction->tst_user_id)
                                                    <span class="label label-success">Thành viên</span>
                                                @else
                                                    <span class="label label-default">Khách</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($transaction->tst_document_id)
                                                    <a href="{{ route('get.document.detail', ($transaction->document->dcm_slug ?? "").'-'. $transaction->tst_document_id) }}"
                                                       target="_blank">{{ $transaction->document->dcm_name ?? "[N\A]" }}</a>
                                                @else
                                                    <a href="{{ route('get.combo_document.detail', ($transaction->combo->cd_slug ?? "").'-'.$transaction->tst_combo_id) }}"
                                                       target="_blank">{{ $transaction->combo->cd_name ?? "[N\A]" }}</a>
                                                @endif
                                            </td>
                                            <td>{{  $transaction->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! $transactions->appends($query)->links() !!}
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
    </section>

    <div class="modal fade fade" id="modal-preview-transaction">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"> Chi tiết đơn hàng <b id="idTransaction">#1</b></h4>
                </div>
                <div class="modal-body">
                    <div class="content">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.content -->
@stop
