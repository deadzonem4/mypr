jQuery(document).ready(function($) {

		windowsWidth();
		collapseCategories();

		$(window).load(function() {
			if ($('.choose-interests-popup').length) {
				$('.choose-interests-popup').mCustomScrollbar();
			}
		});
		
		$(window).resize(function() {
			windowsWidth();
	    collapseCategories();
	    if(windowsWidth() <= 767) {
				$('.categories.cat_opened').removeClass('cat_opened');
				$('.categories .icon, .categories .title, .sub-cat, .cat-menu').removeAttr('style');
				$('.cat-menu li.active').removeClass('active');
				$('.cat-menu li.opened').removeClass('opened');
	    }
		});

		$('.sub-cat a').click(function() {
			$(this).parent().toggleClass('active');
			return false;
		});

		// $('.sub-cat > li .title, .sub-cat > li .icon').each(function(i, li) {
		// 	$(li).css({
		// 		"-webkit-transition-delay": 0.3 * i + 'ms',
		// 		"transition-delay": 0.3 * i + 'ms'
		// 	});
		// });

		function collapseCategories () {
				
				$('.categories a[data-action="tab"]').unbind('click');
				$('.categories a[data-action="tab"]').bind('click', function() {

					if( $('li.inactive').length ) {
						console.log('hui');
						return false;
					}


					if(windowsWidth() > 767) {
			
						var $this = $(this),
								parent_li = $this.parent(),
								children_li = parent_li.find('li'),
								children_li_length = children_li.length,
								parent_ul = $this.parents('.cat-menu'),
								cat_row = $this.parents('.categories'),
								delay_ms = 300,
								all_delay = children_li_length * delay_ms;

						if(cat_row.hasClass('cat_opened')) {
							if(parent_li.hasClass('active')) {
								parent_li.addClass('inactive');
								parent_li.removeClass('opened');
								setTimeout(function () {
									parent_li.removeClass('active');
									cat_row.removeClass('cat_opened');
									parent_ul.css('margin-bottom', 0);
								}, all_delay);

								setTimeout(function () {
									parent_li.find('ul.sub-cat').css('visibility', 'hidden');
									parent_li.removeClass('inactive');
								}, all_delay + 1000);
							}
							else {
								var opened_active = cat_row.find('li.active'),
										opened_ul = opened_active.parent(),
										opened_children_li_length = opened_active.find('li').length,
										opened_all_delay = opened_children_li_length * delay_ms;

								parent_li.addClass('inactive');
								opened_active.removeClass('opened');

								parent_li.find('ul.sub-cat .title').each(function(i, e) {
									$(e).css({
										"-webkit-transition-delay": delay_ms * i + 'ms',
										"transition-delay": delay_ms * i + 'ms'
									});
								});

								parent_li.find('ul.sub-cat .icon').each(function(i, e) {
									$(e).css({
										"-webkit-transition-delay": delay_ms * i + 'ms',
										"transition-delay": delay_ms * i + 'ms'
									});
								});

								setTimeout(function  () {

									parent_li.find('ul.sub-cat .title').each(function(i, e) {
										$(e).css({
											"-webkit-transition-delay": all_delay - (delay_ms * i) + 'ms',
											"transition-delay": all_delay - (delay_ms * i) + 'ms'
										});
									});

									parent_li.find('ul.sub-cat .icon').each(function(i, e) {
										$(e).css({
											"-webkit-transition-delay": all_delay - (delay_ms * i) + 'ms',
											"transition-delay": all_delay - (delay_ms * i) + 'ms'
										});
									});
								}, all_delay + opened_all_delay);

								setTimeout(function () {
									opened_active.removeClass('active');
									opened_active.find('ul.sub-cat .title').each(function(i, e) {
										$(e).css({
											"-webkit-transition-delay":delay_ms * i + 'ms',
											"transition-delay":delay_ms * i + 'ms'
										});
									});

									opened_active.find('ul.sub-cat .icon').each(function(i, e) {
										$(e).css({
											"-webkit-transition-delay":delay_ms * i + 'ms',
											"transition-delay":delay_ms * i + 'ms'
										});
									});
									opened_ul.css('margin-bottom', 0);
								}, opened_all_delay);

								setTimeout(function () {
									opened_active.find('ul.sub-cat').css('visibility', 'hidden');
									parent_li.addClass('active opened');
									cat_row.addClass('cat_opened');
									var sub_cat_height = parent_li.find('ul.sub-cat').innerHeight();
									parent_ul.css('margin-bottom', sub_cat_height);
									parent_li.find('ul.sub-cat').css('visibility', 'visible');
								}, opened_all_delay + 1000);

								setTimeout(function  () {
									parent_li.removeClass('inactive');
								}, all_delay + opened_all_delay + 1100);
							}
						}
						else {

							if( $('.categories.cat_opened').length ) {

									var
										opened_cat_row = $('.categories.cat_opened');
										opened_active = opened_cat_row.find('li.active'),
										opened_ul = opened_active.parent(),
										opened_children_li_length = opened_active.find('li').length,
										opened_all_delay = opened_children_li_length * delay_ms;
										parent_li.addClass('inactive');
										opened_active.removeClass('opened');


									parent_li.find('ul.sub-cat .title').each(function(i, e) {
										$(e).css({
											"-webkit-transition-delay": delay_ms * i + 'ms',
											"transition-delay": delay_ms * i + 'ms'
										});
									});

									parent_li.find('ul.sub-cat .icon').each(function(i, e) {
										$(e).css({
											"-webkit-transition-delay": delay_ms * i + 'ms',
											"transition-delay": delay_ms * i + 'ms'
										});
									});

									setTimeout(function () {
										opened_active.removeClass('active');
										opened_ul.css('margin-bottom', 0);
										opened_cat_row.removeClass('cat_opened');
									}, opened_all_delay);

									setTimeout(function () {
										opened_active.find('ul.sub-cat').css('visibility', 'hidden');
										parent_li.addClass('active opened');
										cat_row.addClass('cat_opened');
										var sub_cat_height = parent_li.find('ul.sub-cat').innerHeight();
										parent_ul.css('margin-bottom', sub_cat_height);
										parent_li.find('ul.sub-cat').css('visibility', 'visible');
										parent_li.addClass('active');
									}, opened_all_delay + 1000);

									setTimeout(function  () {
										parent_li.removeClass('inactive');
									}, all_delay + opened_all_delay + 1100);
							}
							else {

								parent_li.addClass('inactive');

								parent_li.find('ul.sub-cat .title').each(function(i, e) {
									$(e).css({
										"-webkit-transition-delay": delay_ms * i + 'ms',
										"transition-delay": delay_ms * i + 'ms'
									});
								});

								parent_li.find('ul.sub-cat .icon').each(function(i, e) {
									$(e).css({
										"-webkit-transition-delay": delay_ms * i + 'ms',
										"transition-delay": delay_ms * i + 'ms'
									});
								});
								
								parent_li.addClass('active opened');

								cat_row.addClass('cat_opened');
								var sub_cat_height = parent_li.find('ul.sub-cat').innerHeight();
								parent_ul.css('margin-bottom', sub_cat_height);
								parent_li.find('ul.sub-cat').css('visibility', 'visible');

								setTimeout(function () {
									parent_li.find('ul.sub-cat .title').each(function(i, e) {
										$(e).css({
											"-webkit-transition-delay": all_delay - (delay_ms * i) + 'ms',
											"transition-delay": all_delay - (delay_ms * i) + 'ms'
										});
									});

									parent_li.find('ul.sub-cat .icon').each(function(i, e) {
										$(e).css({
											"-webkit-transition-delay": all_delay - (delay_ms * i) + 'ms',
											"transition-delay": all_delay - (delay_ms * i) + 'ms'
										});
									});
								}, all_delay);

								setTimeout(function () {
									parent_li.removeClass('inactive');
								}, all_delay);
							}
						}
					}
					else {
						
							var $this = $(this),
								parent_li = $this.parent();
								children_li = parent_li.find('li'),
								children_li_length = children_li.length,
								delay_ms = 300,
								all_delay = children_li_length * delay_ms;

							if(parent_li.hasClass('active')) {
								parent_li.find('ul.sub-cat').stop(true).slideUp(1000);
								parent_li.removeClass('active opened');
							}
							else {
								$('.categories li.active .sub-cat').stop(true).slideUp(1000);
								$('.categories li.active').removeClass('active opened');
								parent_li.find('ul.sub-cat').css('visibility', 'visible');
								parent_li.addClass('active');
								setTimeout(function () {
									parent_li.find('ul.sub-cat .title').each(function(i, e) {
										$(e).css({
											"-webkit-transition-delay": delay_ms * i + 'ms',
											"transition-delay": delay_ms * i + 'ms'
										});
									});

									parent_li.find('ul.sub-cat .icon').each(function(i, e) {
										$(e).css({
											"-webkit-transition-delay": delay_ms * i + 'ms',
											"transition-delay": delay_ms * i + 'ms'
										});
									});
								
									parent_li.addClass('opened');
								}, 1000);

								parent_li.find('ul.sub-cat').stop(true).slideDown(1000, function() {
									$('html,body').animate({
				            scrollTop: $this.offset().top - 20
				          }, 500);
								});
							}
					}

					return false;
				});
		}
		
		function windowsWidth () {

			$('html').css('overflow', 'hidden');
	    var window_width = $(window).width();
	    $('html').removeAttr('style');

	    return window_width;
		}
});
