@extends('layouts.app_master_admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Admin</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Account</a></li>
            <li><a href="#">Admin</a></li>
            <li class="active">Index</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="box-title">
                            <form action="" class="form-inline" method="GET">
                                <input type="text" placeholder="ID" name="id" class="form-control">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                                <a href="{{ route('admin.admin.create') }}" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add</a>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Avatar</th>
                                    <th>Phone</th>
                                    <th>Roles</th>
                                    <th>Status</th>
                                    <th>Create</th>
                                    <th>Action</th>
                                </tr>
                                @if (isset($admins))
                                    @foreach($admins as $admin)
                                        <tr>
                                            <td>{{ $admin->id }}</td>
                                            <td>
                                                <span>{{ $admin->name }}</span><br>
                                                <span>{{ $admin->slug }}</span>
                                            </td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->phone }}</td>
                                            <td>
                                                <img src="{{ pare_url_file($admin->avatar) }}" alt="" style="width: 50px;height: 50px;border-radius: 50%">
                                            </td>
                                            <td>
{{--                                                @if(isset($admin->roles()))--}}
                                                <span class="label-info label">{{  $admin->roles()->pluck('name')->implode(' ') ?? "" }}</span>
{{--                                                @endif--}}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.admin.status', $admin->id) }}"
                                                   class="label label-{{ $admin->getStatus($admin->status)['class'] }}">{{ $admin->getStatus($admin->status)['name'] }}</a>
                                            </td>
                                            <td>{{ $admin->created_at }}</td>
                                            <td>
                                                <a href="{{ route('admin.admin.update', $admin->id) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil-square"></i> Edit</a>
                                                <a href="{{ route('admin.admin.delete', $admin->id) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
