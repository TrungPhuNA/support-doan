import './../components/open_sidebar';
import LazyLoad from './../library/lazyload.min.js';
import Notification from './notification';
import QuickPurchase  from './../components/quick_purchase'
import UpdateInfoUser from "../components/update_info_user";
import toast  from 'toastr';
import HelperParam from "../components/helper_param";
import Wallet from "../components/wallet";
import Search from "../components/search";
var RunCommon = {
    init()
    {
        Wallet.init();
        Notification.init();
        QuickPurchase.init();
        UpdateInfoUser.init();
        HelperParam.init();
        Search.init();
        this.lazyLoadImage();
        this.runToken();
        this.runMessages();
        this.messagesLogin();
        this.showCategory();
        this.fixTopMenu();
        this.showDropdownUser();
        this.addMoney();
        this.runPopupBlockUser();
        this.loadPopupUpdateInfo();

        var window_size = $(window).width();

        $(window).resize(function() {
            window_size = $(window).width();
        });

        if (window_size <= 700)
        {
            this.showCategoryV2();
            this.closeSubMenu();
            this.showSubMenu();
        }
    },
    loadPopupUpdateInfo()
    {
        try{
            $("#popup-update-info").modal({
                escapeClose: false,
                clickClose: false,
                showClose: false
            });
        }catch (e) {
            console.log('-- cannot modal popup-update-info')
        }
    },

    runPopupBlockUser()
    {
        try{
            $("#popup-block_block").modal({
                escapeClose: false,
                clickClose: false,
                showClose: false
            });
        }catch (e) {
            console.log('-- cannot modal ')
        }
    },

    showDropdownUser()
    {
        $(".js-show-dropdown").click(function (event) {
            event.preventDefault();
            $(".header-menu-user").slideToggle();
        })
    },

    addMoney()
    {
        $(".js-add-money").click(function (event) {
            event.preventDefault();
            let money = $(this).text();
            $("#money").val(money)
        })
    },

    runToken()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    },

    runMessages()
    {
        if (typeof TYPE_MESSAGE != "undefined")
        {
            switch (TYPE_MESSAGE) {
                case 'success':
                    toast.success(MESSAGE)
                    break;
                case 'error':
                    toast.error(MESSAGE)
                    break;
            }
        }
    },

    lazyLoadImage()
    {
        (function () {

            function logElementEvent(eventName, element) {

                Date.now(), eventName, element.getAttribute("data-src")
            }

            let ll = new LazyLoad({
                elements_selector: '.lazy',
                load_delay: 500,
                threshold: 0,
                callback_enter: function (element) {

                    logElementEvent("ENTERED", element);
                },
                callback_load: function (element) {
                    logElementEvent("LOADED", element);
                },
                callback_set: function (element) {
                    logElementEvent("SET", element);
                },
                callback_error: function (element) {
                    logElementEvent("ERROR", element);
                    // element.src = "";
                }
            });

            $(".card-img-top").show();
        }());
    },

    messagesLogin()
    {
        $("body").on("click",".js-show-login", function (event) {
            event.preventDefault();
            toast.warning("Bạn phải đăng nhập để thực hiện tính năng này");
            return false;
        })

        $(".js-maintain").click(function (event) {
            event.preventDefault();
            toast.warning("Tính năng này đang phát triển. Mời bạn quay lại sau");
            return false;
        })
    },

    showCategoryV2()
    {
        $(".js-category-mobile").click(function (event) {
            event.preventDefault();
            let $boxFilter = $("#box-search-g");
            $boxFilter.fadeToggle();
            $(".box-overlay").addClass('active')
        })
    },

    showSubMenu()
    {
        $(".js-show-submenu").click(function (event) {
            event.preventDefault();
            let $subMenu = $(this).next();
            if ($subMenu.length)
            {
                $subMenu.show();
                $(".box-overlay").addClass('active')
            }
        })
    },

    closeSubMenu()
    {
        $(".js-close-submenu").click(function (event) {
            event.preventDefault();

            $(this).closest('ul').fadeOut();
            let $subMenu = $(this).closest('.close-block-menu');
            if ($subMenu.hasClass('box-search-g'))
            {
                $("#box-search-g").fadeToggle();
                $(".box-overlay").removeClass('active')
            }else {

            }
        })
        $("body").on("click",".box-overlay.active", function (event) {
            event.preventDefault();
            $(this).removeClass('active')
            $("#box-search-g").fadeToggle();
        })
    },

    showCategory()
    {
        let $iconCate = $('.js-menu-cate');
        $iconCate.click(function(){
            $("#menu-main").slideToggle();
        })

        $("#menu-main").hover(
            function() {

            }, function() {
                $(this).hide();
            }
        );
    },

    fixTopMenu()
    {
        $(document).on( 'scroll', function(){
            let $header = $(".commonTop");
            let $topHeader = $(".js-header-top")
            let heightTopHeader = $("#js-top-header-mb").outerHeight();
            let heightTopHeaderDesktop = $("#js-header-top").outerHeight();
            var window_size = $(window).width();

            $(window).resize(function() {
                window_size = $(window).width();
            });

            if (window_size >= 768)
            {
                heightTopHeader = heightTopHeaderDesktop;
            }

            if ($(window).scrollTop() > 150 ) {

                if (!$header.hasClass('fix-top'))
                {
                    $header.addClass('fix-top')
                    $topHeader.addClass('fix-top-header');
                    $header.css("top",heightTopHeader + "px")
                }

            }else {
                if ($header.hasClass('fix-top'))
                {
                    $header.removeClass('fix-top')
                    $topHeader.removeClass('fix-top-header');
                    $header.css("top","0")
                }

            }
        });
    }
};

export default RunCommon
