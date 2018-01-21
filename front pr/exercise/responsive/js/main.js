// hide/show top-menu
 $(document).ready(function(){

   $(window).resize(function() {
  if($(window).width() >= 768) { 

    $('.main-menu-container').css('display','block');
  } });
   $(window).resize(function() {  
    if($(window).width() < 768) { 

      $('.main-menu-container').css('display','none');
  } });

});

/*--------- dropdown menu ------*/
$(document).ready(function(){

  $("#menu-item>a").removeAttr("href");

  $('#menu-item>a').click(function(event){
   event.stopPropagation();
    if ($('#menu-item ul').css('display')== 'block'){
      $('#menu-item ul').hide();
    }
    else{
      $('#menu-item ul').show(200);
    }
   });


  $(window).click(function() {
    if ($('#menu-item ul').css('display')== 'block'){
      $('#menu-item ul').hide(200);
    }
  });

  $('#menu-item ul').click(function(event){
    event.stopPropagation();
  });


  $('.hamburger').click(function(){
    if ($('.main-menu-container').css('display')== 'block'){
      $('.main-menu-container').hide(200);
    }
    else{
      $('.main-menu-container').show(200);
    }
  });
});
/* -------- clicked menus styles --------*/
 $(document).ready(function(){
    $( ".main-menu>li>a" ).each(function() {
      if( $(this).attr("href") == window.location.href){
        $(this).css({"border-bottom": "2px solid #FFF", "text-decoration":"none"});    
      }
    });
  });
/*------------Slider------------*/
 $(document).ready(function(){
      $(".slider").slick({
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        centerMode: true,
        centerPadding: '10px',
        variableWidth: true
      });
  });