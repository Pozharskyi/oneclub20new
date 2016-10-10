/**
 * Created by Home on 10.10.2016.
 */

function editProduct(subProductId)
{
    $.ajax({
        url: "/admin/departments/photography/edit",
        data: "subProductId=" + subProductId,
        type: "PUT",
        success: function ( result )
        {
            getPopup();
            $("#popup_content").html(result);
        }
    });
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        var id = input.id;
        var arr = id.split("_");
        $("#src_" + arr[1]).val('changed');

        reader.onload = function (e) {
            $('#img_' + arr[1]).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function uploadImage(i)
{
    $("#file_" + i).click();
}

function deleteImage(i)
{
    $("#img_" + i).attr("src", "#");
    $("#src_" + i).val('');
    $("#oldSrc_" + i).val('');
    $("#file_" + i).val('');
}