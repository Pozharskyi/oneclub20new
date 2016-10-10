/**
 * Created by Home on 18.08.2016.
 */

function getDeliveryPoints( city_id ) {

    $.ajax({
        url: "/delivery/nova_poshta/delivery_points/" + city_id,
        data: "csrf_token=91LmJoa82MlA1",
        type: "get",
        success: function( result )
        {
            $("#delivery_point").html( result );
        }
    });
}