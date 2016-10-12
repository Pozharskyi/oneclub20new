/**
 * Created by Home on 12.10.2016.
 */

$( function() {
    $( "#party_start_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#party_end_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
});

function createParty()
{
    var validation = validatePartiesForm();

    if( validation == 0 ) {
        var data = $("#partyCreateForm").serialize();

        getLoading();

        $.ajax({
            url: "/admin/import/parties/create",
            data: data,
            type: "POST",
            headers: {
                'X-XSRF-TOKEN': getXsrfToken()
            },
            success: function ( result )
            {
                getPopup2();
                $("#popup_content2").html( result );
            }
        });

        clearLoading();
    }
}