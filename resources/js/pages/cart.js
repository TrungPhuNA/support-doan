import 'slider-pro';
import 'owl.carousel/dist/owl.carousel.min';
import RunCommon from './../common/run_common';
import toast  from 'toastr';
var Cart = {
    init(){
        this.deleteItemTransaction();
        this.jsIncreaseQty();
        this.jsReductionQty();
        this.formatMoney();
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
    deleteItemTransaction()
    {
        $(".js-delete-item").click( function(event){
            event.preventDefault();
            let $this = $(this);
            let url    = $this.attr('href');

            if(url) {
                $.ajax({
                    url: url,
                }).done(function( results ) {
                    toast.success(results.messages);
                    $this.parents('tr').remove();
                    $("#sub-total").text(results.totalMoney+ " đ");
                });
            }
        })

    },
    jsReductionQty()
    {
        $('.js-reduction').click(function (event) {
            let $this  = $(this);
            let $input = $this.parent().prev();
            let number = parseInt($input.val());
            if (number <= 1) {
                toast.warning("Số lượng sản phẩm phải >= 1");
                return false;
            }

            let URL       = $this.parent().attr('data-url');
            let productID = $this.parent().attr("data-id-product");


            number = number - 1;
            $.ajax({
                url: URL,
                data: {
                    qty        : number,
                    idProduct  : productID
                }
            }).done(function( results ) {
                if (typeof results.totalMoney !== "undefined") {
                    $input.val(number);
                    $("#sub-total").text(results.totalMoney+ " đ");
                    toast.success(results.messages);
                    $this.parents('tr').find(".js-total-item").text(results.totalItem +' đ');
                }else {
                    $input.val(number + 1);
                }
            });
        })
    },

    jsIncreaseQty()
    {
        $('.js-increase').click(function (event) {
            event.preventDefault();
            let $this = $(this);
            let $input = $this.parent().prev();
            let number = parseInt($input.val());
            if (number >= 10) {
                toast.warning("Mỗi sản phẩm chỉ được mua tối đa số lượng 10 lần / 1 lần mua");
                return false;
            }

            let price = $this.parent().attr('data-price');
            let URL = $this.parent().attr('data-url');
            let productID = $this.parent().attr("data-id-product");

            number = number + 1;
            $.ajax({
                url: URL,
                data: {
                    qty        : number,
                    idProduct  : productID
                }
            }).done(function( results ) {
                if (typeof results.totalMoney !== "undefined") {
                    $input.val(number);
                    $("#sub-total").text(results.totalMoney+ " đ");
                    toast.success(results.messages);
                    $this.parents('tr').find(".js-total-item").text(results.totalItem +' đ');
                }else {
                    $input.val(number - 1);
                }
            });
        })
    }

};
$(function () {
    Cart.init();
    RunCommon.init();
});
