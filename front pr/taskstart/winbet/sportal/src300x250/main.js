$(document).ready(function(){

 	// function slideAnimate(){ 

  //       $("#content-first").delay(3200).animate({right: '330px'},{duration:600});
  //       $("#content-second").delay(3600).animate({right: '0px'},{duration:600});
  //       $("#content-second").delay(3200).animate({right: '330px'},{duration:600});
  //       $("#content-third").delay(8000).animate({right: '0px'},{duration:600});
  //       $("#content-third").delay(3200).animate({right: '330px'},{duration:600});
  //       $("#content-first").delay(8600).animate({right: '0px'},{duration:600});
 	// };
  //   slideAnimate();

  //   setInterval(function(){ 

  //       $("#content-first").delay(3200).animate({right: '-330px'},{duration:600});
  //       $("#content-second").delay(3600).animate({right: '0px'},{duration:600});
  //       $("#content-second").delay(3200).animate({right: '-330px'},{duration:600});
  //       $("#content-third").delay(8000).animate({right: '0px'},{duration:600});
  //       $("#content-third").delay(3200).animate({right: '-330px'},{duration:600});
  //       $("#content-first").delay(8600).animate({right: '0px'},{duration:600});
  //   },13600);

var myIndex = 0;

function animation() {
    
    var animates = document.querySelectorAll(".animate");
    
    for (var i = 0; i < animates.length; i++) {
       animates[i].style.right = "-330px";  
    }
    myIndex++;
    if (myIndex > animates.length) {myIndex = 1}    
    animates[myIndex-1].style.right = "0"; 
    setTimeout(animation, 5000);
}
animation();
});
$("main").on('click', function(){
     window.location = "#";    
});

