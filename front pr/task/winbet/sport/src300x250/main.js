$(document).ready(function(){


        $("#bonus h4").delay(1500).animate({opacity: '0'},{duration:100});
        $("#bonus h4").animate({opacity: '1'},{duration:100});
        $("#bonus h4").delay(1500).animate({opacity: '0'},{duration:100});
        $("#bonus h4").animate({opacity: '1'},{duration:100});
        $("#bonus h4").delay(1500).animate({opacity: '0'},{duration:100});
        $("#new-client h4").delay(5000).animate({opacity: '1'},{duration:100});
 	setInterval(function(){ 
 		$("#new-client h4").animate({opacity: '0'},{duration:100});
        $("#bonus h4").animate({opacity: '1'},{duration:100});
        $("#bonus h4").delay(1500).animate({opacity: '0'},{duration:100});
        $("#bonus h4").animate({opacity: '1'},{duration:100});
        $("#bonus h4").delay(1500).animate({opacity: '0'},{duration:100});
        $("#bonus h4").animate({opacity: '1'},{duration:100});
        $("#bonus h4").delay(1500).animate({opacity: '0'},{duration:100});
        $("#new-client h4").delay(5000).animate({opacity: '1'},{duration:100});
 	}, 8000);
});
$("main").on('click', function(){
     window.location = "#";    
});