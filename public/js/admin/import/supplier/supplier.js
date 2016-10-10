/**
 * Created by Home on 21.09.2016.
 */

function deleteSupplier( id )
{
    $.ajax({
        url: "/admin/import/suppliers/delete",
        data: "supplier_id=" + id,
        type: "DELETE",
        success: function()
        {
            $("#result_" + id).css("display", "none");
        }
    });
}

function cancel()
{
    $("#cancel").html('');
    $("#supplier").val('');

    $.ajax({
        url: "/admin/import/suppliers/find",
        data: "search=",
        type: "PUT",
        success: function( result )
        {
            $("#lead_body").html( result );
        }
    });
}

function findSupplier()
{
    var search = $("#supplier").val();

    $("#cancel").html('<a onclick="cancel();" style="color: rgb(240, 0, 140);" href="javascript: void(0);">Отменить поиск</a>');

    $.ajax({
        url: "/admin/import/suppliers/find",
        data: "search=" + search,
        type: "PUT",
        success: function( result )
        {
            console.log( result );
            $("#lead_body").html( result );
        }
    });
}