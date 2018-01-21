jQuery(document).ready(function($) {
	
		$(window).load(function() {
			if ($('.chat-users').length) {
				$('.chat-users').mCustomScrollbar();
			}

			if ($('.chat-messages').length) {
				$(".chat-messages").mCustomScrollbar().mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});	
			}
		});

		$('.chat-users-list > li > a').click(function() {

			if( $(this).parent().hasClass('active') ) {
				$(this).parent().removeClass('active');
				$(".chat-bar").removeClass('chat-opened');
				$('.chat-messages').removeClass('opened');
			}
			else {
				$(".chat-bar").addClass('chat-opened');
				$('.chat-users-list > li.active').removeClass('active');
				$('.chat-messages').addClass('opened');
				$(this).parent().addClass('active');
			}
			
			return false;
		});

		$("body").bind('click', function() {
	    if($(event.target).hasClass('chat-bar') || !$(event.target).closest('.chat-bar').size()) {
	      $('.chat-users-list > li.active').removeClass('active');
				$(".chat-bar").removeClass('chat-opened');
				$('.chat-messages').removeClass('opened');

				return false;
	    }
	  });
});