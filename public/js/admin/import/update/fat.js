/**
 * Created by Home on 03.10.2016.
 */

function changeFatStatus( update_id, fat_status_id )
{
    $.ajax({
        url: "/admin/import/update/desc/search/" + update_id + "/" + fat_status_id,
        data: "csrf_token=15fmaL9mafF185",
        type: "PUT",
        success: function ( result )
        {
            $("#result").html( result );
        }
    });
}

function getDescription( file_line )
{
    var update_id = $("#update_id").val();

    $.ajax({
        url: "/admin/import/update/fat/file/parsing",
        data: "update_id=" + update_id + "&file_line=" + file_line,
        type: "PUT",
        success: function ( result )
        {
            $("#popup_content").html( result );
        }
    });

    getPopup();

}