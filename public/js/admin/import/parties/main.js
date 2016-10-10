/**
 * Created by Home on 26.09.2016.
 */

function deleteParty( party_id )
{
    $.ajax({
        url: "/admin/import/parties/delete",
        data: "party_id=" + party_id,
        type: "DELETE",
        success: function( result )
        {
            if( result == 'true')
            {
                $("#party_" + party_id).css("display", "none");
                $("#result_row").html(
                    '<div style="margin-top: -22px;">' +
                        '<div class="alert alert-success">' +
                            '<strong>Успех!</strong> Вы успешно удалили товарную партию.' +
                        '</div>' +
                    '</div>');
            } else
            {
                $("#result_row").html(
                    '<div style="margin-top: -22px;">' +
                    '<div class="alert alert-danger">' +
                    '<strong>Ошибка!</strong> Удаление данной партии в текущее время не доступно. Попробуйте позже' +
                    '</div>' +
                    '</div>');
            }

            $("html, body").animate({
                scrollTop: 0
            }, 600);
        }
    });
}