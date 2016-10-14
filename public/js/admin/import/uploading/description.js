/**
 * Created by Home on 14.10.2016.
 */

$("#batchProcessor").click(function()
{
    processWork();
});

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

}

function getUploadExport()
{
    var allocationId = $("#allocationId").val();
    window.open('/admin/import/uploading/prepare/errors?allocationId=' + allocationId);
}

function sendToProd()
{

}