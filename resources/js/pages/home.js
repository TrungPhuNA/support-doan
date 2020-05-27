import RunCommon from './../common/run_common';
import { loadCss } from './../common/lazyload_file'
import 'owl.carousel/dist/owl.carousel.min';

import 'jquery-modal'

var Home = {
    init()
    {
        this.runSlider();
        this.loadCssLazy();
        this.loadProductByCategory();
        this.loadDocumentHot();
        this.loadComboHot();
        this.loadDataAfterLoadPage();
        this.addNotify();
    },

    addNotify()
    {
        // let height_top = $("#js-header-top").outerHeight();
        // let height_common = $("#js-commonTop").outerHeight();
        // $("#js-activity").attr('style','top: '+ (height_top + height_common) + "px !important");
        let _this = this;
        var myArray = ['Nguyễn Thúy An', 'Nguyễn Mai Anh', 'Nguyễn Thùy Chi', 'Nguyễn Kim Ngân', 'Nguyễn Thu Thảo', 'Nguyễn Thanh Vân', 'Nguyễn Hoàng Mai Anh', 'Nguyễn Ngọc Lan', 'Nguyễn Ngọc Tường', 'Nguyễn Gia Bảo', 'Nguyễn Bình An', 'Nguyễn Gia An', 'Nguyễn Minh Khôi', 'Nguyễn Đức Minh', 'Nguyễn Đình Tâm', 'Nguyễn Minh Khang', 'Nguyễn Đình Nguyên', 'Lê Bảo Châu', 'Lê Anh Thư', 'Lê Bảo Ngọc', 'Lê Bảo Trân', 'Lê Minh Ngọc', 'Lê Quỳnh Thư', 'Lê Đan Tú', 'Lê Tú Linh', 'Lê Ngọc Hân', 'Lê Uyển Nhi', 'Lê Vân Anh', 'Lê Vân Nhi', 'Lê Uyên Thư', 'Lê Gia An', 'Lê Hoài Anh', 'Lê Nhật Minh', 'Lê Quốc Bình', 'Lê Tuấn Anh', 'Lê Đức Minh', 'Phạm Ánh Dương', 'Phạm Diễm My', 'Phạm Diệp Anh', 'Phạm Diệu Anh', 'Phạm Diệu Linh', 'Phạm Gia Hân', 'Phạm Gia Linh', 'Phạm Khánh Ly', 'Phạm Khánh Ngân', 'Phạm Khánh Ngọc', 'Phạm Hoàng Yến', 'Phạm Khánh Quỳnh', 'Phạm Minh Thư', 'Phạm Mẫn Nhi', 'Phạm Mỹ Duyên', 'Phạm Khánh Vy', 'Phạm Khánh Vân', ' Phạm Hoàng Anh', 'Phạm Thiên An', 'Phạm Gia An', 'Phạm Gia Phúc', 'Phạm Nhật Minh', 'Phạm Đức Duy', 'Phạm Anh Minh', ' Phạm Thiên Ân', ' Phạm Hùng Cường', 'Phạm Hữu Đạt', 'Đặng Ngọc Anh', 'Đặng Ánh Mai', 'Đặng Bích Liên', 'Đặng Diễm Quỳnh', 'Đặng Diễm Thư', 'Đặng Trúc Lâm', 'Đặng Trúc Linh', 'Đặng Bình An', 'Đặng Minh Ân', 'Đặng Gia Phát', 'Đặng Gia Nguyên', 'Đặng Minh Quân', ' Đặng Thiện Nhân', 'Đặng Huy Hoàng', 'Đặng Minh Khang', 'Đặng Ðăng Khoa', ' Đặng Trung Kiên', 'Đặng Tuấn Kiệt', 'Đỗ Thụy Anh', 'Đỗ Thúy Diễm', 'Đỗ Thúy Hạnh', 'Đỗ Thùy An', 'Đỗ Thanh Hằng', 'Đỗ Đan Hạ', 'Đỗ Mai Chi', 'Đỗ Quỳnh Hương', 'Đỗ Phương Thảo', 'Đỗ Quốc Bảo', ' Đỗ Phúc Hưng', 'Đỗ Quang Khải', 'Đỗ Bảo Long', 'Đỗ Ðức Toàn', 'Đỗ Ðức Bình', 'Đỗ Phúc Thịnh', 'Đỗ Thành Đạt', 'Đỗ Thái Dương', 'Lý Anh Dũng', 'Lý Bảo Khánh', 'Lý Duy Khôi', 'Nguyễn Ngọc Khánh', 'Trần Thế Anh', 'Vũ Huy Hoàng', 'Bùi Đức Thắng', 'Lê Thùy Chi', 'Nguyễn Văn Tá', 'Nguyễn Thị Hương', 'Bùi Đức Tân', 'Nguyễn Quỳnh Nga', 'Nguyễn Hải Linh', 'Vũ Thị Mai Hương', 'Nguyễn Phương Loan', 'Lê Ngọc Quý', 'Phan Đình Thành', 'Bùi Văn Sáng', 'Nguyễn Trung Dũng', 'Hoàng Văn Thành', 'Bùi Văn Tiến', 'Trần Duy Anh', 'Nguyễn Văn Triệu', 'Nguyễn Tuấn Anh', 'Hoàng Thị Thúy', 'Trần Văn Quyết', 'Trần Đức Tân', 'Nguyễn Quang Anh', 'Bùi Thế Anh', 'Dương Văn Nghị', 'Bùi Văn Tài', 'Lê Thùy Trang', 'Nguyễn Đức Hiếu', 'Trần Thu Trang', 'Lê Bảo Anh', 'Bùi Phương Nga', 'Trần Văn Soái'];
        var myMoney = ['5.000','5.000','10.000','15.000','50.000','35.000','12.000'];

        let html = '';
        for (let i = 0; i <= 4; i++) {
            html += _this.renderItemNotify(myArray[Math.floor(Math.random() * myArray.length)]);
        }

        let $activity = $("#activity");
        $activity.html(html);

        setInterval(function(){

            let name  = myArray[Math.floor(Math.random() * myArray.length)];
            // let money = myMoney[Math.floor(Math.random() * myMoney.length)]
            if ($activity.find('.item').length === 5)
            {
                $activity.find(".item").last().remove();
            }
            let html = _this.renderItemNotify(name);
            $activity.prepend(html);
        },10000)
    },

    renderItemNotify(name)
    {
        return  `<div class="item">
                            <span class="bg"></span>
                            <div class="info flex">
                                <a href="">
                                    <img src="/images/user.png" alt="">
                                </a>
                                <p>
                                    <b>${name}</b>
                                    <span>Vừa mua tài liệu</span>
                                </p>
                            </div>
                            <p></p>
                        </div>`
    },

    loadDocumentHot()
    {
        let checkRenderProduct = false;
        $(document).on( 'scroll', function(){
            if ($(window).scrollTop() > 300 && checkRenderProduct === false ) {
                checkRenderProduct = true;
                if (typeof URL_LOAD_DOCUMENT_HOT !== "undefined") {
                    $.ajax({
                        url : URL_LOAD_DOCUMENT_HOT,
                        method : "GET",
                        success : function(results)
                        {
                            $("#document-hot").html(results.data);
                            RunCommon.lazyLoadImage();
                        }
                    });
                }
            }
        });
    },

    loadComboHot()
    {
        let checkRenderProduct = false;
        $(document).on( 'scroll', function(){
            if ($(window).scrollTop() > 300 && checkRenderProduct === false ) {
                checkRenderProduct = true;
                if (typeof URL_LOAD_COMBO_HOT !== "undefined") {
                    $.ajax({
                        url : URL_LOAD_COMBO_HOT,
                        method : "GET",
                        success : function(results)
                        {
                            $("#combo-hot").html(results.data);
                            RunCommon.lazyLoadImage();
                        }
                    });
                }
            }
        });
    },

    loadCssLazy()
    {
        if (typeof CSS != 'undefined')
        {
            loadCss(CSS);
        }
    },
    runSlider()
    {
        let itemProductFive = DEVICE === 'mobile' ? 2 : 6;

        $('.js-banner').owlCarousel({
            items: 1,
            smartSpeed: 450,
            loop: true,
            autoplay: true
        });

        $('.js-customer').owlCarousel({
            items: itemProductFive,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            lazyLoad: true,
            loop: true,
            dots: false,
            autoplay: true,
            margin: 10
        });
    },

    loadProductByCategory()
    {
        if (typeof routeRenderProductByCategory !== "undefined")
        {
            let checkRenderProduct = false;
            $(document).on( 'scroll', function(){
                if ($(window).scrollTop() > 500 && checkRenderProduct === false ) {
                    checkRenderProduct = true;
                    $.ajax({
                        url : routeRenderProductByCategory,
                        method : "GET",
                        success : function(results)
                        {
                            $("#product-by-category").html(results.data);
                        }
                    });
                }
            });
        }
    },

    loadDataAfterLoadPage()
    {
        if (typeof URL_LOAD_EVENT !== "undefined")
        {
            let checkRenderProduct = false;
            $(document).on( 'scroll', function(){
                if ($(window).scrollTop() > 500 && checkRenderProduct === false ) {
                    checkRenderProduct = true;
                    $("#home-video").attr('src','https://www.youtube.com/embed/If5Lg46Or9I')
                    $.ajax({
                        url : URL_LOAD_EVENT,
                        method : "GET",
                        async : false,
                        success : function(results)
                        {
                            if (typeof results.event1 !== "undefined")
                            {
                                let html_event1 = `<a href="${results.event1.link}" class="image" title="${results.event1.name}">
                                    <img src="${results.event1.banner}" alt="${results.event1.name}" style="margin: 10px 0;max-height: 100px">
                                </a>`
                                $("#event1").html(html_event1);
                            }

                            if (typeof results.event2 !== "undefined")
                            {
                                let html_event2 = `<a href="${results.event2.link}" class="image" title="${results.event2.name}">
                                    <img src="${results.event2.banner}" alt="${results.event2.name}" style="margin: 10px 0;max-height: 100px">
                                </a>`
                                $("#event2").html(html_event2);
                            }

                            if (typeof results.event3 !== "undefined")
                            {
                                let html_event3 = `<a href="${results.event3.link}" class="image" title="${results.event3.name}">
                                    <img src="${results.event3.banner}" alt="${results.event3.name}" style="margin: 10px 0;max-width: 100%;width: 100%">
                                </a>`
                                $("#event3").html(html_event3);
                            }

                            if (typeof results.comment_user !== "undefined")
                            {
                                $("#comment-user").html(results.comment_user);
                            }
                        }
                    });
                }
            });
        }
    }
};
$(function () {
    Home.init();
    RunCommon.init();
});
