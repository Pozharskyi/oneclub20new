/**
 * Created by Home on 19.08.2016.
 */

function getOptions( event_id ) {

    $("#sequence_result").html('');
    $("#event_id").val( event_id );

    $.ajax({
        url: "/admin/notifications/list/" + event_id,
        data: "csrf_token=91LmJoa82MlA1",
        type: "get",
        success: function( result )
        {
            $("#options_result").html( result );
        }
    });
}

function getNotificationsParams( sequence_id ) {

    $("#sequence_id").val( sequence_id );

    var event_id = $("#event_id").val();

    $.ajax({
        url: "/admin/notifications/options/" + event_id + "/" + sequence_id,
        data: "csrf_token=91LmJoa82MlA1",
        type: "get",
        success: function( result )
        {
            $("#sequence_result").html( result );
        }
    });
}

var sequences = [];

function getCheckboxValues() {

    sequences = [];

    $("input:checkbox[name=sequences]:checked").each(function(){
        sequences.push($(this).val());
    });

    $("#params").val( sequences.join(",") );
}

function saveEvent() {

    getCheckboxValues();

    var sequence_id = $("#sequence_id").val();

    var message_id = $("#message_id_" + sequence_id ).val();
    var event_id = $("#event_id").val();
    var params = $("#params").val();

    $.ajax({
        url: "/admin/notifications/save",
        data: "event_id=" + event_id + "&sequence_id=" + sequence_id + "&message_id=" + message_id + "&params=" + params,
        type: "get",
        success: function()
        {
            window.location.href = '?success=true';
        }
    });
}