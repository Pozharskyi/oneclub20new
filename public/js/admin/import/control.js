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

function removeActiveLink()
{
    $(".super_link").removeClass('active_link');
}

function handleActive( category, id )
{
    removeActiveLink();

    if(category == 'parties')
    {
        $("#parties_" + id).addClass('active_link');
    }

    if(category == 'sales')
    {
        $("#sales_" + id).addClass('active_link');
    }
}

function getPartyDescription( party_id )
{
    if($("#nav").find("#tp_" + party_id).length == 0)
    {
        var html = '<li class="sub_nav" id="tp_' + party_id + '">'
                     + '<a id="parties_' + party_id + '" onclick="getPartyDescription(' + party_id + ')" ' +
                        'class="super_link" href="#">' +
                            'ТП #' + party_id +
                       '</a>'
                     + '<a href="#" onclick="closePartyLink(' + party_id + ');">' +
                          '<img src="/images/import/close.png" class="close" />' +
                       '</a>' +
                   '</li>';

        $("#nav").append(html);
    }

    getPartyDescriptionView( party_id );
}

function getPartyDescriptionView( party_id )
{
    handleActive('parties', party_id);

    getLoading();

    $.ajax({
        url: "/admin/import/parties/description",
        data: "party_id=" + party_id,
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

function getSaleDescription( sale_id )
{
    if($("#nav").find("#ta_" + sale_id).length == 0)
    {
        var html = '<li class="sub_nav" id="ta_' + sale_id + '">'
                     + '<a id="sales_' + sale_id + '" onclick="getSaleDescription(' + sale_id + ')" ' +
                        'class="super_link" href="#">ТA #' + sale_id + '</a>'
                     + '<a href="#" onclick="closeSaleLink(' + sale_id + ');">' +
                           '<img src="/images/import/close.png" class="close" />' +
                       '</a>' +
                   '</li>';

        $("#nav").append(html);
    }

    getSaleDescriptionView(sale_id);
}

function getSaleDescriptionView( sale_id )
{
    handleActive('sales', sale_id);
}

function closePartyLink( party_id )
{
    $("#tp_" + party_id).remove();
    getParties('');
}

function closeSaleLink( sale_id )
{
    $("#ta_" + sale_id).remove();
    getSales();
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

function goBackWithReload()
{
    getUploadingView();
    closePopup2();
}

function goBack()
{
    closePopup2();
}

function immediatelyGoBack()
{
    closePopup2();
    closePopup();
}

function getWaitingView()
{
    var message =
        '<div id="alert_status">' +
            '<div class="text-center">' +
                '<h2 class="alert_message">Ожидайте, скоро все будет готово...</h2>' +
                '<img style="margin-top: 15px;" src="/images/import/loading.gif" />' +
            '</div>' +
        '</div>';

    $("#popup_content2").html( message );
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

    $("#linking").click(function()
    {
        getAssociationView();
    });

    $("#uploading").click(function()
    {
        getUploadingView();
    });
});

function removeActive()
{
    $("#party_id").val('');
    $("#sale_id").val('');
}

function getParties(group)
{
    removeActiveLink();
    removeActive();

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
    removeActiveLink();
    removeActive();

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

function getUploadingView()
{
    getLoading();
    var party_id = $("#party_id").val();

    if( party_id != '' ) {
        $.ajax({
            url: "/admin/import/uploading/create",
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

function getAssociationView()
{
    getLoading();

    $.ajax({
        url: "/admin/import/sales/association",
        data: "",
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

    if(!row.hasClass('deleted'))
    {
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

function getDescriptionRow() {
    var primaryRow = $("#primary_desc");
    var desc = $("#desc");

    primaryRow.removeClass('col-md-12');
    primaryRow.addClass('col-md-8');

    desc.addClass('col-md-4');
    desc.css("display", "block");
}

function hideDescriptionRow()
{
    var primaryRow = $("#primary_desc");
    var desc = $("#desc");

    primaryRow.removeClass('col-md-8');
    primaryRow.addClass('col-md-12');

    desc.removeClass('col-md-4');
    desc.css("display", "none");
}

function getDescription( fileLine )
{
    var allocationId = $("#allocationId").val();

    getLoading();

    $.ajax({
        url: "/admin/import/uploading/allocation/row",
        data: "allocationId=" + allocationId + "&fileLine=" + fileLine,
        type: "POST",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function ( result )
        {
            $("#desc").html(result);
            getDescriptionRow();
        }
    });

    clearLoading();
}

function confirmDescription()
{
    getWaitingView();
    getPopup2();

    var data = $("#descForm").serialize();

    var allocationId = $("#allocationId").val();
    var filePath = $("#filePath").val();
    var partyId = $("#working_party_id").val();

    data += "&allocationId=" + allocationId + "&filePath=" + filePath + "&partyId=" + partyId;

    getLoading();

    console.log(data);

    $.ajax({
        url: "/admin/import/core/product",
        data: data,
        type: "POST",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function ( result )
        {
            $("#popup_content2").html(result);
            setTimeout(function() {
                closePopup2();
            }, 650);
        }
    });

    clearLoading();
}