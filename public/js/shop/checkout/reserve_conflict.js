/**
 * Created by Home on 16.09.2016.
 */

function getPopup()
{
    $('#overlay').fadeIn(400, // снaчaлa плaвнo пoкaзывaем темную пoдлoжку
        function(){ // пoсле выпoлнения предъидущей aнимaции
            $('#modal_form')
                .css('display', 'block') // убирaем у мoдaльнoгo oкнa display: none;
                .animate({opacity: 1, top: '50%'}, 200); // плaвнo прибaвляем прoзрaчнoсть oднoвременнo сo съезжaнием вниз
        }
    );
}

function closePopup()
{
    $('#modal_form')
        .animate({opacity: 0, top: '45%'}, 200,  // плaвнo меняем прoзрaчнoсть нa 0 и oднoвременнo двигaем oкнo вверх
            function(){ // пoсле aнимaции
                $(this).css('display', 'none'); // делaем ему display: none;
                $('#overlay').fadeOut(400); // скрывaем пoдлoжку
            }
        );
}

function validateProducts( user_unique_token )
{
    $.ajax({
        url: "/list/reserve/validation/" + user_unique_token,
        data: "csrf_token=91LmJoa82MlA1",
        type: "PUT",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function( result )
        {
            if( result != 'true' )
            {
                $("#popup_content").html( result );
                getPopup();
            } else
            {
                window.location.href = '/checkout';
            }
        }
    });
}

function deleteItem( item_id )
{
    dropBasketItem( item_id );
    $("#sub_item_" + item_id).css( "display", "none" );

    var conflicts_count = $("#conflicts_count").val();
    var result = conflicts_count - 1;

    if( result == 0 )
    {
        window.location.href= '/checkout';
    }
}

function resolveConflict()
{
    var data = $("#conflict_form").serialize();
    var user_id = $("#xs-user-token").val();

    $.ajax({
        url: "/checkout/conflict/" + user_id,
        data: data,
        type: "POST",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function( result )
        {
            if( result !== 'true' )
            {
                validateProducts( result );
            } else
            {
                window.location.href = '/checkout';
            }
        }
    });
}