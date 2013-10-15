$(document).ready(function() {

    $('#menu2:has(ul)').click(
            function(e)
            {
                $(this).find('ul').css({display: "block"});
            }
    );

});


