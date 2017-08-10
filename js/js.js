$(document).ready(function() {

// set year for copyright update
	var d = new Date();
	var n = d.getFullYear();
	$("span#year").text(n);

//gets the value for hiding the BYU bar
var aboveHeight = $("header").outerHeight();

//scrolling function
	$(window).scroll(function(){

		if ($(window).scrollTop() > aboveHeight){


			var newAboveHeight = 0;
			$("#level-nav").css({"position" : "fixed", "top" : newAboveHeight});
			$("article").css({"margin-top":$("#level-nav").outerHeight()});

		}
		else {


			$("#level-nav").css({"position" : "relative", "top": "0"});
			$("article").css({"margin-top":0});


		}
		//hides scroll up button
		if ($(window).scrollTop() > aboveHeight + $("#introduction").outerHeight())
			{$("#scrolly").show()}
		else {$("#scrolly").hide();}

	});

$("a#teacher-login, a#login-link").on("click", login_popup);
$("#faded-background").on("click", close_popup);

$("div.content-background").filter(":odd").css('background-color', '#f7f9fb');
});


// this function does the smooth scrolling

$(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {

      //  if ($("#byu-bar").is(":visible")) {scrollChange = $("header").outerHeight()*3.;} else {
			

        $('html,body').animate({
          scrollTop: target.offset().top-$("#level-nav").innerHeight()
        }, 1000);

        return false;
      }
    }
  });
});

function login_popup() {
	w=$(window).width();
	h=$(window).height();
	$("#faded-background").css({"width" : w+"px", "height": h+"px"}).fadeIn();
	$("#login_popup").css({"top": h/2-200, "left":w/2-150}).fadeIn();
}

function close_popup() {
	$(".popup, #faded-background").fadeOut();

}
