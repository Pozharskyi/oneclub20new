/**
 * Created by Home on 27.09.2016.
 */

function deleteUpdate( update_id )
{
    $.ajax({
        url: "/admin/import/update/delete",
        data: "update_id=" + update_id,
        type: "DELETE",
        success: function( result )
        {
            if( result != 'true' )
            {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            } else
            {
                $("#update_" + update_id).css("display", "none");
            }
        }
    });
}