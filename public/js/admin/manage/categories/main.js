function deleteCategory( category_id )
{
    $.ajax({
        url: "/admin/manage/categories/delete",
        data: "category_id=" + category_id,
        type: "DELETE",
        success: function ( result )
        {
            if( result == 'true' )
            {
                $("#category_" + category_id).css("display", "none") ;
            } else
            {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            }
        }
    });
}