/**
 * Created by Home on 30.08.2016.
 */

function reserveBack( basket_id )
{
    var quantity = $("#quantity_" + basket_id).val();

    $.ajax({
        url: "/list/reserve/item/" + basket_id,
        data: "quantity=" + quantity,
        type: "POST",
        dataType: "json",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function( result )
        {
            $("#quantity_" + basket_id).val( result.items );

            makeAlertFromReverse( result.message );
            countdown( 'counter_' + basket_id, 19, 59, basket_id );
        }
    });
}

function makeAlertFromReverse( message )
{
    $("#validation").html(
        '<div class="alert alert-danger">' +
            message
        + '</div>');
}

function countdown(element, minutes, seconds, basket_id) {
    // Fetch the display element
    var el = document.getElementById(element);

    // Set the timer
    var interval = setInterval(function() {
        if(seconds == 0) {
            if(minutes == 0) {
                (el.innerHTML = "<button class='btn btn-primary' onclick='reserveBack(" + basket_id + ");'>Вернуть в резерв</button>");

                clearInterval(interval);
                return;
            } else {
                minutes--;
                seconds = 60;
            }
        }

        if(seconds < 10) {
            var seconds_text = '0' + seconds;
        } else {
            var seconds_text = seconds;
        }

        el.innerHTML = 'Reserved for ' + minutes + ':' + seconds_text;
        seconds--;
    }, 1000);
}

var parsed_json;

function getTimerData() {

    $.ajax({
        url: "/basket/timers",
        data: "csrf_token=91LmJoa82MlA1",
        type: "get",
        success: function( result )
        {
            parsed_json = JSON.parse( result );
        },
        async: false
    });
}

function makeTimers() {

    var timestamps = $.map(parsed_json, function(value, index) {
        return [value];
    });

    var ids = $.map(parsed_json, function(value, index) {
        return [index];
    });

    var i = 0;
    var count = timestamps.length;

    while( i < count ) {

        var time = timestamps[i];
        var id = ids[i];

        var minutes = 0;
        var seconds = 0;

        if( time != 0 ) {
            minutes = Math.floor( time / 60 );
            seconds = time % 60;
        }

        countdown('counter_' + id, minutes, seconds, id);

        i++;
    }
}

getTimerData();
makeTimers();