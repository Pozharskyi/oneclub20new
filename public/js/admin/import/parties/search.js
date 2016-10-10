/**
 * Created by Home on 26.09.2016.
 */

function search()
{
    var id = $("#id").val();
    var party_name = $("#party_name").val();
    var supplier_id = $("#supplier_id").val();
    var made_by = $("#made_by").val();

    var recommended_start = $("#recommended_start").val();
    var recommended_end = $("#recommended_end").val();

    var data = "id=" + id + "&party_name=" + party_name + "&supplier_id=" + supplier_id + "&made_by=" + made_by + "&recommended_start" + recommended_start + "&recommended_end=" + recommended_end;

    $.ajax({
        url: "/admin/import/parties/search",
        data: data,
        type: "PUT",
        success: function ( result )
        {
            $("#search_result").html( result );

            $("html, body").animate({
                scrollTop: document.body.scrollHeight
            }, 600);
        }
    });
}