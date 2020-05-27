import toast from "toastr";

var Rating =  {
	init : function () {
		this.showFormReview();
		this.processReview();
		this.saveRatingToDb();
	},
	showFormReview()
	{
		$("body").on("click",".js-review", function(event)
		{
			event.preventDefault();
			let $this = $(this);
			if ($this.hasClass('js-check-login')) {
				toast.warning("Đăng nhập để thực hiện chức năng này");
				return false;
			}
			if ($(this).hasClass('active')) {
				$(this).text("Gửi đánh giá").addClass('').removeClass('btn-default active')
			} else {
				$(this).text("Đóng lại").addClass('btn-default active').removeClass('');
			}
			$("#block-review").slideToggle();
		})
	},

	processReview()
	{
		// Hover icon thay đổi số sao dánh giá

		let arrTextRating = {
			1: "Không thích",
			2: "Tạm được",
			3: "Bình thường",
			4: "Rất tốt",
			5: "Tuyệt vời"
		}

		$("body").on("mouseover","#ratings i", function(){
			let $item = $("#ratings i");
			let $this = $(this);
			let $i = $this.attr('data-i');
			$("#review_value").val($i);
			$item.removeClass('active');
			$item.each(function (key, value) {
				if (key + 1 <= $i) {
					$(this).addClass('active')
				}
			})
			$("#reviews-text").text(arrTextRating[$i]);
		})
	},

	saveRatingToDb()
	{
		$("body").on("click",".js-process-review", function(event){
			event.preventDefault();
			let $content = $("#rv_content").val();
			if ($content.length < 30) {
				toast.error("Nội dung đánh giá phải nhiều hơn 30 ký tự");
				return false;
			}
			if ($content.length >= 80) {
				toast.error("Nội dung đánh giá không được quá 80 ký tự");
				return false;
			}

			let URL = $(this).parents('form').attr('action');
			$.ajax({
				url: URL,
				method: "POST",
				data: $('#form-review').serialize(),
			}).done(function (results) {
				$('#form-review')[0].reset();
				$(".js-review").trigger('click');
				if (results.html) {
					let $listRating = $(".reviews_list .item");
					if ($listRating.length >= 5)
					{
						$listRating.last().remove();
					}
					// console.log(results.ratingDefault);
					let ratings = results.ratingDefault;
					$.each(ratings, function(index, value){
						if (results.total_rating > 0)
						{
							let age = Math.round((value.count_number / results.total_rating) * 100);
							$("#rating-age-" + index).attr('style','width: '+ age + '% !important')
						}

						$("#rating-count-" + index).text(value.count_number);
					})

					$(".reviews_list").prepend(results.html);
					$("#rating-age").text(results.age);
				}
				toast.success(results.messages);
			});
		})
	}
}
export default Rating;