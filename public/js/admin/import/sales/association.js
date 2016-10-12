/**
 * Created by Home on 13.10.2016.
 */

$(document).ready(function()
{
    $(".ta-select").select2({ width: '100%' });
    $(".tp-select").select2({ width: '100%' });
});

function confirmParty()
{
    var data = $("#associationForm").serialize();

    getLoading();

    $.ajax({
        url: "/admin/import/sales/association/confirm",
        data: data,
        type: "PUT",
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