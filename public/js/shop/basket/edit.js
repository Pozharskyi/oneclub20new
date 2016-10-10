/**
 * Created by Home on 30.08.2016.
 */

function changeData( basked_id, quantity ) {

    $.ajax({
        url: "/list/change/" + basked_id,
        data: "quantity=" + quantity,
        type: "post",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function() {}
    });
}

function dropBasketItem( basket_id ) {

    $.ajax({
        url: "/list/save/" + basket_id,
        data: "csrf_token=91LmJoa82MlA1",
        type: "DELETE",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function()
        {
            $("#item_" + basket_id).css("display", "none");
        }
    });
}

function decreaseItem( basket_id ) {

    var total = $("#total").text();
    var special = $("#special").text();

    var item = $("#product_price_" + basket_id);
    var quantity = $("#quantity_" + basket_id);

    var special_price = $("#special_price_" + basket_id).val();
    var final_price = $("#final_price_" + basket_id).val();

    var current_price = item.text();

    var qty = quantity.val();
    qty--;

    if( qty == 0 )
    {
        deleteItem( basket_id );
    } else
    {
        var new_price_for_product = current_price - special_price;
        item.html( new_price_for_product );

        quantity.val(qty);

        var new_total = total - special_price;

        $("#total").html(new_total);

        var delta = final_price - special_price;

        var new_special = special - delta;

        $("#special").html(new_special);

        changeData(basket_id, -1);
    }
}

var available = 'false';

function getter()
{
    return available;
}

function setter( value )
{
    available = value;
}

function validateProductAvailability( basket_id, total_quantity )
{
    var url = "/list/validate/" + basket_id + "/" + total_quantity;

    $.ajax({
        url: url,
        data: "csrf_token=91LmJoa82MlA1",
        type: "PUT",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function( result )
        {
            setter( result );

            if( result != 'true' )
            {
                window.location.href = '/basket?error=product_adding' + result;
            }
        },
        async: false
    });
}

function increaseItem( basket_id ) {

    var total = $("#total").text();
    var special = $("#special").text();

    var item = $("#product_price_" + basket_id);
    var quantity = $("#quantity_" + basket_id);

    validateProductAvailability( basket_id, quantity.val() );

    if( getter() == 'true' )
    {
        var special_price = $("#special_price_" + basket_id).val();
        var final_price = $("#final_price_" + basket_id).val();

        var current_price = item.text();

        var new_price_for_product = parseInt(current_price) + parseInt(special_price);
        item.html( new_price_for_product );

        var qty = quantity.val();
        qty++;

        quantity.val( qty );

        var new_total = parseInt(total) + parseInt(special_price);

        $("#total").html( new_total );

        var delta = parseInt(final_price) - parseInt(special_price);

        var new_special = parseInt(special) + parseInt(delta);

        $("#special").html( new_special );

        changeData( basket_id, 1 );
    }
}