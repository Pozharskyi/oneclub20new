/**
 * Created by Home on 04.10.2016.
 */

function deleteSize( size_id )
{
    $.ajax({
        url: "/admin/manage/sizes/delete",
        data: "size_id=" + size_id,
        type: "DELETE",
        success: function ( result )
        {
            if( result == 'true' )
            {
                $("#size_" + size_id).css("display", "none") ;
            } else
            {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            }
        }
    });
}