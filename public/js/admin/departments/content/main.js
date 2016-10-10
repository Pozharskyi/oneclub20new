/**
 * Created by Home on 10.10.2016.
 */

function editProduct(subProductId)
{
    $.ajax({
        url: "/admin/departments/content/edit",
        data: "subProductId=" + subProductId,
        type: "PUT",
        success: function ( result )
        {
            getPopup();
            $("#popup_content").html(result);
        }
    });
}

function updateProduct()
{
    var data = $("#editForm").serialize();
    var subProductId = $("#subProductId").val();

    $.ajax({
        url: "/admin/departments/content/edit",
        data: data,
        type: "POST",
        success: function ( result )
        {
            if( result == 'success' ) {
                window.alert('Вы успешно обновили описание продукта.');
                $("#product_" + subProductId).css("display", "none");
            } else {
                window.alert('Что-то пошло не так. Попробуйте чуть позже.');
            }
            closePopup();
        }
    });
}