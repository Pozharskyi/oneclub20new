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

}