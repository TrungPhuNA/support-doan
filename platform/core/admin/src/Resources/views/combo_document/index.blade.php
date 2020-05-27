@extends('layouts.app_master_admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Quản lý combo tài liệu</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{  route('admin.combo_document.index') }}"> Combo</a></li>
            <li class="active"> List</li>
        </ol>
    </section>
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <div class="box-title">
                    <form class="form-inline">
                        <input type="text" class="form-control" value="{{ Request::get('id') }}" name="id" placeholder="ID">
                        <input type="text" class="form-control" value="{{ Request::get('name') }}" name="name" placeholder="Name ...">
                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                        <a href="{{ route('admin.combo_document.create') }}" class="btn btn-primary">Thêm mới <i class="fa fa-plus"></i></a>
                    </form>
                </div>

                <div class="box-body table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Avatar </th>
                                <th style="width: 100px;">Price</th>
                                <th style="width: 40%">Document</th>
                                <th> Hot </th>
                                <th style="width: 150px">File</th>
                                <th>Action</th>
                            </tr>
                            @if (isset($comboDocuments))
                                @foreach($comboDocuments as $combo)
{{--                                    {{ dd($combo) }}--}}
                                    <tr>
                                        <td>{{ $combo->id }}</td>
                                        <td>
                                            <a target="_blank"
                                                href="{{ route('get.combo_document.detail',$combo->cd_slug.'-'.$combo->id) }}">{{ $combo->cd_name }}</a>
                                        </td>
                                        <td>
                                            <img src="{{ pare_url_file($combo->cd_avatar) }}" style="width: 80px;height: 80px">
                                        </td>
                                        <td>{{ number_format($combo->cd_price,0,',','.') }} VNĐ</td>
                                        <td>
                                            @if ($combo->documents)
                                                <ul>
                                                @foreach($combo->documents as $document)
                                                    <li><a href="" style="text-transform: lowercase;">{{ $document->dcm_name }}</a></li>
                                                @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.combo_document.hot', $combo->id) }}"
                                               class="label label-{{ $combo->getHot($combo->cd_hot)['class'] }}">
                                                {{ $combo->getHot($combo->cd_hot)['name'] }}</a>
                                        </td>
                                        <td>
                                            @if ($combo->cd_file)
                                            <a href="{{ pare_url_file($combo->cd_file) }}" download="">Click download</a>
                                            @else
                                                <span>Chưa cập nhật</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.combo_document.update', $combo->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a><br>
                                            <a href="{{ route('admin.combo_document.delete', $combo->id) }}" style="margin-top: 5px;"
                                               class="btn btn-xs js-delete-confirm"><i class="fa fa-trash-o"></i> Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! $comboDocuments->appends($query)->links() !!}
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
    </section>
    <!-- /.content -->
@stop