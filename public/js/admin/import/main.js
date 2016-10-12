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

function getPopup2()
{
    $('#overlay2').fadeIn(400, // black layout firstly
        function(){ // after animation
            $('#modal_form2')
                .css('display', 'block') // remove display as none
                .animate({opacity: 1, top: '50%'}, 200); // make greater opacity
        }
    );
}

function closePopup2()
{
    $('#modal_form2')
        .animate({opacity: 0, top: '45%'}, 200,  // opacity to zero and window move to top
            function(){ // пoсле aнимaции
                $(this).css('display', 'none'); // getting display as none
                $('#overlay2').fadeOut(400); // hide layout
            }
        );
}

function getPopup3()
{
    $("#modal_form3").css({"background": "#fff", "overflow-y": "visible"});

    $('#overlay3').fadeIn(400, // black layout firstly
        function(){ // after animation
            $('#modal_form3')
                .css('display', 'block') // remove display as none
                .css('background', 'none')
                .css('overflow-y', 'hidden')
                .animate({opacity: 1, top: '50%'}, 200); // make greater opacity
        }
    );
}

function closePopup3()
{
    $('#modal_form3')
        .animate({opacity: 0, top: '45%'}, 200,  // opacity to zero and window move to top
            function(){ // пoсле aнимaции
                $(this).css('display', 'none'); // getting display as none
                $('#overlay3').fadeOut(400); // hide layout
            }
        );
}

function filterFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    div = document.getElementById("importMenu");
    a = div.getElementsByTagName("a");
    var k = 0;
    for (i = 0; i < a.length; i++) {
        if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
            k++;
        }
    }

    if(k == a.length) {
        $(".none_found").css("display", "block");
    } else {
        $(".none_found").css("display", "none");
    }
}