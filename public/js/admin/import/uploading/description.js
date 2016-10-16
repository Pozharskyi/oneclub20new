/**
 * Created by Home on 14.10.2016.
 */

$("#exportExcel").click(function()
{
    getUploadExport();
});

$("#sendToProd").click(function()
{
    sendToProd();
});

function continueWork()
{
    var party_id = $("#working_party_id").val();

    getPartyDescriptionView( party_id );
    closePopup2();
}

function processWork()
{
    var party_id = $("#working_party_id").val();

    getWaitingView();
    getPopup2();

    $.ajax({
        url: "/admin/import/control/parties",
        data: "party_id=" + party_id,
        type: "POST",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function ( result )
        {
            $("#popup_content2").html(result);
        }
    });
}

function getUploadExport()
{
    var allocationId = $("#allocationId").val();
    window.open('/admin/import/uploading/prepare/errors?allocationId=' + allocationId);
}

function sendToProd()
{
    var message =
        '<div id="alert_status">' +
            '<div class="text-center">' +
                '<h2 class="alert_message">Вы уверены что хотите отправить в Продакшн?</h2>' +
                '<button id="left_btn" onclick="goBack();" class="btn btn-default">Назад</button>' +
                '<button id="right_btn" onclick="confirmToProd();" class="btn btn-primary">Подвердить</button>' +
            '</div>' +
        '</div>';

    $("#popup_content2").html( message );
    getPopup2();
}

function confirmToProd()
{
    var allocationId = $("#allocationId").val();
    var partyId = $("#working_party_id").val();

    getWaitingView();
    getPopup2();

    var message =
        '<div id="alert_status">' +
            '<div class="text-center">' +
                '<h2 class="alert_message">Найдены не обработанные предметы</h2>' +
                '<button id="left_btn" onclick="goBack();" class="btn btn-default">Назад</button>' +
            '</div>' +
        '</div>';

    $.ajax({
        url: "/admin/import/core/validate",
        data: "allocationId=" + allocationId + "&partyId=" + partyId,
        type: "PUT",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function ( result )
        {
            if( result.search(',') != -1 )
            {
                var fields = result.split(',');

                var i = 0;
                var count = fields.length;

                while(i < count)
                {
                    $("#validationRow_" + fields[i]).css("background-color", "red");

                    i++;
                }

                $("#popup_content2").html(message);

            } else {
                $("#popup_content2").html(result);
            }
        }
    });
}