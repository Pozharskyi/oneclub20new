/**
 * Created by Home on 07.10.2016.
 */

function clearResultView()
{
    $("#results").html('');
}

function getParties( supplier_id )
{
    var party = $("#party");

    $.ajax({
        url: "/admin/import/parties/stats/parties",
        data: "supplier_id=" + supplier_id,
        type: "PUT",
        success: function ( result )
        {
            party.html('');
            party.html('<option>Выберите товарную партию</option>');
            party.append( result );
        }
    });

    clearResultView();
}

function getPartyDescription( party_id )
{
    $.ajax({
        url: "/admin/import/parties/stats/info/" + party_id,
        data: "for=admin",
        type: "PUT",
        success: function ( result )
        {
            $("#results").html( result );
        }
    });

}