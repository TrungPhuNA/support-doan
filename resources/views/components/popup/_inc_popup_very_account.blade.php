@if (get_data_user('web'))
<div id="popup-not-very-account" class="modal text-center">
	<div class="header">Chưa xác nhận tài khoản</div>
	<div class="content">
		<p>Tài khoản của bạn chưa xác nhân. Xin vui lòng xác nhận tài khoản
			<a href="{{ route('get.confirmation.very_account',[
			'slug'   => get_data_user('web','slug'),
		]) }}">tại đây</a>
		</p>
	</div>
</div>
@endif