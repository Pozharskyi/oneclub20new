/**
 * Created by Home on 14.09.2016.
 */

//$(document).ready(function() {
    var getXsrfToken = function() {
        var cookies = document.cookie.split(';');
        var token = '';

        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i].split('=');
            if(cookie[0] == 'XSRF-TOKEN') {
                token = decodeURIComponent(cookie[1]);
            }
        }

        return token;
    };

    function getSizesByColorAndProduct( product, color )
    {
        $.ajax({
            url: "/list/find/sizes" + "/" + product + "/" + color,
            data: "data=confirm",
            type: "PUT",
            headers: {
                'X-XSRF-TOKEN': getXsrfToken()
            },
            success: function( result )
            {
                $("#sizes_box").html( result );
            }
        });
    }

    function getQuantityForProduct( product, color, size )
    {
        $.ajax({
            url: "/list/find/quantity" + "/" + product + "/" + color + "/" + size,
            data: "data=confirm",
            type: "PUT",
            headers: {
                'X-XSRF-TOKEN': getXsrfToken()
            },
            success: function( result )
            {
                $("#quantity").append( result );
            }
        });
    }

    function deleteQuantityOptionsList()
    {
        var select = $("#quantity");

        select.html('');
        select.append("<option value=''>0</option>");
    }

    //$('input[type=radio][name=color]').change(function()
    //{
    function getProductSizes( color_id )
    {
        var product = $("#pr_oc").val();

        getSizesByColorAndProduct( product, color_id );
        deleteQuantityOptionsList();
    }

    //});

    //$('input[type=radio][name=size]').change(function()
    //{
    function getProductQuantity( size_id )
    {
        var product = $("#pr_oc").val();
        var color = $('input[name=color]:checked').val();

        getQuantityForProduct( product, color, size_id );
    }
    //});
//});