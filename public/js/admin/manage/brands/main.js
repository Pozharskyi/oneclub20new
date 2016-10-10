/**
 * Created by Home on 04.10.2016.
 */

function deleteBrand( brand_id )
{
    $.ajax({
        url: "/admin/manage/brands/delete",
        data: "brand_id=" + brand_id,
        type: "DELETE",
        success: function ( result )
        {
            if( result == 'true' )
            {
                $("#brand_" + brand_id).css("display", "none") ;
            } else
            {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            }
        }
    });
}