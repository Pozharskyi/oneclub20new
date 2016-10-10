/**
 * Created by Home on 04.10.2016.
 */

function search()
{
    var id = $("#id").val();
    var update_name = $("#update_name").val();
    var made_by = $("#made_by").val();
    var recommended_start = $("#recommended_start").val();

    var data = "id=" + id + "&update_name=" + update_name + "&made_by=" + made_by + "&recommended_start" + recommended_start;

    $.ajax({
        url: "/admin/import/update/search",
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