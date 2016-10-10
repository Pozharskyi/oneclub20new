/**
 * Created by Home on 26.09.2016.
 */

function deleteSubProduct( sub_product_id )
{
    $.ajax({
        url: "/admin/import/parties/search/product",
        data: "sub_product_id=" + sub_product_id,
        type: "DELETE",
        success: function ( result )
        {
            if( result == 'true' )
            {
                $("#product_" + sub_product_id).css("display", "none") ;
            } else
            {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            }
        }
    });
}

function searchBySku()
{
    var sku = $("#sku").val();

    $.ajax({
        url: "/admin/import/parties/search/sku",
        data: "sku=" + sku,
        type: "PUT",
        success: function ( result )
        {
            $("#result").html( result );
            $("#barcode").val('');
        }
    });
}

function searchByBarcode()
{
    var barcode = $("#barcode").val();

    $.ajax({
        url: "/admin/import/parties/search/barcode",
        data: "barcode=" + barcode,
        type: "PUT",
        success: function ( result )
        {
            $("#result").html( result );
            $("#sku").val('');
        }
    });
}

function clearSearch()
{
    $("#barcode").val('');
    $("#sku").val('');

    searchBySku();
}