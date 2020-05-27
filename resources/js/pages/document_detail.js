import RunCommon from './../common/run_common';
import { loadCss } from './../common/lazyload_file'
import 'owl.carousel/dist/owl.carousel.min';
import toast  from 'toastr';
import Rating from "../components/rating";
import Affiliate from "../components/set_affiliate";
import 'jquery-modal'
import {CookieMonster} from "cookiemonster";

var Home = {
	page : 1,
	is_click : false,
	load_preview : true,
	init()
	{
		this.loadCssLazy();
		this.loadDocumentSuggest();
		this.runSlider();
		this.showSort();
		this.showDownloadFooter();
		this.showItemFilterDesktop();
		this.checkDownloadDocument();
		this.loadPreviewFile();
		this.showNotFoundFile();
		this.showPopupConfirmBuy();
        this.loadRatings();

		if (typeof DOWNLOAD != "undefined")
		{
			let $elementLink = $("#js-auto-download");
			let URL = $elementLink.attr('href');
			if(URL)
			{
				window.location.href = URL;
			}
		}
	},

	showNotFoundFile()
	{
		$(".js-show-not-file").click(function (event) {
			toast.warning("File không tồn tại. Hãy download tài liệu thuộc gói combo phía dưới");
		})
	},

	showPopupConfirmBuy()
	{
		$(".js-show-confirm-buy").click( function (event) {
			event.preventDefault();
			let $price = $(this).attr('data-price');
			$("#popup-alert-buy .price").html($price + " VNĐ");
			$("#popup-alert-buy").modal({
				escapeClose: false,
				clickClose: false,
				showClose: false
			});
		})
		$(".js-show-confirm-buy-combo").click( function (event) {
			event.preventDefault();
			let $price = $(this).attr('data-price');
			let URL = $(this).attr('href');
			$("#popup-alert-buy-combo .price").html($price + " VNĐ");
			$("#popup-alert-buy-combo .js-cart-combo").attr('href',URL);
			$("#popup-alert-buy-combo").modal({
				escapeClose: false,
				clickClose: false,
				showClose: false
			});
		})
	},

	loadPreviewFile()
	{
		let _this = this;
		$(".js-load-preview").click(function (event) {
			event.preventDefault();
			let $this = $(this);
			let URL = $this.attr('href');
			if (_this.is_click === true)
			{
				toast.warning("Click quá nhanh. Hãy đợi dữ liệu tải xong");
				return  false;
			}
			_this.is_click = true;

			let htmlBefore = $this.html();
			let newHtml = `Đang xử lý <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>`;

			let $page = _this.page + 1;
			_this.page = $page;

			if ( _this.load_preview ===  false)
			{
				toast.warning("Đừng click nữa hết dữ liệu rồi");
				return false;
			}

			console.log($page);

			$.ajax({
				url : URL,
				beforeSend: function (xhr) {
					$this.html(newHtml);
				},
				method : "GET",
				data : {
					page : $page
				},
				success : function(results)
				{
					$this.html(htmlBefore);

					if (results.html === "")
					{
						toast.warning("Dữ liệu đã được tải hết");
						_this.load_preview = false;
						return false;
					}
					$("#content-document").append(results.html)
					_this.is_click = false;
				}
			});

		})
	},

	checkDownloadDocument()
	{
		$(".js-download-document").click(function (event) {
			event.preventDefault();
			let $this = $(this);
			if (typeof URL_CHECK_DOWNLOAD !== "undefined")
			{
				let htmlBefore = $this.html();
				let newHtml = `Đang tiến hành thanh toán <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>`;
				var cookies = new CookieMonster(document);
				let refID = null;
				if (typeof DOCUMENT_ID != "undefined")
				{
					refID = cookies.get('document_id_'+DOCUMENT_ID);
				}

				$.ajax({
					url : URL_CHECK_DOWNLOAD,
					method : "POST",
					data : {
						refID : refID
					},
					beforeSend: function()
					{
						$this.html(newHtml);
					},
					success : function(results)
					{
						console.log(results);
						$this.html(htmlBefore);
						if (results.code === 200)
						{
							if (results.link) {
								window.location.href =  results.link;
							}else {
								toast.success(results.messages)
							}
							return false;
						}

						if (results.code === 405){
							if (typeof results.very !== "undefined" && results.very) {
								$("#popup-not-very-account").modal({
									escapeClose: false,
									clickClose: false,
									showClose: false
								});
								return false;
							}

							$("#popup-alert-money").modal({
								escapeClose: false,
								clickClose: false,
								showClose: false
							});
							return false;
						}
					}
				});
			}
		})
	},

	showDownloadFooter(){
		var didScroll = false;
		$(window).scroll(function () {
			didScroll = true;
		});
		setInterval(function () {
			if (didScroll)
			{
				hasScrolled();
				didScroll = false;
			}
		}, 150);
		function hasScrolled() {
			var st = $(window).scrollTop();
			//slideDown
			if(st > 350){
				$('.box-footer-download').addClass('fixed-btn');
			}else {
				$('.box-footer-download').removeClass('fixed-btn');
			}
		}
	},

	showItemFilterDesktop()
	{
		$(".js-item-filter").click(function (event) {
			let $this = $(this);
			let $item = $this.find("div");
			$item.slideToggle();
		})
	},

	runSlider()
	{

		var sync1 = $("#slide-preview");
		var slidesPerPage = 4; //globaly define number of elements per page
		var syncedSecondary = true;

		sync1.owlCarousel({
			items : 1,
			slideSpeed : 2000,
			nav: true,
			autoplay: true,
			dots: true,
			loop: true,
			responsiveRefreshRate : 200,
			navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"]
		}).on('changed.owl.carousel', syncPosition);


		function syncPosition(el) {
			//if you set loop to false, you have to restore this next line
			//var current = el.item.index;

			//if you disable loop you have to comment this block
			var count = el.item.count-1;
			var current = Math.round(el.item.index - (el.item.count/2) - .5);

			if(current < 0) {
				current = count;
			}
			if(current > count) {
				current = 0;
			}
		}
	},

	showSort() {
		$(".js-show-sort").click(function (event) {
			event.preventDefault();
			let $nextUl = $(this).next();
			$nextUl.slideToggle();
		})
	},

	loadCssLazy()
	{
		if (typeof CSS != 'undefined')
		{
			loadCss(CSS);
		}
	},


    loadRatings()
    {
        let _this = this;
        $(window).on('load', function() {
            if (typeof URL_RENDER_RATING !== "undefined")
            {
                $.ajax({
                    url : URL_RENDER_RATING,
                    method : "GET",
                    success : function(results)
                    {
                    	if (results.html)
						{
							$("#block-ratings").html(results.html);
						}
                    }
                });
            }
        });
    },

	loadDocumentSuggest()
	{
		if (typeof URL_PAGE_DOCUMENT_DETAIL !== "undefined")
		{
			$.ajax({
				url : URL_PAGE_DOCUMENT_DETAIL,
				method : "GET",
				data :{
					documentID : DOCUMENT_ID,
					categoryID : CATEGORY_ID
				},
				success : function(results)
				{
					if (results.document)
					{
						$("#js-document-suggest").html(results.document)
						RunCommon.lazyLoadImage();
					}else {
						$("#js-document-suggest").html('');
					}
					if (results.combo_wiew)
					{
						$("#js-detect-combo").html(results.combo_wiew)
					}else {
						$("#js-detect-combo").html('')
					}

				}
			});
		}
	}
};
$(function () {
	Home.init();
	Rating.init();
	RunCommon.init();

	if (typeof REF !== "undefined" && REF != 0)
		Affiliate.init('document_id_');
});
