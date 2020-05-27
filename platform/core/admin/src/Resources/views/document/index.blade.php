@extends('layouts.app_master_admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Quản lý tài liệu</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{  route('admin.document.index') }}"> Document</a></li>
            <li class="active"> List</li>
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
                        <select name="status" class="form-control" >
                            <option value="">Trạng thái</option>
                            <option value="1" {{ Request::get('status') == 1 ? "selected='selected'" : "" }}>Active</option>
                            <option value="2" {{ Request::get('status') == 2 ? "selected='selected'" : "" }}>Warning</option>
                        </select>
                        <select name="category" class="form-control" >
                            <option value="">Danh mục</option>
                            @foreach($categories as $item)
                                <option value="{{ $item->id }}" {{ Request::get('category') == $item->id ? "selected='selected'" : "" }}>
                                    <?php $str = '' ;for($i = 0; $i < $item->level; $i ++){ echo $str; $str .= '-- '; }?>
                                    {{  $item->c_name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>

                        <a href="{{ route('admin.document.convert_all') }}" class="btn btn-info">Convet All <i class="fa fa-refresh"></i></a>
                        <a href="{{ route('admin.document.create') }}" class="btn btn-primary">Thêm mới <i class="fa fa-plus"></i></a>
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <div class="pull-left">
                        Hiển thị: {{ $documents->firstItem() }} to {{ $documents->lastItem() }} / Tổng {{ $documents->total() }} record
                    </div>
                    <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 15%">Name</th>
                                    <th style="width: 10%">Category</th>
                                    <th>Price</th>
                                    <th>Hot</th>
                                    <th>Status</th>
                                    <th>Info</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>

                            </tbody>
                            @if (isset($documents))
                                    @foreach($documents as $document)
                                        <tr>
                                            <td>{{ $document->id }}</td>
                                            <td style="width: 30%">
                                                <a target="_blank"
                                                   href="{{ route('get.document.detail', $document->dcm_slug.'-'. $document->id) }}">{{ $document->dcm_name }}</a>

                                            </td>
                                            <td>
                                                <span>{{ $document->category->c_name ?? "[N\A]" }}</span>
                                            </td>
{{--                                            <td>--}}
{{--                                                <img src="{{ pare_url_file($document->dcm_avatar) }}" style="width: 80px;height: 100px">--}}
{{--                                            </td>--}}
                                            <td>
                                                {{ number_format($document->dcm_price,0,',','.') }} vnđ
                                            </td>
                                            <td>
                                                @if ($document->dcm_hot == 1)
                                                    <a href="{{ route('admin.document.hot', $document->id) }}" class="label label-info">Hot</a>
                                                @else
                                                    <a href="{{ route('admin.document.hot', $document->id) }}" class="label label-default">None</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($document->dcm_active == 1)
                                                    <a href="{{ route('admin.document.active', $document->id) }}" class="label label-info">Active</a>
                                                @else
                                                    <a href="{{ route('admin.document.active', $document->id) }}" class="label label-default">Hide</a>
                                                @endif
                                            </td>
                                            <td>
                                                <ul style="padding-left: 0">
                                                    <li>File : <b>{{ $document->dcm_ext }}</b></li>
                                                    <li>Size : <b>{{ $document->dcm_size }} KB</b> </li>
                                                    <li>Page : <b>{{ $document->dcm_number }}</b></li>
                                                    @if ($document->dcm_file)
                                                    <li>File : <a href="{{ pare_url_file($document->dcm_file) }}" target="_blank">Click</a></li>
                                                    @endif
                                                    @if ($document->dcm_link_preview)
                                                        <li>File Preview: <a href="{{pare_url_preview($document->dcm_link_preview) }}" target="_blank">Click</a></li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td>{{  $document->created_at }}</td>
                                            <td>
                                                <a href="{{ route('admin.document.update', $document->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a><br>
                                                @if ($document->dcm_status != 1)
                                                <a href="{{ route('admin.document.restart_convert', $document->id) }}" style="margin-top: 10px;"
                                                   class="btn btn-xs btn-info">
                                                    <i class="fa fa-refresh"></i> Convert</a>
                                                @endif
                                                <br><a style="margin-top: 10px;" class="btn btn-xs btn-primary" href="{{ route('admin.document.convert_images', $document->id) }}">Create Thumbnal</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                        </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! $documents->appends($query)->links() !!}
                     <div class="pull-left">
                         Hiển thị: {{ $documents->firstItem() }} to {{ $documents->lastItem() }} / Tổng {{ $documents->total() }} record
                     </div>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
    </section>
    <!-- /.content -->
@stop