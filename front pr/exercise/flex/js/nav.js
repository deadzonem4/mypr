// hide/show top-menu
 $(document).ready(function(){

   $(window).resize(function() {
  if($(window).width() >= 768) { 

    $('.main-menu-container').css('display','flex');
  } });
   $(window).resize(function() {  
    if($(window).width() < 768) { 

      $('.main-menu-container').css('display','none');
  } });

});

/*--------- dropdown menu ------*/
$(document).ready(function(){

  $("#sub>a").removeAttr("href");

  $('#sub>a').click(function(event){
   event.stopPropagation();
    if ($('#sub ul').css('display')== 'block'){
      $('#sub ul').hide();
      $("#sub").addClass("dis");
    }
    else{
      $('#sub ul').show(200);
      $("#sub").removeClass("dis");
    }
   });
  $(window).click(function() {
    if ($('#sub ul').css('display')== 'block'){
      $('#sub ul').hide(200);
      $("#sub").addClass("dis");
    }
  });
  $('#sub ul').click(function(event){
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
