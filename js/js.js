$(document).ready(function() {

    // set year for copyright update
    var d = new Date();
    var n = d.getFullYear();
    $("span#year").text(n);

    //gets the value for hiding the BYU bar
    var navStart = $("nav").position();
    var navAboveHeight = $("nav").outerHeight();
    var aboveHeight = $("header").outerHeight() - navAboveHeight;


    //scrolling function
    $(window).scroll(function() {
        if ($(window).scrollTop() > navAboveHeight) {
            var newAboveHeight = 0;
            $("nav").css({ "position": "fixed", "top": newAboveHeight, "background-color": "rgba(70, 162, 222, 1)" });
            $("article").css({ "margin-top": $("#level-nav-container").outerHeight() });
        } else {
            $("nav").css({ "position": "absolute", "top": navStart.top, "background-color": "rgba(70, 162, 222, 0.7)" });
            $("article").css({ "margin-top": 0 });
        }
        if ($(window).scrollTop() > aboveHeight) {
            var newAboveHeight = 0;
            $("#level-nav-container").css({ "position": "fixed", "top": navAboveHeight });
            $("article").css({ "margin-top": $("#level-nav-container").outerHeight() });
        } else {


            $("#level-nav-container").css({ "position": "relative", "top": "0" });
            $("article").css({ "margin-top": 0 });


        }
        //hides scroll up button
        if ($(window).scrollTop() > aboveHeight + $("#introduction").outerHeight()) { $("#scrolly").show() } else { $("#scrolly").hide(); }

    });

});


// this function does the smooth scrolling

$(function() {
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {

                //  if ($("#byu-bar").is(":visible")) {scrollChange = $("header").outerHeight()*3.;} else {


                $('html,body').animate({
                    scrollTop: target.offset().top - $("#level-nav").innerHeight() - $("#nav-bar").innerHeight()
                }, 1000);

                return false;
            }
        }
    });
});