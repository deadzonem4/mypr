<?php include "header-1.php"; ?>
<main id="content">
	<div class="container">
		<section class="my-menu hronology">
			<div class="hronology-heading">
				<h2>Портфейл</h2>
				<p>Наличност: <span>100,45лв</span></p>
				<div class="hronology-portfeil">
					<img src="images/portfeil.svg">
					<p>зареди</p>
				</div>
			</div>
			<h2>История на транзакциите</h2>
			<div class="my-menu-box" id="first-menu">
				<h4>Зареждане на портфейл</h4>
				<p>Ваучер от коледна игра.</p>
				<p>17.05.2017 13:45ч</p>
				<span class="text-right">+35,00лв.</span>
			</div>
			<div class="my-menu-box" id="second-menu">
				<h4>Зареждане на портфейл</h4>
				<p>Ваучер от коледна игра.</p>
				<p>17.05.2017 13:45ч</p>
				<span class="text-right">-25,00лв.</span>
			</div>
			<div class="my-menu-box" id="third-menu">
				<h4>Зареждане на портфейл</h4>
				<p>Ваучер от коледна игра.</p>
				<p>17.05.2017 13:45ч</p>
				<span class="text-right">+35,00лв.</span>
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
		$('#portfeil-item-1').click(function(){
		$('#portfeil-option-1').toggle('fast');
	});
		$('#portfeil-item-2').click(function(){
		$('#portfeil-option-2').toggle('fast');
	});
		$('#portfeil-item-3').click(function(){
		$('#portfeil-option-3').toggle('fast');
	});
	
})
</script>