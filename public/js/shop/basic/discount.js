/**
 * Created by Home on 31.08.2016.
 */

var getXsrfToken = function () {
    var cookies = document.cookie.split(';');
    var token = '';

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].split('=');
        if (cookie[0] == 'XSRF-TOKEN') {
            token = decodeURIComponent(cookie[1]);
        }
    }

    return token;
};

function validateDiscount() {

    var coupon_code = $("#discount").val();
    $("#discount_status h5").remove();
    var block = $("#discount_status");

    $.ajax({
        url: "/list/discounts/",
        //data: "csrf_token=91LmJoa82MlA1",
        data: {
            coupon_code: coupon_code
        },
        type: "PUT",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function (result) {

            if (typeof result === 'string' || result instanceof String) {
                var status = result;
                block.append('<h5>' + coupon_code + ' - ' + status + '</h5>');
            } else {
                var discount = result;
                updatePriceWithDiscount(discount.moneyDiscount);
                block.append('<h5>' + coupon_code + ' - скидка ' + discount.moneyDiscount + 'грн</h5>');
                $("#discountId").val(discount.id);
            }
        },
        error: function () {
            //console.log(error);
        }
    });
}

function updatePriceWithDiscount(discount_quantity) {

    //revert balance
    var payment_left = $("#payment_left span").text();
    var balance = parseInt($("#balance").text());
    var balance_origin = parseInt($('#balance_origin').text());
    revertBalance(balance_origin, balance, payment_left);
    //revert balance

    var total = $("#total_price").val();

    var delta = parseInt(total) - discount_quantity;

    //$("#discountsButton").attr("disabled", true);

    $("#total").text(delta);
    var payment_left = total;

    payment_left -= discount_quantity;
    $("#payment_left span").text(payment_left);

    //START APPLY AGAIN BALANCE
    if($('#useBalance').is(':checked')){
        $("#payment_left").show();
        var balance = parseInt($("#balance").text());
        applyBalance(balance, payment_left);
    }
    //END APPLY AGAIN BALANCE
}
