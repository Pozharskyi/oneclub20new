/**
 * Created by Home on 25.09.2016.
 */

function deleteShare( share_id )
{
    $.ajax({
        url: "/admin/import/share/delete",
        data: "share_id=" + share_id,
        type: "DELETE",
        success: function()
        {
            $("#share_" + share_id).css("display", "none");
        }
    });
}

function search( type )
{
    var search = $("#search").val();

    $.ajax({
        url: "/admin/import/share/search",
        data: "search=" + search,
        type: "PUT",
        success: function( result )
        {
            $("#result_row").html( result );

            if( type == 'find' )
            {
                $("#clear").html('<a href="javascript: void(0);" onclick="clearSearch();">Сбросить</a>');
            }
        }
    });
}

function clearSearch()
{
    $("#search").val('');

    search( 'basic' );
    $("#clear").html('');
}