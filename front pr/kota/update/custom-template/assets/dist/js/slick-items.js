$(document).ready(function(){
	$(".slider").slick({
        dots: true,
        autoplay: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
    });

    $('.most-popular .es-listing').slick({
		rows: 2,
		infinite: false,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 3,
		centerPadding: '20px',
		 dots: true,
		responsive: [
		{
			breakpoint: 767,
			settings: {
			slidesToShow: 2,
			slidesToScroll: 2
		}
		},
		{
			breakpoint: 480,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		}
		}
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
    });
});

 

