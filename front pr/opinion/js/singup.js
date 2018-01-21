jQuery(document).ready(function($) {

		var args = {
			speed: 800,
			initialSlide: 1,
			onSlideChangeStart: function (slider) {
			$('.singup-nav li.active').removeClass('active');
			$('.singup-nav li').eq(slider.activeIndex).addClass('active');
		}
		}, singupSlider = new Slider($('.singup-slider'), args);

		$('.singup-nav a').click(function() {
			var li = $(this).parent(),
				  index = li.index();

			if(!li.hasClass('active')) {
				singupSlider.slideTo(index);
				$('.singup-nav li.active').removeClass('active');
				li.addClass('active');
			}
			return false;
		});
});
