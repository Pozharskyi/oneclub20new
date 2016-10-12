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
        getPartyCreateView();
    });

    $("#tp_deletion").click(function()
    {
        getPartyDeleteView();
    });

    $("#tp_edit").click(function()
    {
        getPartyEditView();
    });

    $("#ta_creation").click(function()
    {
        getSaleCreateView();
    });

    $("#ta_edition").click(function()
    {
        getSaleEditView();
    });

    $("#ta_deletion").click(function()
    {
        getSaleDeleteView();
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
            getPopup();
            $("#popup_content").html( result );
        }
    });

    clearLoading();
}

function getSaleCreateView()
{
    getLoading();

    $.ajax({
        url: "/admin/import/sales/create",
        data: "",
        type: "PUT",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function ( result )
        {
            getPopup();
            $("#popup_content").html( result );
        }
    });

    clearLoading();
}

function getPartyDeleteView()
{
    getLoading();
    var party_id = $("#party_id").val();

    if( party_id != '' ) {
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
                getPopup();
            }
        });
    } else {
        getErrorMessage('TP');
    }

    clearLoading();
}

function getPartyEditView()
{
    getLoading();
    var party_id = $("#party_id").val();

    if( party_id != '' ) {
        $.ajax({
            url: "/admin/import/parties/edit",
            data: "party_id=" + party_id,
            type: "PUT",
            headers: {
                'X-XSRF-TOKEN': getXsrfToken()
            },
            success: function ( result )
            {
                getPopup();
                $("#popup_content").html( result );
            }
        });
    } else {
        getErrorMessage('TP');
    }

    clearLoading();
}

function getSaleEditView()
{
    getLoading();
    var sale_id = $("#sale_id").val();

    if( sale_id != '' ) {
        $.ajax({
            url: "/admin/import/sales/edit",
            data: "sale_id=" + sale_id,
            type: "PUT",
            headers: {
                'X-XSRF-TOKEN': getXsrfToken()
            },
            success: function ( result )
            {
                getPopup();
                $("#popup_content").html( result );
            }
        });
    } else {
        getErrorMessage('TA');
    }

    clearLoading();
}

function getSaleDeleteView()
{
    getLoading();
    var sale_id = $("#sale_id").val();

    if( sale_id != '' ) {
        $.ajax({
            url: "/admin/import/sales/delete",
            data: "sale_id=" + sale_id,
            type: "PUT",
            headers: {
                'X-XSRF-TOKEN': getXsrfToken()
            },
            success: function ( result )
            {
                $("#popup_content").html( result );
                getPopup();
            }
        });
    } else {
        getErrorMessage('TA');
    }

    clearLoading();
}

function getErrorMessage( category )
{
    var cat = '';

    if( category == 'TA' )
    {
        cat = 'товарную акцию'
    } else
    {
        cat = 'товарную партию';
    }

    var message = '<div id="alert_status">' +
                    '<div class="text-center">' +
                        '<h2 class="alert_message">Выберите ' + cat + ' для продолжения</h2>' +
                        '<button onclick="closePopup3();" class="btn btn-success">Вернутся обратно</button>' +
                    '</div>' +
               '</div>';

    $("#popup_content3").html(message);
    getPopup3();
}

function makePartyActive( party_id )
{
    var row = $("#row_" + party_id);
    var party = $("#party_id");
    $('.row_tr').removeClass('row_active');

    var prev_row = party.val();
    if( party_id == prev_row ) {
        row.removeClass('row_active');
        party.val('');
    } else {
        row.addClass('row_active');
        party.val(party_id);
    }
}

function makeSaleActive( sale_id )
{
    var row = $("#row_" + sale_id);
    var sale = $("#sale_id");
    $('.row_tr').removeClass('row_active');

    var prev_row = sale.val();
    if( sale_id == prev_row ) {
        row.removeClass('row_active');
        sale.val('');
    } else {
        row.addClass('row_active');
        sale.val(sale_id);
    }
}

function validatePartiesForm()
{
    var fields = [
        'party_name', 'import_supplier_id',
        'buyer_id', 'support_id',
        'party_start_date', 'party_end_date'
    ];

    var i = 0;
    var count = fields.length;

    var error = 0;

    while(i < count) {

        var item = $("#" + fields[i]).val();

        if( item == '' ) {
            error = 1;
            $("#invalid_" + fields[i]).html('Поле должно быть заполненым');
        } else {
            $("#invalid_" + fields[i]).html('');
        }

        i++;
    }

    return error;
}

function validateSalesForm()
{
    var fields = [
        'sale_name', 'sale_start_date',
        'sale_end_date', 'buyer_id'
    ];

    var i = 0;
    var count = fields.length;

    var error = 0;

    while(i < count) {

        var item = $("#" + fields[i]).val();

        if( item == '' ) {
            error = 1;
            $("#invalid_" + fields[i]).html('Поле должно быть заполненым');
        } else {
            $("#invalid_" + fields[i]).html('');
        }

        i++;
    }

    return error;
}