jQuery(document).ready(function($) {
	

	var $grid = $('.post-wrap').masonry({
  itemSelector: '.post-item',
	  percentPosition: true,
	  columnWidth: '.post-sizer',
	  transitionDuration: 400,
	  originLeft: true,
	  stagger: 0
	});

	setTimeout(function () {
		$(".post-thumb img").lazyload({effect: "fadeIn", skip_invisible: true});

		$('.post-thumb img').load(function() {
			$(this).closest('.post-box').addClass('loaded');
			$grid.masonry("layout");
			mobilePostHover();
		});
	}, 500);

	setTimeout(function() {
		$grid.masonry("layout");
		$(window).trigger("scroll");
	}, 1000);

	$(window).resize(function() {
		setTimeout(function() {
			$(window).trigger("scroll");
		}, 1000);

		mobilePostHover();
	});

	$(window).scroll(function(){
		setTimeout(function() {
			$grid.masonry("layout");
			mobilePostHover();
			$(window).trigger("scroll");
		}, 1000);

	});

	function mobilePostHover () {

		if($(window).width() < 660) {
			
				$('.post-item').each(function(i, e) {
					if($(e).offset().top < $(window).scrollTop() + $(window).height() - 200 ) {
						$(e).addClass('hovered');
					}
					else {
						$(e).removeClass('hovered');
					}
				});
		}
		else {
			$('.post-item').removeClass('hovered');
		}
	}
});

