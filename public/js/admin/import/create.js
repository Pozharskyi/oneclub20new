/**
 * Created by Home on 12.10.2016.
 */

$( function() {
    $( "#party_start_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#party_end_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
});

function forceGoBack()
{
    resetCatalog();
    closePopup2();
    closePopup();
}

function validateForm()
{
    var fields = [
        'party_name', 'import_supplier_id',
        'buyer_id', 'support_id',
        'party_start_date', 'party_end_date',
    ];

    var i = 0;
    var count = fields.length;

    var error = 0;

    while(i < count) {

        var item = $("#" + fields[i]).val();

        if( item == '' ) {
            error = 1;
            $("#invalid_" + fields[i]).html('Поле должно быть заполненым');
        } else {
            $("#invalid_" + fields[i]).html('');
        }

        i++;
    }

    return error;
}

function createParty()
{
    var validation = validateForm();

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

function resetCatalog()
{
    var current = $("#current").val();

    if(current == 'self') {
        var user_id = $("#user_id").val();
        getParties(user_id);
    } else if(current == 'parties') {
        getParties('');
    } else if(current == 'sales') {
        getSales();
    }
}