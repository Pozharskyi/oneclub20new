/**
 * Created by Home on 13.10.2016.
 */

$("#formContent").submit(function(e){
    e.preventDefault();

    var formdata = new FormData(this);

    $.ajax({
        url: "/admin/import/uploading/upload",
        type: "POST",
        data: formdata,
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
                getPrepareProcess();
            } else
            {
                $("#popup_content2").html( result );
            }

            getPopup2();
        }
    });
});

function getPrepareProcess()
{

}

function getWaitingView()
{
    var message = '<div id="alert_status">' +
                        '<div class="text-center">' +
                            '<h2 class="alert_message">Ожидайте, скоро все будет готово...</h2>' +
                            '<img src="/images/import/loading.gif" />' +
                        '</div>' +
                  '</div>';

    $("#popup_content2").html( message );
}