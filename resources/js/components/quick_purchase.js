import toast from "toastr";

var QuickPurchase = {
	init : function () {
		this.showPopupInfoBay();
		this.saveQuickPurchase();
	},

	showPopupInfoBay()
	{
		$("body").on("click",".js-quick-purchase", function(event){
			event.preventDefault();
			let $this = $(this);
			let title = $this.attr('title');
			let price = $this.attr('data-price')
			$("#popup-quick-purchase #title").text(`${title}`);
			$("#popup-quick-purchase #money").val(price)
			$("#form-quick-purchase #code").val($this.attr('data-code'))
			$("#form-quick-purchase #type").val($this.attr('data-type'))

			$("#popup-quick-purchase").modal({
				escapeClose: false,
				clickClose: false,
				showClose: false
			});
		})
	},
	saveQuickPurchase()
	{
		let _this = this;
		$(".js-save-quick-purchase").click(function (event) {
			event.preventDefault();
			let $this = $(this);
			let htmlBefore = $this.html();
			let newHtml = `Đang xử lý <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>`;

			let $phone = $("#phone");
			let phone_value = $phone.val();
			if (phone_value.length === 0) {
				$phone.next().html('Mời bạn nhập số điện thoại');
				return false;
			}

			if (!_this.validatePhone(phone_value)) {
				$phone.next().html('Số điện thoại không đúng định dạng');
				return false;
			}
			$phone.next().html('');
			if (typeof URL_BUY_TEMPORARITY !== "undefined")
			{
				$.ajax({
					beforeSend: function (xhr) {
						$this.html(newHtml);
					},
					url: URL_BUY_TEMPORARITY,
					method: "POST",
					data: $('#form-quick-purchase').serialize(),
				}).done(function (results) {
					$this.html(htmlBefore);
					if (results.code == 200)
					{
						$("#popup-quick-purchase-success").modal({
							escapeClose: false,
							clickClose: false,
							showClose: false
						})
					}
				});
			}
		});
	},
	validatePhone(phone)
	{
		let regExp = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
		if(phone.match(regExp)) return true;
		return  false;
	}
}

export default QuickPurchase;