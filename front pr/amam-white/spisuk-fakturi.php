<?php include "header-1.php"; ?>
<main id="content">
	<section class="invoices-info">
		<ul>
			<li>“3web.bg” ООД</li>
			<li>Пловдив, кап. Райчо 95</li>
			<li>ЕИК: 317302741</li>
			<li>ДДС: BG317302741</li>
			<li>МОЛ: Слави Славчев</li>
		</ul>
		<div>
			<a href="#">
				<img src="images/edit.svg">
				<p>промени</p>
			</a>
		</div>
	</section>
	<div class="container">
		<section class="my-menu invoices">
			<h2>Списък фактури</h2>
			<div class="my-menu-box" id="first-menu">
				<p>1234129030</p>
				<p>17.05.2017</p>
				<p>35,00лв.</p>
			</div>
			<div class="menu-options" id="first-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/send-mail.svg">
						<p>изпрати</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/download.svg">
						<p>изтегли</p>
					</a>
				</div>
			</div>
			<div class="my-menu-box" id="second-menu">
				<p>1234129030</p>
				<p>17.05.2017</p>
				<p>35,00лв.</p>
			</div>
			<div class="menu-options" id="second-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/send-mail.svg">
						<p>изпрати</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/download.svg">
						<p>изтегли</p>
					</a>
				</div>
			</div>
			<div class="my-menu-box" id="third-menu">
				<p>1234129030</p>
				<p>17.05.2017</p>
				<p>35,00лв.</p>
			</div>
			<div class="menu-options" id="third-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/send-mail.svg">
						<p>изпрати</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/download.svg">
						<p>изтегли</p>
					</a>
				</div>
			</div>
			<div class="my-menu-box" id="fourth-menu">
				<p>1234129030</p>
				<p>17.05.2017</p>
				<p>35,00лв.</p>
			</div>
			<div class="menu-options" id="fourth-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/send-mail.svg">
						<p>изпрати</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/download.svg">
						<p>изтегли</p>
					</a>
				</div>
			</div>
			<div class="to-profile text-center">
				<a href="#"><i class="fa fa-angle-left"></i>Към профила</a>
			</div>
		</section>
	</div>


</main>
<?php include "footer.php"; ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#first-menu').click(function(){
		$('#first-menu-options').toggle('fast');
		$(this).toggleClass('invoices-gray');
	});
		$('#second-menu').click(function(){
		$('#second-menu-options').toggle('fast');
		$(this).toggleClass('invoices-gray');
	});
		$('#third-menu').click(function(){
		$('#third-menu-options').toggle('fast');
		$(this).toggleClass('invoices-gray');
	});
		$('#fourth-menu').click(function(){
		$('#fourth-menu-options').toggle('fast');
		$(this).toggleClass('invoices-gray');
	});
	
})
</script>