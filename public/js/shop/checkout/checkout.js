/**
 * Created by Home on 31.08.2016.
 */

/**
 * Changing with range changing
 */
$('#bonuses').on("change mousemove", function() {
    $("#bonuses_val").val($(this).val());
    $("#bonuses_uah").html($(this).val());
});

/**
 * Getting points to order
 */
function getPointsToOrder() {

    var points = $("#bonuses_val").val();
    var total = $("#total").text();


    //revert balance
    var payment_left = $("#payment_left span").text();
    var balance = parseInt($("#balance").text());
    var balance_origin = parseInt($('#balance_origin').text());
    revertBalance(balance_origin, balance, payment_left);
    //revert balance

    var delta = total - points;

    $("#total").html( delta );

    //set payment_left new value with bonuses amount
    $("#payment_left span").text(delta);
    var payment_left = delta;

    //START APPLY AGAIN BALANCE
    if($('#useBalance').is(':checked')){
        $("#payment_left").show();
        var balance = parseInt($("#balance").text());
        applyBalance(balance, payment_left);
    }
    //END APPLY AGAIN BALANCE

    // set to zero bonuses
    $("#bonuses_val").val(0);
    $("#bonuses_uah").html(0);

    var current_max_bonuses = $("#bonuses").attr("max");

    $("#bonuses").attr({
        "max" : current_max_bonuses - points // substitute your own
    });

    $("#bonuses").val( 0 );

    var current_bonuses = $("#current_bonuses").text();
    var delta_bonuses = current_bonuses - points;
    $("#current_bonuses").html( delta_bonuses );

    var used_bonuses = parseInt($("#bonuses_count").val());
    used_bonuses += parseInt(points);

    $("#bonuses_count").val( used_bonuses );

    $("#bonuses_set").html('Вы уже использовали ' + used_bonuses + ' бонусов');
}

function resetPointsToOrder() {

    var total = parseInt($("#total").text());
    var used_points = parseInt($("#bonuses_count").val());

    //revert balance
    var payment_left = $("#payment_left span").text();
    var balance = parseInt($("#balance").text());
    var balance_origin = parseInt($('#balance_origin').text());
    revertBalance(balance_origin, balance, payment_left);
    //revert balance

    var delta = total + used_points;
    $("#total").html( delta );

    //set payment_left new value with bonuses amount
    $("#payment_left span").text(delta);
    var payment_left = delta;

    //START APPLY AGAIN BALANCE
    if($('#useBalance').is(':checked')){
        $("#payment_left").show();
        var balance = parseInt($("#balance").text());
        applyBalance(balance, payment_left);
    }
    //END APPLY AGAIN BALANCE


    $("#bonuses_set").html('');

    var bonuses_max = $("#bonuses_max").val();

    $("#bonuses").attr({
        "max" : bonuses_max // substitute your own
    });

    $("#current_bonuses").html( bonuses_max );
    $("#bonuses_count").val(0);
}
