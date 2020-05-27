import toast from "toastr";

var UpdateInfoUser = {
	init : function () {
		this.updateInfo();
	},

	updateInfo()
	{
		$("body").on("click",".js-update-info-user", function(event){
			event.preventDefault();
			let $this = $(this);
			let $domForm = $this.closest('form');
			let URL = $("#form-popup-update-info").attr('action')
			$.ajax({
				url: URL,
				method: "POST",
				data: $domForm.serialize()
			}).done(function (results) {
				$domForm[0].reset();
				if (results.code === 200)
				{
					$.modal.close();
					toast.success('Cập nhật thông tin thành công')
				}
			}).fail(function (results) {
				var errors = results.responseJSON;
				$.each(errors.errors, function (i, val) {
					$domForm.find('input[name=' + i + ']').siblings('.text-danger').text(val[0]);
				});
			});
		});
	}
}

export default UpdateInfoUser;