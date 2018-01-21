<footer id="footer">
	<div class="payment">
		<h5>Добавете продукти за още 5лв. и вземете безплатна доставка</h5>
	</div>
	<div class="footer-option clearfix">
		<a href="#">Към количка</a>
		<p>25,50лв</p>
		<a href="#">Поръчвам</a>
	</div>
</footer>
</body>
	<script  src="https://code.jquery.com/jquery-1.12.4.min.js"  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="  crossorigin="anonymous"></script>
	<script>
	$(document).ready(function() {
	var doch = $('html').height();
	var dochpx = doch + 'px';
	$('.bg').css('height', dochpx);
   var docw = $('html').width();
	var ct1 = $('#call-tab-1').position().left;
	var formula1 = ct1 + (docw * 10 / 100) - 24;
	var px1 = formula1 + 'px';

	var ct2 = $('#call-tab-2').position().left;
	var formula2 = ct2 + (docw * 10 / 100) - 24;
	var px2 = formula2 + 'px';

	var ct3 = $('#call-tab-3').position().left;
	var formula3 = ct3 + (docw * 10 / 100) - 24;
	var px3 = formula3 + 'px';

	var ct4 = $('#call-tab-4').position().left;
	var formula4 = ct4 + (docw * 10 / 100) - 24;
	var px4 = formula4 + 'px';

	$('#call-tab-1').click(function(){
		$('#tab-1').toggle('slow',function(){
			if ( $('.tabs aside:visible').length ) {
			  $('.bg').show('slow')
			}
			else if  ($('.tabs aside:visible').length == 0 )  {
				$('.bg').hide('slow')
			}
		}).siblings().hide();
		$('#tab-1 .triangle').css('left', px1);
	});
	$('#call-tab-2').click(function(){
		$('#tab-2').toggle('slow',function(){
			if ( $('.tabs aside:visible').length ) {
			  $('.bg').show('slow')
			}
			else if  ($('.tabs aside:visible').length == 0 )  {
				$('.bg').hide('slow')
			}
		}).siblings().hide();
		$('#tab-2 .triangle').css('left', px2);
	});
	$('#call-tab-3').click(function(){
		$('#tab-3').toggle('slow',function(){
			if ( $('.tabs aside:visible').length ) {
			  $('.bg').show('slow')
			}
			else if  ($('.tabs aside:visible').length == 0 )  {
				$('.bg').hide('slow')
			}
		}).siblings().hide();
		$('#tab-2 .triangle').css('left', px3);
	});
	$('#call-tab-4').click(function(){
		$('#tab-4').toggle('slow',function(){
			if ( $('.tabs aside:visible').length ) {
			  $('.bg').show('slow')
			}
			else if  ($('.tabs aside:visible').length == 0 )  {
				$('.bg').hide('slow')
			}
		}).siblings().hide();
		$('#tab-2 .triangle').css('left', px4);
	});
});		
 $(window).resize(function() {
   var docw = $('html').width();
	var ct1 = $('#call-tab-1').position().left;
	var formula1 = ct1 + (docw * 10 / 100) - 24;
	var px1 = formula1 + 'px';

	var ct2 = $('#call-tab-2').position().left;
	var formula2 = ct2 + (docw * 10 / 100) - 24;
	var px2 = formula2 + 'px';

	var ct3 = $('#call-tab-3').position().left;
	var formula3 = ct3 + (docw * 10 / 100) - 24;
	var px3 = formula3 + 'px';

	var ct4 = $('#call-tab-4').position().left;
	var formula4 = ct4 + (docw * 10 / 100) - 24;
	var px4 = formula4 + 'px';
	$('#tab-1 .triangle').css('left', px1)
	$('#tab-2 .triangle').css('left', px2)
	$('#tab-3 .triangle').css('left', px3)
	$('#tab-4 .triangle').css('left', px4)
});
</script>
</html>