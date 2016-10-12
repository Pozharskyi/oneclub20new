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

function resetCatalog()
{
    var current = $("#current").val();

    if(current == 'self') {
        var user_id = $("#user_id").val();
        getParties(user_id);
    } else if(current == 'parties') {
        getParties('');
    } else if(current == 'sales') {
        getSales();
    }
}

function forceGoBack()
{
    resetCatalog();
    closePopup2();
    closePopup();
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

    $("#tp_deletion").click(function()
    {
        getPopup();
        getPartyDeleteView();
    });
});

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

function getPartyDeleteView()
{
    getLoading();
    var party_id = $("#party_id").val();

    $.ajax({
        url: "/admin/import/parties/delete",
        data: "party_id=" + party_id,
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

function makeActive( party_id )
{
    $('.row_tr').removeClass('row_active');
    $("#row_" + party_id).addClass('row_active');

    $("#party_id").val(party_id);
}