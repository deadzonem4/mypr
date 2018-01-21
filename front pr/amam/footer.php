		<footer id="footer">
			<div class="container">
				<div class="row">
					<ul class="col-xs-4 text-left left-footer">
						<li><a href="#">Лични данни</a></li>
						<li><a href="#">Кариери</a></li>
					</ul>
					<ul class="col-xs-4 text-center center-footer">
						<li>За контакти:</li>
						<li><a href="tel:070042626"><strong>070042626</strong></a></li>
					</ul>
					<ul class="col-xs-4 text-right right-footer">
						<li><a href="#">Общи условия</a></li>
						<li><a href="#">Още менюта</a></li>
					</ul>
					<div class="col-xs-12 all-rights">
						<p>@ 2005 - 2017 АМАМ БГ ООД. Всички права запазени.</p>
					</div>
				</div>
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