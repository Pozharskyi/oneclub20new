/**
 * Created by Home on 05.09.2016.
 */

function addSubProduct()
{
    var id = $("#subQuantity").val();

    $.ajax({
        url: "/admin/products/sub_product/" + id,
        data: "csrf_token=91LmJoa82MlA1",
        type: "get",
        success: function( result )
        {
            $("#sub_products").append( result );
        }
    });

    $("#subQuantity").val( parseInt(id) + 1 );
}