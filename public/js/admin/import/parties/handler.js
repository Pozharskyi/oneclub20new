/**
 * Created by Home on 02.10.2016.
 */

function confirmProduct( file_line, fat_status_id )
{
    var party_id = $("#party_id").val();
    var type = 'confirm';

    $.ajax({
        url: "/admin/import/parties/fat/handler",
        data: "party_id=" + party_id + "&file_line=" + file_line + "&fat_status_id=" + fat_status_id + "&type=" + type,
        type: "PUT",
        success: function ( result )
        {
            if( result == 'true' )
            {
                $(".fat_" + file_line).css("display", "none") ;
            } else
            {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            }
        }
    });
}

function editWithAnother( file_line, fat_status_id ) {

    var party_id = $("#party_id").val();
    var type = 'switch';

    var sku = $("#sku_" + file_line).val();
    var barcode = $("#barcode_" + file_line).val();
    var color = $("#color_" + file_line).val();

    var data = "party_id=" + party_id + "&file_line=" + file_line + "&fat_status_id=" + fat_status_id + "&type=" + type + "&sku=" + sku + "&barcode=" + barcode + "&color=" + color;

    $.ajax({
        url: "/admin/import/parties/fat/handler",
        data: data,
        type: "PUT",
        success: function ( result )
        {
            if( result == 'true' )
            {
                $(".fat_" + file_line).css("display", "none") ;
            } else
            {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            }
        }
    });
}

function sendForWork( file_line, fat_status_id )
{
    var party_id = $("#party_id").val();

    $.ajax({
        url: "/admin/import/parties/fat/work",
        data: "party_id=" + party_id + "&file_line=" + file_line + "&fat_status_id=" + fat_status_id,
        type: "PUT",
        success: function ( result )
        {
            $("#popup_content").html( result );
        }
    });

    getPopup();
}

function editImport( file_line, fat_status_id )
{
    var party_id = $("#party_id").val();

    $.ajax({
        url: "/admin/import/parties/fat/edit",
        data: "party_id=" + party_id + "&file_line=" + file_line + "&fat_status_id=" + fat_status_id,
        type: "PUT",
        success: function ( result )
        {
            $("#popup_content").html( result );
        }
    });

    getPopup();
}

function confirmEditFile()
{
    var data = $("#editForm").serialize();

    var party_id = $("#party_id").val();
    var file_line = $("#file_line").val();

    data += "&type=fix";

    $.ajax({
        url: "/admin/import/parties/fat/handler",
        data: data,
        type: "PUT",
        success: function ()
        {
            changeFatStatus( party_id, 0 );
            closePopup();
        }
    });
}

function sendConfirmation()
{
    var data = $("#workForm").serialize();
    var file_line = $("#file_line").val();

    $.ajax({
        url: "/admin/import/parties/fat/handler",
        data: data,
        type: "PUT",
        success: function ( result )
        {
            if( result == 'true' )
            {
                closePopup();
                $(".fat_" + file_line).css("display", "none") ;
            } else
            {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            }
        }
    });
}

