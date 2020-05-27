@extends('layouts.app_master_admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Admin</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Account</a></li>
            <li><a href="#">Admin</a></li>
            <li class="active">Create</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <!-- /.box-header -->
                    <form class="form-horizontal" method="POST" action="">
                        @csrf
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <div class="box-body">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" autocomplete="off"
                                                   placeholder="Super Admin">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="email" autocomplete="off"
                                                   placeholder="email.admin@gmail.com">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Phone</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" name="phone"
                                                   placeholder="0986420994" autocomplete="off">
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="box-body">
                                    @if (isset($roles))
                                        @foreach($roles as $role)
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label class="">
                                                        <div class="icheckbox_flat-green" aria-checked="false" aria-disabled="false">
                                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="flat-red" style="position: absolute; opacity: 0;">
                                                            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                        </div>
                                                        <span>{{ $role->name }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                        <!-- form start -->


                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="{{ route('admin.admin.list') }}" class="btn btn-default"><i
                                        class="fa fa-arrow-left"></i> Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Thêm mới</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection
