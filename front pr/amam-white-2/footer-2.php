<footer id="footer">
	<div class="payment">
		<h4>Начин на плащане:</h4>
		<div class="dropup">
		    <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown">в брой
		    <span class="caret"></span></a>
		    <ul class="dropdown-menu">
		      <li><a href="#">с карта</a></li>
		      <div class="menu-line"></div>
		      <li><a href="#">в брой</a></li>
		    </ul>
  		</div>
	</div>
	<div class="footer-option clearfix">
		<a href="#">Към количка</a>
		<p>25,50лв</p>
		<a href="#">ПЛАЩАНЕ</a>
	</div>
</footer>
</body>
	<script>
	function triangle(){
		var docw = $('body').width();
		console.log(docw);
		var ct1 = $('#call-tab-1').position().left;
		var formula1 = ct1 + (((docw * 10) / 100) - 24);
		var px1 = formula1 + 'px';

		var ct2 = $('#call-tab-2').position().left;
		var formula2 = ct2 + (((docw * 10) / 100) - 24);
		var px2 = formula2 + 'px';

		var ct3 = $('#call-tab-3').position().left;
		var formula3 = ct3 + (((docw * 10) / 100) - 24);
		var px3 = formula3 + 'px';

		var ct4 = $('#call-tab-4').position().left;
		var formula4 = ct4 + (((docw * 10) / 100) - 24);
		var px4 = formula4 + 'px';
		$('#tab-1 .triangle').css('left', px1);
		$('#tab-2 .triangle').css('left', px2);
		$('#tab-3 .triangle').css('left', px3);
		$('#tab-4 .triangle').css('left', px4);
	}

	$(document).ready(function() {
		triangle();
	   
		$('#call-tab-1').click(function(){
			$('#tab-1').toggle('slow').siblings().hide();
		});
		$('#call-tab-2').click(function(){
			$('#tab-2').toggle('slow').siblings().hide();
		});
		$('#call-tab-3').click(function(){
			$('#tab-3').toggle('slow').siblings().hide();
		});
		$('#call-tab-4').click(function(){
			$('#tab-4').toggle('slow').siblings().hide();
		});
		setTimeout(triangle, 1000);
	});		

	$(window).resize(function() {
		   triangle(); 
	});
	</script>
</html>