$(document).ready(function(){
    var header = $('header').outerHeight();
    var footer = $('footer').outerHeight();
    var val = header + footer;
    $('main').css('min-height','calc(100vh - '+val+'px)');
});

