/**
 * Created by Home on 04.10.2016.
 */

function deleteColor( role_id )
{
    $.ajax({
        url: "/admin/manage/roles/delete",
        data: "role_id=" + role_id,
        type: "DELETE",
        success: function ( result )
        {
            if( result == 'true' )
            {
                $("#role_" + role_id).css("display", "none") ;
            } else
            {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            }
        }
    });
}