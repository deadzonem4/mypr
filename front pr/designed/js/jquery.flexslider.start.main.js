jQuery(window).load(function() {
/*global jQuery:false */
"use strict";
	
  jQuery('.mainflex').flexslider({
	animation: "fade",
	slideshow: true,                //Boolean: Animate slider automatically
	slideshowSpeed: 11000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
	animationDuration: 600,
	smoothHeight: false,
	useCSS: false,
	pauseOnHover: true,
	controlNav: true,
	directionNav: true,
	manualControls: ".slide-nav li",
	prevText: "", 
	nextText: "",
	start: function(slider) {
  		slider.removeClass('loading');
		}
    });
  
});