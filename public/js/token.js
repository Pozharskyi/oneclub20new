/**
 * Created by Home on 06.10.2016.
 */

var getXsrfToken = function () {
    var cookies = document.cookie.split(';');
    var token = '';

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].split('=');
        while (cookie[0].charAt(0)==' ') cookie[0] = cookie[0].substring(1,cookie[0].length);    //if start with space - remove spaces
        if (cookie[0] == 'XSRF-TOKEN') {
            token = decodeURIComponent(cookie[1]);
        }
    }

    return token;
};