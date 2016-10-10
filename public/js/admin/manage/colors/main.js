/**
 * Created by Home on 04.10.2016.
 */

function deleteColor( color_id )
{
    $.ajax({
        url: "/admin/manage/colors/delete",
        data: "color_id=" + color_id,
        type: "DELETE",
        success: function ( result )
        {
            if( result == 'true' )
            {
                $("#color_" + color_id).css("display", "none") ;
            } else
            {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            }
        }
    });
}