@extends('layouts.app_master_admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Thêm mới menu</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{  route('admin.menu.index') }}"> Menu</a></li>
            <li class="active"> Create</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form role="form" action="" method="POST">
                         @csrf
        <div class="box">
            <div class="box-header with-border">
                
                <div class="box-body">
                    
                        <div class="col-sm-8">
                            <div class="form-group {{ $errors->first('mn_name') ? 'has-error' : '' }}">
                                <label for="name">Name <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" name="mn_name"  placeholder="Name ...">
                                @if ($errors->first('mn_name'))
                                    <span class="text-danger">{{ $errors->first('mn_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group ">
                                <label for="name">Parent <span class="text-danger">(*)</span></label>
                                <select name="mn_parent_id" id="" class="form-control">
                                    <option value="0">ROOT</option>
                                    @foreach($menus as $item)
                                        <option value="{{ $item->id }}">{{ $item->mn_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    
                    
                </div>
            </div>
            <!-- /.box -->
        </div>
         <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Nội dung</h3>
                </div>
                <div class="box-body">
                    <div class="form-group ">
                        <label for="exampleInputEmail1">Content</label> 
                        <textarea name="mn_content" id="content" class="form-control textarea" cols="5" rows="2" ></textarea>
                        @if ($errors->first('mn_content'))
                            <span class="text-danger">{{ $errors->first('mn_content') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="box-footer text-center">
                <a href="{{ route('admin.menu.index') }}" class="btn btn-danger">
                Quay lại <i class="fa fa-undo"></i></a>
                <button type="submit" class="btn btn-success">Lưu dữ liệu <i class="fa fa-save"></i></button>
            </div>
        </form>  
    </section>
    <!-- /.content -->
@stop
@section('script')
    <script src="{{  asset('admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">

        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
       };

        CKEDITOR.replace( 'content' ,options);
    </script>
@stop
