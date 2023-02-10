$(document).ready(function() {

    // set year for copyright update
    var d = new Date();
    var n = d.getFullYear();
    $("span#year").text(n);
    

    $(window).keydown(function(e) {
        if ((e.metaKey || e.ctrlKey) && e.keyCode == 69) { /*ctrl+e or command+e*/
            e.preventDefault();
            w = $(window).width();
            h = $(window).height();


            $("#popup").css({
                "top": h / 2 - $("#popup").height() / 2,
                "left": w / 2 - $("#popup").width() / 2
            }).fadeIn();
            $("#faded-background").fadeIn();
            return false;
        }
        if (e.keyCode == 27) {
            e.preventDefault();
            $("#popup").hide();
            $("#faded-background").hide();
            console.log("hello");
        }
    });

    $("#faded-background").on("click", function() {
        $("#popup").hide();
        $("#faded-background").hide();
        console.log("clicked");
    });


});

