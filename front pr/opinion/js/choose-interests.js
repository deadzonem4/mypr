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
		});

		$('.sub-cat a').click(function() {
			$(this).parent().toggleClass('active');
			return false;
		});

		function collapseCategories () {
				
				$('.categories a[data-action="tab"]').unbind('click');
				$('.categories a[data-action="tab"]').bind('click', function() {
				
					if(windowsWidth() > 767) {
			
						var $this = $(this),
								parent_li = $this.parent(),
								parent_ul = $this.parents('.cat-menu');
								cat_row = $this.parents('.categories');

						if(cat_row.hasClass('cat_opened')) {
							if(parent_li.hasClass('active')) {
								parent_li.find('ul.sub-cat').fadeOut(500).slideUp(1000);
								parent_ul.css('margin-bottom', 0);
								parent_li.removeClass('active');
								cat_row.removeClass('cat_opened');
							}
							else {
								cat_row.find('li.active .sub-cat').fadeOut(500).slideUp(1000);
								cat_row.find('.cat-menu > li.active').removeClass('active');
								parent_li.addClass('active');
								parent_li.find('ul.sub-cat').show();
								var sub_cat_height = parent_li.find('ul.sub-cat').innerHeight();
								parent_li.find('ul.sub-cat').hide();
								parent_ul.css('margin-bottom', sub_cat_height);
								parent_li.find('ul.sub-cat').fadeIn(500).slideDown(1000);
							}
						}
						else {
							$('.categories.cat_opened .cat-menu').css('margin-bottom', 0);
							$('.categories.cat_opened li.active .sub-cat').slideUp(1000).fadeOut(500);
							$('.categories.cat_opened .cat-menu > li.active').removeClass('active');
							$('.categories.cat_opened').removeClass('cat_opened');
							parent_li.addClass('active');
							cat_row.addClass('cat_opened');
							parent_li.find('ul.sub-cat').show();
							var sub_cat_height = parent_li.find('ul.sub-cat').innerHeight();
							parent_li.find('ul.sub-cat').hide();
							parent_ul.css('margin-bottom', sub_cat_height);
							parent_li.find('ul.sub-cat').fadeIn(500).slideDown(1000);
						}
					}
					else {

							var $this = $(this),
								parent_li = $this.parent();

							if(parent_li.hasClass('active')) {
								parent_li.find('ul.sub-cat').stop(true).slideUp(1000);
								parent_li.removeClass('active');
							}
							else {
								$('.categories li.active .sub-cat').stop(true).slideUp(1000);
								$('.categories li.active').removeClass('active');
								parent_li.addClass('active');
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

		$(window).load(function() {
			setTimeout(function () {
				$('.choose-interests-popup .categories').fadeIn(500);
			}, 300)
		});
});
