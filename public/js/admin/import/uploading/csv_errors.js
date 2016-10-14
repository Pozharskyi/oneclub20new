/**
 * Created by Home on 14.10.2016.
 */

function getValidatedFile()
{
    var allocationId = $("#allocationId").val();

    window.open('/admin/import/uploading/prepare/errors?allocationId=' + allocationId);

    getUploadingView();
    closePopup2();
}

function getPartyInfo()
{
    var party_id = $("#success_party_id").val();
    getPartyDescription(party_id);

    immediatelyGoBack();
}