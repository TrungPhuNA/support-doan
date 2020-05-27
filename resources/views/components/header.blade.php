<section class="top-header desktop js-header-top" id="js-header-top">
    <div class="container">
        <div class="content">
            <div class="left">
                <a class="btn btn-recharge {{ \Auth::id() ? 'js-popup-wallet' : 'js-show-login' }}"
                   href="{{ route('get.user.recharge') }}" title="Nạp tiền" rel="nofollow"><i class="fa fa-dollar" style="color: white !important"></i> Nạp tiền</a>
                <a href="{{ route('get.blog.home') }}" title="Tin tức" ref="nofollow" >Tin tức</a>
            </div>
            <div class="right">
                @if (Auth::check())
                    <a href="">Xin chào {{ Auth::user()->name }}</a>
                    <a href="{{  route('get.user.dashboard') }}">Quản lý tài khoản</a>
                @else
                    <a href="{{  route('get.register') }}">Đăng ký</a>
                    <a href="{{  route('get.login') }}">Đăng nhập</a>
                @endif
             </div>
        </div>
    </div>
</section>
<section class="top-header mobile js-header-top" id="js-top-header-mb">
    <div class="container">
        <div class="content">
            <div class="left">
                <a class="btn btn-recharge {{ \Auth::id() ? 'js-popup-wallet' : 'js-show-login' }}"
                   href="{{ route('get.user.recharge') }}" title="Chăm sóc khách hàng" rel="nofollow"><i class="fa fa-dollar" style="color: white !important"></i> Nạp tiền</a>
                <a href="{{ route('get.blog.home') }}" title="Tin tức" >Tin tức</a>
                @if (Auth::check())
                    <a href="">Xin chào {{ Auth::user()->name }}</a>
                    <a href="{{  route('get.user.dashboard') }}">Quản lý tài khoản</a>
                @else
                    <a href="{{  route('get.register') }}">Đăng ký</a>
                    <a href="{{  route('get.login') }}">Đăng nhập</a>
                @endif
            </div>
        </div>
    </div>
</section>

<div class="commonTop" id="js-commonTop">
    <div id="headers">
        <div class="container header-wrapper">
            <!--Thay đổi-->
            <div class="logo">
                <a href="/" class="desktop">
                    <img src="{{ url('images/logo.png') }}" style="height: 35px;" alt="Home">
                </a>
                <span class="menu js-menu-cate desktop"><i class="fa fa-list-ul"></i> </span>
                <span class="menu mobile js-category-mobile"><i class="fa fa-list-ul"></i> </span>
            </div>
            <div class="search">

                <form action="{{ route('get.search.document') }}" role="search" method="GET">
                    <input type="text" name="k" value="{{ Request::get('k') }}" class="form-control js-input-search" placeholder="Tìm kiếm tài liệu, combo tài liệu ...">
                    <button type="submit" class="btnSearch">
                        <i class="fa fa-search"></i>
                        <span>Tìm kiếm</span>
                    </button>
                </form>
            </div>
            <ul class="right">
                <li class="">
                    <a href="#" title="" rel="nofollow" class="info-user js-show-dropdown">
                        <img src="{{ get_data_user('web','avatar') ? pare_url_file(get_data_user('web','avatar')) : '' }}"
                             onerror="this.onerror=null;this.src='{{ asset('images/default/user-default.png') }}'" alt="">
                        <span class="fa fa-angle-down"></span>
                    </a>
                    <ul class="header-menu-user">
                        @if (get_data_user('web'))
                            <li>
                                <a href="#">Mã TV: <b>#{{ get_data_user('web') }}</b></a>
                            </li>
                            <li>
                                <a href="#">Số dư: <b>#{{ number_format(get_data_user('web','balance'),0,',','.') }} VNĐ</b></a>
                            </li>
                        @endif
                        @foreach(config('user') as $item)
                            <li>
                                <a href="{{ route($item['route']) }}"
                                   class="{{ \Request::route()->getName() == $item['route'] ? 'active' : '' }}">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['name'] }}</span>
                                </a>
                            </li>
                        @endforeach
                        <li><a href="{{ route('get.logout') }}" ref="nofollow" title="Đăng xuất">
                                <i class="fa fa-sign-out"></i> Đăng xuất</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div id="menu-main" class="container" style="display: none;">
                {!! show_menu($listCategoriesSort) !!}
                <ul>
                    <li>
                        <a href="{{ route('get.combo_document') }}" title="Combo tài liệu">
                            <span class="fa fa-folder-o"></span>
                            <span>Combo tài liệu</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@if (get_data_user('web','status') && get_data_user('web','status') == 1)
    <p class="class-very-account">Tài khoản chưa xác nhận. Xin vui lòng yêu cầu xác nhận tài khoản <a href="{{ route('get.confirmation.very_account',[
			'slug'   => get_data_user('web','slug'),
		]) }}">tại đây</a></p>
@elseif (get_data_user('web','status') && get_data_user('web','status') == 2)
    <p style="background-color: #d9edf7;
    border-color: #bcdff1;
    color: #31708f;" class="class-very-account">Link xác nhận tài khoản đã được gủi tới email của bạn. Vui lòng check inbox hoạc mục <b>spam</b>
     để xác nhận tài khoản. <br>Nếu quá trình sau 5 - 10p bạn vẫn chưa nhận được link xác nhận xin vui lòng gủi lại yêu cầu xác nhận
        <a href="{{ route('get.confirmation.very_account',[
			'slug'   => get_data_user('web','slug'),
		]) }}">tại dây</a>
    </p>
@endif

<div class="box-overlay"></div>
<div class="box-search-g close-block-menu" id="box-search-g">
    <div class="header">Chọn danh mục <a href="" class="close js-close-submenu"><i class="fa fa-times"></i></a></div>
    {!! show_menu($listCategoriesSort) !!}
    <ul>
        <li>
            <a href="{{ route('get.combo_document') }}" title="Combo tài liệu">
                <span class="fa fa-folder-o"></span>
                <span>Combo tài liệu</span>
            </a>
        </li>
    </ul>
</div>
