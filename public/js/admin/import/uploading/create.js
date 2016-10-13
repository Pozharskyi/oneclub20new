/**
 * Created by Home on 13.10.2016.
 */

// HEREBY
function uploadFile()
{
    var form = document.getElementById("formContent");
    var formData = new FormData(form);

    var party_id = $("#party_id").val();

    $.ajax({
        url: "/admin/import/uploading/create",
        type: "POST",
        data: formData,
        mimeTypes:"multipart/form-data",
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function( result ){

            if( result == 'true' )
            {
                getWaitingView();
                getPrepareProcess( party_id );
            } else
            {
                $("#popup_content2").html( result );
            }

            getPopup2();
        }
    });
}

function getPrepareProcess( party_id )
{
    $.ajax({
        url: "/admin/import/uploading/prepare",
        data: "party_id=" + party_id,
        type: "POST",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function ( result )
        {
            $("#popup_content2").html( result );
        }
    });
}

function getConfirmView()
{
    var file = $("#upload").val();

    if( file == '' )
    {
        var message =
            '<div id="alert_status">' +
                '<div class="text-center">' +
                    '<h2 class="alert_message">Нужно выбрать файл загрузки</h2>' +
                    '<button onclick="goBack();" class="btn btn-default">Вернутся</button>' +
                '</div>' +
            '</div>';
    } else
    {
        var message =
            '<div id="alert_status">' +
                '<div class="text-center">' +
                    '<h2 class="alert_message">Потвердите загрузку списка</h2>' +
                    '<button id="left_btn" onclick="goBack();" class="btn btn-default">Отмена</button>' +
                    '<button id="right_btn" onclick="uploadFile();" class="btn btn-primary">Подвердить</button>' +
                '</div>' +
            '</div>';
    }

    $("#popup_content2").html( message );
    getPopup2();
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