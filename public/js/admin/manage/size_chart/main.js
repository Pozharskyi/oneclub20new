function deleteSizeChart( size_chart_id )
{
    $.ajax({
        url: "/admin/manage/size_chart/delete",
        data: "size_chart_id=" + size_chart_id,
        type: "DELETE",
        success: function ( result )
        {
            if( result == 'true' )
            {
                $("#sizeChart_" + size_chart_id).css("display", "none") ;
                console.log('deleted')
            } else
            {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            }
        }
    });
}