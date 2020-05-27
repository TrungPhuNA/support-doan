@extends('layouts.app_master_admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Quản lý nạp tiền</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{  route('admin.system_pay_in.index') }}"> User</a></li>
            <li class="active"> index </li>
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
                        <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name" placeholder="Name ...">
                        <select name="status" class="form-control" id="">
                            <option value="">All</option>
                            @foreach($status as $key => $item)
                                <option value="{{ $key }}" {{ Request::get('status') == $key ? "selected='selected'" : "" }}>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                        <a href="{{ route('admin.system_pay_in.create') }}" class="btn btn-primary">Thêm mới <i class="fa fa-plus"></i></a>
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <table class="table">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>User</th>
                                <th>Provider</th>
                                <th>Money</th>
                                <th>Admin</th>
                                <th>Status</th>
                                <th>Time</th>
                                <th>Process</th>
                                <th>Action</th>
                            </tr>
                            @foreach($payIns as $pay)
                                <tr>
                                    <td>{{ $pay->id }}</td>
                                    <td>
                                        <span>{{ $pay->user->name ?? "[N\A]" }}</span><br>
                                        <span>{{ $pay->user->phone ?? "[N\A]" }}</span><br>
                                        <span>{{ $pay->user->email ?? "[N\A]" }}</span>
                                    </td>
                                    <td>
                                        <span class="label {{ $pay->getProvider($pay->pi_provider)['class'] }}">
                                            {{ $pay->getProvider($pay->pi_provider)['name'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <b>{{ number_format($pay->pi_money,0,',','.') }} <sup>VNĐ</sup></b>
                                    </td>

                                    <td>{{  $pay->admin->name ?? "[N\A]" }}</td>
                                    <td>
                                        <span class="label {{ $pay->getStatus($pay->pi_status)['class'] }}">{{ $pay->getStatus($pay->pi_status)['name'] }}</span>
                                    </td>
                                    <td>{{  $pay->created_at }}</td>
                                    <td>
                                        @if ($pay->pi_status != 3)
                                            @if ($pay->pi_status != 2 && $pay->pi_status != -1)
                                                <a href="{{ route('admin.system_pay_in.process',$pay->id) }}" class="btn btn-xs btn-primary js-process-buy">Duyệt</a>
                                            @endif
                                            @if ($pay->pi_status != -1)
                                                <a href="{{ route('admin.system_pay_in.success',$pay->id) }}" class="btn btn-xs btn-success js-process-buy">Hoàn thành</a>
                                            @endif
                                        @endif

                                        @if ($pay->pi_status == 1)
                                                <a href="{{ route('admin.system_pay_in.cancel',$pay->id) }}" class="btn btn-xs btn-danger js-process-buy">Huỷ</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pay->pi_status != -1)
                                            @if ($pay->pi_provider != 0)
                                            <a href="{{ route('admin.system_pay_in.update', $pay->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                            @endif
                                            @if ($pay->pi_status < 2)
                                                <a href="{{  route('admin.system_pay_in.delete', $pay->id) }}" class="btn btn-xs btn-danger js-delete-confirm"><i class="fa fa-trash"></i> Delete</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! $payIns->links() !!}
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
    </section>
    <!-- /.content -->
@stop
