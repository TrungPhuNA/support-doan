<div id="footer">
    <div class="container footer">
        <div class="footer__left">
            <div class="top">
                <div class="item item-nav">
                    <div class="title">Tài khoản</div>
                    <ul>
                        <li>
                            <a href="{{ route('get.register') }}" rel="nofollow">Đăng ký</a>
                        </li>
                        <li>
                            <a href="{{ route('get.login') }}" rel="nofollow">Đăng nhập</a>
                        </li>
                        <li>
                            <a href="/" title="Trang chủ">Trang chủ</a>
                        </li>
                    </ul>
                </div>
                <div class="item info-company">
                    <div class="title">Thông tin công ty</div>
                    <p> CÔNG TY CỔ PHẦN CÔNG NGHỆ GIÁO DỤC D3 ONLINE</p>
                    <p> Trụ sở  Tầng 8 - Tòa nhà Ladeco - 266 Đội Cấn - Phường Liễu Giai - Quận Ba Đình - TP Hà Nội</p>
                    <p> Chi nhánh  Lầu 5 - Tòa nhà Lữ Gia - Số 70 Lữ Gia - Phường 15 - Quận 11 - TP Hồ Chí Minh</p>
                    <p> Hotline hỗ trợ khách hàng: <a href="tel:0969477391">0969477391</a></p>
                    <p>(Thời gian hỗ trợ từ 7h đến 22h)</p>
                    <p> Email: <a href="" ref="nofollow" title="admin@tailieu247.net">admin@tailieu247.net</a></p>
                </div>
            </div>
            <div class="bot">
                <div class="social">
                    <div class="title">KẾT NỐI VỚI CHÚNG TÔI</div>
                    <p>
                        <a href="https://www.youtube.com/channel/UCTotni7gvDUSxR3UMzpdNew" target="_blank" ref="nofollow" class="fa fa fa-youtube"></a>
                        <a href="https://www.facebook.com/dethithuthpt2020/" target="_blank" ref="nofollow" class="fa fa-facebook-official"></a>
                    </p>
                </div>
            </div>
        </div>

        <div class="footer__right">
            <div class="title">Fanpage của chúng tôi</div>
            <div class="image">
                <div class="fb-page" id="page-facebook" data-href="https://www.facebook.com/tailieu247net/" data-tabs="" data-width="" data-height="200px" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/dethithuthpt2020/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/dethithuthpt2020/">Đề Thi Thử THPT Quốc Gia 2020</a></blockquote></div>
            </div>
        </div>
    </div>

    <a href="https://www.messenger.com/t/tailieu247net" ref="nofollow" target="_blank" style="position: fixed;
    bottom: 0;
    right: 55px;">
        <img  src="{{ asset('/icon/icons8-facebook-messenger.svg') }}">
    </a>
</div>
@if (app()->environment() !== 'local')
<div id="fb-root"></div>
<script>
    function loadAPI() {
        var js = document.createElement('script');
        js.src = '//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=3205159929509308&version=v6.0';
        document.body.appendChild(js);
    }

    window.onscroll = function () {
        var rect = document.getElementById('page-facebook').getBoundingClientRect();
        if (rect.top < window.innerHeight) {
            loadAPI();
            window.onscroll = null;
        }
    }
</script>
@endif
