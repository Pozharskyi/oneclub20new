function toggleBalance(element) {
    var balance = parseInt($("#balance").text());
    var payment_left = parseInt($("#payment_left span").text());
    if (element.checked) {
        $("#payment_left").show();
        applyBalance(balance, payment_left);
    } else {
        $("#payment_left").hide();
        var balance_origin = parseInt($('#balance_origin').text());
        revertBalance(balance_origin, balance, payment_left);
    }
}
function applyBalance(balance, payment_left) {
    if (payment_left < balance) {
        $("#payment_left span").html(0);
        $("#balance").html(balance - payment_left);
    } else {
        $("#balance").html(0);
        console.log(balance);
        $("#payment_left span").html(payment_left - balance);
    }
}

function revertBalance(balance_origin, balance, payment_left) {
    $("#balance").html(balance_origin);
    if (balance == 0) {
        $("#payment_left span").html(payment_left + balance_origin);
    } else {
        $("#payment_left span").html(balance_origin - balance);
    }
}