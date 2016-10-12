/**
 * Created by Home on 12.10.2016.
 */

function deleteParty()
{
    var data = $("#partyDeleteForm").serialize();

    getLoading();

    $.ajax({
        url: "/admin/import/parties/delete",
        data: data,
        type: "DELETE",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function ( result )
        {
            getPopup2();
            $("#popup_content2").html( result );
        }
    });

    clearLoading();
}