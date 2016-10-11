/**
 * Created by Home on 11.10.2016.
 */

function getPopup()
{
    $('#overlay').fadeIn(400, // black layout firstly
        function(){ // after animation
            $('#modal_form')
                .css('display', 'block') // remove display as none
                .animate({opacity: 1, top: '50%'}, 200); // make greater opacity
        }
    );
}

function closePopup()
{
    $('#modal_form')
        .animate({opacity: 0, top: '45%'}, 200,  // opacity to zero and window move to top
            function(){ // пoсле aнимaции
                $(this).css('display', 'none'); // getting display as none
                $('#overlay').fadeOut(400); // hide layout
            }
        );
}