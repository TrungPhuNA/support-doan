@extends('layouts.app_master_admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Quản lý thành viên</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{  route('admin.user.index') }}"> User</a></li>
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
                    <input type="text" class="form-control" value="{{ Request::get('phone') }}" name="phone" placeholder="phone">
                    <input type="text" class="form-control" value="{{ Request::get('email') }}" name="email" placeholder="Email ...">

                    <button type="submit" name="export" value="true" class="btn btn-info">
                        <i class="fa fa-search"></i> Search
                    </button>
                </form>
            </div>
            <div class="box-body table-responsive">
                <table class="table">
                        <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Redirect</th>
                                <th>Info</th>
                                <th>Type</th>
                                <th style="width: 120px;">Faking Logins</th>
                                <th>Status</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                            @if (isset($users))
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            <ul style="padding-left: 0;list-style: none;">
                                                @if ($user->meta)
                                                    <li>{{ $user->meta }}</li>
                                                @endif
                                                @if(isset($user->presenter->name))
                                                    <li>{{ $user->presenter->name  }} (ID = {{ $user->parent_id }})</li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td>
                                            {{ $user->email }} <br>
                                            {{ $user->phone }}
                                        </td>
                                        <td>
                                            @if (isset($user->social->provider))
                                                <span class="label label-primary">{{ $user->social->provider }}</span>
                                            @else
                                                <span class="label label-info">Default</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.user.faking_login', $user->id) }}" target="_blank"
                                               class="btn btn-xs btn-info">LoginUser</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.user.status', $user->id) }}"
                                               class="label label-{{ $user->getStatus($user->status)['class'] }}">
                                                {{ $user->getStatus($user->status)['name'] }}</a>
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                             <a style="margin-top: 5px" href="{{ route('admin.user.password', $user->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-refresh"></i> Restart password</a>
                                            <br>
                                            <a style="margin-top: 5px" href="{{  route('admin.user.delete', $user->id) }}" class="btn btn-xs btn-danger js-delete-confirm"><i class="fa fa-trash"></i> Delete</a><br>
                                            @if ($user->status != App\User::STATUS_ACTIVE)
                                                <a style="margin-top: 5px" href="{{  route('admin.user.very_account', $user->id) }}" class="btn btn-xs btn-info"><i class="fa fa-plus-circle"></i> Very Account</a><br>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                {!! $users->appends($query)->links() !!}
            </div>
            <!-- /.box-footer-->
        </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@stop