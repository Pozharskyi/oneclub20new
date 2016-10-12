/**
 * Created by Home on 12.10.2016.
 */

$(document).ready(function()
{
    var user_id = $("#user_id").val();

    function getLoading()
    {
        $("#loading").css("display", "block");
    }

    function clearLoading()
    {
        $("#loading").css("display", "none");
    }

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

    $("#myParties").click(function()
    {
        getParties(user_id);
    });

    $("#allParties").click(function()
    {
        getParties('');
    });

    $("#allSales").click(function()
    {
        getSales();
    });

    getParties(user_id);
});