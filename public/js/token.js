/**
 * Created by Home on 06.10.2016.
 */

var getXsrfToken = function () {
    var cookies = document.cookie.split(';');
    var token = '';

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].split('=');
        if (cookie[0] == 'XSRF-TOKEN') {
            token = decodeURIComponent(cookie[1]);
        }
    }

    return token;
};