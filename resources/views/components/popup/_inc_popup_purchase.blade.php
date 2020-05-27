<div id="popup-quick-purchase" class="modal">
	<div class="header">Đăng ký mua tài liệu</div>
	<form action="" id="form-quick-purchase">
		<div class="content">
			<h4 id="title" style="text-transform: uppercase"></h4>
			<div class="form-group">
				<label for="phone" style="font-weight: 400">Số điện thoại đặt mua<span class="cRed">(*)</span></label>
				<input name="phone" id="phone" type="number" value="{{  old('phone') }}" placeholder="0986420994" class="form-control">
				<span class="text-danger"></span>
			</div>
			<div class="form-group">
				<label for="price" style="font-weight: 400">Số tiền cần thanh toán<span class="cRed">(*)</span></label>
				<input name="price" style="font-weight: bold" disabled id="money" value=""  class="form-control">
			</div>
			<input type="hidden" name="type" value="" id="type">
			<input type="hidden" name="code" id="code" value="">
		</div>
		<div class="footer text-center">
			<a href="#" rel="modal:close" class="btn  btn-light">Huỷ bỏ</a>
			<a href="" class="btn  btn-success js-save-quick-purchase"><i class="fa fa-shopping-bag"></i> Đặt hàng ngay</a>
		</div>
	</form>
</div>