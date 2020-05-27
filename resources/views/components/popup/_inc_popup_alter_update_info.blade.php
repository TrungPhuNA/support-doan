<div id="popup-update-info" class="modal">
	<div class="header">Cập nhật thông tin</div>
	<form action="{{ route('ajax_post.user.update_info', get_data_user('web')) }}" method="POST"
		  id="form-popup-update-info">
		@csrf
		<div class="content">
			<h4 id="title" style="text-transform: uppercase"></h4>
			<div class="form-group">
				<label for="phone" style="font-weight: 400">Số điện thoại<span class="cRed">(*)</span></label>
				<input name="phone" id="phone" type="number" value="{{  old('phone',get_data_user('web','phone')) }}" placeholder="" class="form-control">
				<span class="text-danger"></span>
			</div>
			<div class="form-group">
				<label for="price" style="font-weight: 400">Email<span class="cRed">(*)</span></label>
				<input name="email"  id="money" value="{{ old('email',get_data_user('web','email')) }}" placeholder=""  class="form-control">
				<span class="text-danger"></span>
			</div>
		</div>
		<div class="footer text-center">
			<a href="" class="btn  btn-success js-update-info-user"><i class="fa fa-save"></i> Cập nhật</a>
		</div>
	</form>
</div>