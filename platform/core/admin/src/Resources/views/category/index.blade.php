@extends('layouts.app_master_admin')
@section('content')
    <style>
        .level-2 span{
            color: #E91E63;
        }
        .level-3 span{
            color: #666;
        }
        .level-3 span{
            color: #673AB7;
        }
    </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Quản lý danh mục sản phẩm</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{  route('admin.category.index') }}"> Category</a></li>
            <li class="active"> List </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{ route('admin.category.create') }}" class="btn btn-primary">Thêm mới <i class="fa fa-plus"></i></a></h3>
               </div>
                <div class="box-body">
                    {!! show_category_admin($categories) !!}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </section>
    <!-- /.content -->
@stop

<script src="{{  asset('admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(function () {
        $(".js-toggle-menu").click(function (event) {
            event.preventDefault();
            $(this).parent().next(".submenu").fadeToggle();

            let $children = $(this).find(".js-children");

            if ($children.length)
            {
                if ($children.hasClass('fa-angle-right'))
                {
                    $children.removeClass('fa-angle-right').addClass('fa-angle-down')
                }else {
                    $children.addClass('fa-angle-right').removeClass('fa-angle-down')
                }
            }
        })
    })
</script>
