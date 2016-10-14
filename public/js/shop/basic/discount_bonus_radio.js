function discountClicked() {
    $("#discount_status").empty();  //clear discount_status section
    $("#discountsButton").attr("disabled", false);
    $("#bonusSection").hide();
    resetPointsToOrder();

    //revert balance
    var payment_left = $("#payment_left span").text();
    var balance = parseInt($("#balance").text());
    var balance_origin = parseInt($('#balance_origin').text());
    revertBalance(balance_origin, balance, payment_left);
    //revert balance

    //revert total
    var total_price = $("#total_price").val();
    $("#total").text(total_price);

    //set value of payment_left as it was first
    $("#payment_left span").text(total_price);
    var payment_left = $("#payment_left span").text();


    //START APPLY AGAIN BALANCE
    if($('#useBalance').is(':checked')){
        $("#payment_left").show();
        var balance = parseInt($("#balance").text());
        applyBalance(balance, payment_left);
    }
    //END APPLY AGAIN BALANCE

}

function bonusClicked() {
    $("#discount_status").empty();  //clear discount_status section
    resetPointsToOrder();
    $("#bonusSection").show();


    //revert balance
    var payment_left = $("#payment_left span").text();
    var balance = parseInt($("#balance").text());
    var balance_origin = parseInt($('#balance_origin').text());
    revertBalance(balance_origin, balance, payment_left);
    //revert balance

    //revert total
    var total_price = $("#total_price").val();
    $("#total").text(total_price);

    //set value of payment_left as it was first
    $("#payment_left span").text(total_price);
    var payment_left = $("#payment_left span").text();


    //START APPLY AGAIN BALANCE
    if($('#useBalance').is(':checked')){
        $("#payment_left").show();
        var balance = parseInt($("#balance").text());
        applyBalance(balance, payment_left);
    }
    //END APPLY AGAIN BALANCE
}

function autoDiscountClicked() {
    $("#discount_status").empty();  //clear discount_status section

    $("#bonusSection").hide();
    resetPointsToOrder();
    $("#discountsButton").attr("disabled", true);

    var origin_price = $("#origin_price").val();

    var payment_type = $("input[name='payment_type']").val();
    var delivery_type = $("input[name='delivery_type']").val();
    var block = $("#discount_status");
    $.ajax({
        url: "/list/auto_discount",
        //data: "csrf_token=91LmJoa82MlA1",
        data: {
            delivery_type: delivery_type,
            payment_type: payment_type
        },
        type: "POST",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function (discount) {
            if (typeof discount === 'string' || discount instanceof String) {
                block.append('<h5>' + ' - ' + discount + '</h5>');
            } else {
                updatePriceWithDiscount(discount.moneyDiscount);

            }

                //var discount = result;
                //updatePriceWithDiscount(discount.moneyDiscount);
                //block.append('<h5>' + coupon_code + ' - скидка ' + discount.moneyDiscount + 'грн</h5>');
                //$("#discountId").val(discount.id);


        },
        error: function () {
            console.log(error);
        }
    });


}