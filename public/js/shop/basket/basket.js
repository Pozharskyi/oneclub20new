/**
 * Created by Home on 30.08.2016.
 */

var getXsrfToken = function() {
    var cookies = document.cookie.split(';');
    var token = '';

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].split('=');
        if(cookie[0] == 'XSRF-TOKEN') {
            token = decodeURIComponent(cookie[1]);
        }
    }

    return token;
};

function deleteItem( item ) {

    $.ajax({
        url: "/list/save/" + item,
        data: "csrf_token=91LmJoa82MlA1",
        type: "DELETE",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function()
        {
            $("#item_" + item).css("display", "none");
        }
    });
}