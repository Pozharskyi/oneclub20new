/**
 * Created by Home on 12.10.2016.
 */

function getLoading()
{
    $("#loading").css("display", "block");
}

function clearLoading()
{
    $("#loading").css("display", "none");
}

$(document).ready(function() {
    var user_id = $("#user_id").val();
    var current = $("#current");

    getParties(user_id);

    $("#myParties").click(function()
    {
        $("#current").val('self');
        getParties(user_id);
    });

    $("#allParties").click(function()
    {
        $("#current").val('parties');
        getParties('');
    });

    $("#allSales").click(function()
    {
        $("#current").val('sales');
        getSales();
    });

    $("#tp_creation").click(function()
    {
        getPopup();
        getPartyCreateView();
    });
});
//{

    function getParties(group)
    {
        getLoading();

        $.ajax({
            url: "/admin/import/parties/search/" + group,
            data: "",
            type: "PUT",
            headers: {
                'X-XSRF-TOKEN': getXsrfToken()
            },
            success: function ( result )
            {
                $("#result").html( result );
            }
        });

        clearLoading();
    }

    function getSales()
    {
        getLoading();

        $.ajax({
            url: "/admin/import/sales/search",
            data: "",
            type: "PUT",
            headers: {
                'X-XSRF-TOKEN': getXsrfToken()
            },
            success: function ( result )
            {
                $("#result").html( result );
            }
        });

        clearLoading();
    }

    function getPartyCreateView()
    {
        getLoading();

        $.ajax({
            url: "/admin/import/parties/create",
            data: "",
            type: "PUT",
            headers: {
                'X-XSRF-TOKEN': getXsrfToken()
            },
            success: function ( result )
            {
                $("#popup_content").html( result );
            }
        });

        clearLoading();
    }
//});