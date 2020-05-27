@extends('layouts.app_master_admin')
@section('content')
    <style>
        .ratings span {
            color: #f2f2f2;
        }
        .ratings .active {
            color: #f5991c;
        }
        .sk-fading-circle {
            margin: 100px auto;
            width: 40px;
            height: 40px;
            position: relative;
        }

        .sk-fading-circle .sk-circle {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
        }

        .sk-fading-circle .sk-circle:before {
            content: '';
            display: block;
            margin: 0 auto;
            width: 15%;
            height: 15%;
            background-color: #1abc9c;
            border-radius: 100%;
            -webkit-animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
            animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
        }
        .sk-fading-circle .sk-circle2 {
            -webkit-transform: rotate(30deg);
            -ms-transform: rotate(30deg);
            transform: rotate(30deg);
        }
        .sk-fading-circle .sk-circle3 {
            -webkit-transform: rotate(60deg);
            -ms-transform: rotate(60deg);
            transform: rotate(60deg);
        }
        .sk-fading-circle .sk-circle4 {
            -webkit-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            transform: rotate(90deg);
        }
        .sk-fading-circle .sk-circle5 {
            -webkit-transform: rotate(120deg);
            -ms-transform: rotate(120deg);
            transform: rotate(120deg);
        }
        .sk-fading-circle .sk-circle6 {
            -webkit-transform: rotate(150deg);
            -ms-transform: rotate(150deg);
            transform: rotate(150deg);
        }
        .sk-fading-circle .sk-circle7 {
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }
        .sk-fading-circle .sk-circle8 {
            -webkit-transform: rotate(210deg);
            -ms-transform: rotate(210deg);
            transform: rotate(210deg);
        }
        .sk-fading-circle .sk-circle9 {
            -webkit-transform: rotate(240deg);
            -ms-transform: rotate(240deg);
            transform: rotate(240deg);
        }
        .sk-fading-circle .sk-circle10 {
            -webkit-transform: rotate(270deg);
            -ms-transform: rotate(270deg);
            transform: rotate(270deg);
        }
        .sk-fading-circle .sk-circle11 {
            -webkit-transform: rotate(300deg);
            -ms-transform: rotate(300deg);
            transform: rotate(300deg);
        }
        .sk-fading-circle .sk-circle12 {
            -webkit-transform: rotate(330deg);
            -ms-transform: rotate(330deg);
            transform: rotate(330deg);
        }
        .sk-fading-circle .sk-circle2:before {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }
        .sk-fading-circle .sk-circle3:before {
            -webkit-animation-delay: -1s;
            animation-delay: -1s;
        }
        .sk-fading-circle .sk-circle4:before {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }
        .sk-fading-circle .sk-circle5:before {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }
        .sk-fading-circle .sk-circle6:before {
            -webkit-animation-delay: -0.7s;
            animation-delay: -0.7s;
        }
        .sk-fading-circle .sk-circle7:before {
            -webkit-animation-delay: -0.6s;
            animation-delay: -0.6s;
        }
        .sk-fading-circle .sk-circle8:before {
            -webkit-animation-delay: -0.5s;
            animation-delay: -0.5s;
        }
        .sk-fading-circle .sk-circle9:before {
            -webkit-animation-delay: -0.4s;
            animation-delay: -0.4s;
        }
        .sk-fading-circle .sk-circle10:before {
            -webkit-animation-delay: -0.3s;
            animation-delay: -0.3s;
        }
        .sk-fading-circle .sk-circle11:before {
            -webkit-animation-delay: -0.2s;
            animation-delay: -0.2s;
        }
        .sk-fading-circle .sk-circle12:before {
            -webkit-animation-delay: -0.1s;
            animation-delay: -0.1s;
        }

        @-webkit-keyframes sk-circleFadeDelay {
            0%, 39%, 100% { opacity: 0; }
            40% { opacity: 1; }
        }

        @keyframes sk-circleFadeDelay {
            0%, 39%, 100% { opacity: 0; }
            40% { opacity: 1; }
        }
    </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Thống kê dữ liệu hệ thống</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
    </section>
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-file-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Tài liệu</span>
                        <span class="info-box-number">{{  $totalDocuments }} <small><a href="{{  route('admin.document.index') }}">(Chi tiết)</a></small></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-dollar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Doanh Thu</span>
                        <span class="info-box-number">{{ number_format($totalMoneyTransactions,0,',','.') }} VNĐ </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-download"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Lượt tải</span>
                        <span class="info-box-number">{{  $totalDownload }} <small><a href="">(Chi tiết)</a></small></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Thành Viên</span>
                        <span class="info-box-number">{{ $totalUsers }} <small><a href="{{ route('admin.user.index') }}">(Chi tiết)</a></small></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thống kê doanh thu các ngày trong tháng ( Người dùng nạp )</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="body-line-chart" style="min-height: 100px;">
                        @include('admin::statistical.include._inc_lazyload')
                        <canvas id="line-chart" width="400" height="100"></canvas>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thống kê lượt download trong tháng</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="body-line-chart-download" style="min-height: 100px;">
                        @include('admin::statistical.include._inc_lazyload')
                        <canvas id="download-line-chart" width="400" height="100"></canvas>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>


        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thống kê doanh thu các tháng trong năm</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="body-month-line" style="min-height: 100px;">
{{--                        @include('admin::statistical.include._inc_lazyload')--}}
                        <ul class="alias-dashboard">
                            @foreach($statisticalPayIn as $item)
                                <li>
                                    <span>Tháng {{ $item->month }} Năm {{ $item->year }}</span>
                                    <span>{{ number_format($item->money,0,',','.') }} <sup>đ</sup></span>
                                </li>
                            @endforeach
                        </ul>
{{--                        <canvas id="month-line" width="400" height="100"></canvas>--}}
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-6">
            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Đơn nạp tiền mới</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" id="list-pay-in" style="min-height: 100px;">
                    @include('admin::statistical.include._inc_lazyload')
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <!-- Left col -->
        <div class="col-md-6">
            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Top download tài liệu</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" id="top-download" style="min-height: 100px;">
                    @include('admin::statistical.include._inc_lazyload')
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
@stop

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <script>
        var URL_GET_PAY_IN = '{{ route('ajax_admin.get_pay_in') }}'
        var URL_GET_DOWNLOAD_TOP =  '{{ route('ajax_admin.get_top_download') }}'
        var URL_GET_CHAR =  '{{ route('ajax_admin.get_dashboard_char') }}'
        $(function () {
            $(window).on('load', function() {
                if (typeof URL_GET_PAY_IN !== "undefined")
                {
                    $.ajax({
                        url : URL_GET_PAY_IN,
                        method : "GET",
                        async : false,
                        success : function(results)
                        {
                            $("#list-pay-in").html('').html(results.view);
                        }
                    });
                }
                if (typeof URL_GET_DOWNLOAD_TOP !== "undefined")
                {
                    $.ajax({
                        url : URL_GET_DOWNLOAD_TOP,
                        method : "GET",
                        async : false,
                        success : function(results)
                        {
                            $("#top-download").html('').html(results.view);
                        }
                    });
                }
                if (typeof URL_GET_CHAR !== "undefined")
                {
                    $.ajax({
                        url : URL_GET_CHAR,
                        method : "GET",
                        async : false,
                        success : function(results)
                        {
                            $("#body-line-chart .sk-fading-circle").remove();
                            $("#body-line-chart-download .sk-fading-circle").remove();
                            let dataPayIn = results.arrRevenuePayInMonth;
                            dataPayIn  =  JSON.parse(dataPayIn);

                            let listday = results.listDay;
                            listday = JSON.parse(listday);

                            Chart.defaults.global.defaultFontColor = '#000000';
                            Chart.defaults.global.defaultFontFamily = 'Arial';
                            Chart.defaults.global.responsive = true;

                            var lineChart = document.getElementById('line-chart');
                            var myChart = new Chart(lineChart, {
                                type: 'line',
                                height: 300,
                                data: {
                                    labels: listday,
                                    datasets: [
                                        {
                                            label: 'Doanh thu các ngày trong tháng',
                                            data: dataPayIn,
                                            backgroundColor: 'rgba(0, 128, 128, 0.3)',
                                            borderColor: 'rgba(0, 128, 128, 0.7)',
                                            borderWidth: 1
                                        },
                                    ]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true
                                            }
                                        }]
                                    },
                                }
                            });

                            let dataTransactions = results.arrRevenueTransactionMonth;
                            listTransaction = JSON.parse(dataTransactions);
                            console.log(listTransaction);

                            var lineChartDownload = document.getElementById('download-line-chart');
                            var myChartDownload = new Chart(lineChartDownload, {
                                type: 'line',
                                height: 300,
                                data: {
                                    labels: listday,
                                    datasets: [
                                        {
                                            label: 'Lượt download các ngày trong tháng',
                                            data: listTransaction,
                                            backgroundColor: 'rgba(0, 128, 128, 0.3)',
                                            borderColor: 'rgba(0, 128, 128, 0.7)',
                                            borderWidth: 1
                                        },
                                    ]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true
                                            }
                                        }]
                                    },
                                }
                            });
                        }
                    });
                }
            });
        })
    </script>
@stop
