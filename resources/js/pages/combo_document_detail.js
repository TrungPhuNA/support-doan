import RunCommon from './../common/run_common';
import { loadCss } from './../common/lazyload_file'
import 'owl.carousel/dist/owl.carousel.min';
import toast  from 'toastr';
import Rating from "../components/rating";
import 'jquery-modal'

var ComboDocumentDetail = {
	page : 1,
	is_click : false,
	load_preview : true,
	init()
	{
		this.loadCssLazy();
		this.runSlider();
		this.showSort();
		this.showItemFilterDesktop();
		this.checkDownloadDocument();
		this.processPayCombo();
		this.showNotFoundFile();
		this.showPopupConfirmBuy();

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

	processPayCombo()
	{
		$(".js-cart-combo").click(function (event) {
			event.preventDefault();
			let $this = $(this);
			let URL = $this.attr('href');


			let htmlBefore = $this.html();
			let newHtml = `Đang xử lý <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>`;

			$.ajax({
				url : URL,
				beforeSend: function (xhr) {
					$this.html(newHtml);
				},
				method : "POST",
				success : function(results)
				{
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
							console.log(results.very)
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
				$.ajax({
					url : URL_CHECK_DOWNLOAD,
					method : "POST",
					beforeSend: function()
					{
						$this.html(newHtml);
					},
					success : function(results)
					{
						console.log("1111");
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
};
$(function () {
	ComboDocumentDetail.init();
	Rating.init();
	RunCommon.init();
});
