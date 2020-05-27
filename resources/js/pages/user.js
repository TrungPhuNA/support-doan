import 'jquery-modal'
import RunCommon from './../common/run_common';

var User = {
	init(){
		RunCommon.init();
		this.formatMoney();
		this.changeAvatar();
	},
	changeAvatar()
	{
		$("#imgInp").change(function() {
			readURL(this);
		});

		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
					$('#blah').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]); // convert to base64 string
			}
		}
	},

	formatMoney()
	{
		$('#money').on('input', function(e){
			$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
		}).on('keypress',function(e){
			if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
		}).on('paste', function(e){
			var cb = e.originalEvent.clipboardData || window.clipboardData;
			if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
		});
		function formatCurrency(number){
			var n = number.split('').reverse().join("");
			var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
			return  n2.split('').reverse().join('') ;
		}
	},
}

$(function () {
	User.init();
})