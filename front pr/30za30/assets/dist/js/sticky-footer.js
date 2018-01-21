jQuery(document).ready(function(){
	var header = jQuery('header').outerHeight();
    var footer = jQuery('footer').outerHeight(true);
    var val = header + footer;
    jQuery('main').css('min-height','calc(100vh - '+val+'px)'); 
});