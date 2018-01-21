jQuery(document).ready(function($) {
	
	$('button.tgl-comment').click(function() {
		var 
			$this = $(this),
			comment = $this.closest('.the-comment'),
			content = comment.find('.content');
			contentHeight = content.outerHeight();

		if(comment.hasClass('opened')) {
			comment.removeClass('opened').height(120);
		}
		else {
			// $('.the-comment.opened button.tgl-comment').show();
			// $('.the-comment.opened').removeClass('opened').height(120);
			comment.addClass('opened').height(contentHeight);
		}

		setTimeout(function () {
			$this.hide();
		}, 500);
	});
});