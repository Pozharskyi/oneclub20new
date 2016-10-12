/**
 * Created by Home on 12.10.2016.
 */

$( function() {
    $( "#sale_start_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#sale_end_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
});

function editSale()
{
    var validation = validateSalesForm();

    if( validation == 0 ) {
        var data = $("#saleEditForm").serialize();
        console.log(data);

        getLoading();

        $.ajax({
            url: "/admin/import/sales/edit",
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