/**
 * Created by Home on 05.09.2016.
 */

var getXsrfToken = function() {
    var cookies = document.cookie.split(';');
    var token = '';

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].split('=');
        while (cookie[0].charAt(0)==' ') cookie[0] = cookie[0].substring(1,cookie[0].length);    //if start with space - remove spaces
        if(cookie[0] == 'XSRF-TOKEN') {
            token = decodeURIComponent(cookie[1]);
        }
    }

    return token;
};

function resetCatalog()
{
    $("input:checkbox").prop('checked', false);

    $("#from_price").val('');
    $("#end_price").val('');
}

function sortCatalog( param, action )
{
    if( param == 'reset' && action == 'reset' )
    {
        resetCatalog();
    }

    var sort = $("#sort").val( param );
    var by = $("#by").val( action );
    var category = $("#category").val();

    if( param == 'default' && action == 'default' )
    {
        param = sort;
        action = by;
    } else
    {
        $("#sort").val( param );
        $("#by").val( action );
    }

    var categories = [];
    var colors = [];
    var sizes = [];

    var from_price = $("#from_price").val();
    var end_price = $("#end_price").val();

    $("input:checkbox[name=categories]:checked").each(function(){
        categories.push($(this).val());
    });

    $("input:checkbox[name=colors]:checked").each(function(){
        colors.push($(this).val());
    });

    $("input:checkbox[name=sizes]:checked").each(function(){
        sizes.push($(this).val());
    });

    var data = "categories=" + categories.join();

    data += "&colors=" + colors.join();
    data += "&sizes=" + sizes.join();
    data += "&from_price=" + from_price;
    data += "&end_price=" + end_price;

    data += "&category=" + category;
    data += "&route=" + $("#route").val();

    $.ajax({
        url: "/sort/null" + "/" + param + "/" + action,
        data: data,
        type: "POST",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function( result )
        {
            $("#catalog_items").html( result );
        }
    });
}

function changeCategory( category_id )
{
    $("#category").val( category_id );

    sortCatalog( 'default', 'default' );
}

function getSub( category_id )
{
    var block = $( "#cat" + category_id );
    var display = block.css( "display" );

    if( display == 'block' )
    {
        block.css( "display", "none" );
    } else
    {
        block.css( "display", "block" );
    }
}