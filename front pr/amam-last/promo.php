<?php include "header-2.php"; ?>
<main id="content">
	<div class="container">
		<section class="choose-option row" style="display: none;">
			<div id="call-tab-1" class="widget">
				<a href="#">
					<img class="tab-dis" src="images/car.svg">
					<img class="tab-app" src="images/car-white.svg">
					<p class="tab-1">Избери <br>услуга</p>
				</a>
			</div>
			<div id="call-tab-2" class="widget">
				<a href="#">
					<img class="tab-dis" src="images/spoon.svg">
					<img class="tab-app" src="images/spoon-white.svg">
					<p class="tab-2">Филтър <br>заведения</p>
				</a>
			</div>
			<div id="call-tab-3" class="widget">
				<a href="#">
					<img class="tab-dis" src="images/pin.png">
					<img class="tab-app" src="images/pin-white.png">
					<p class="tab-3">Избери <br>град</p>
				</a>
			</div>
			<div id="call-tab-4" class="widget">
				<a href="#">
					<img class="tab-dis" src="images/village.svg">
					<img  class="tab-app" src="images/village-white.svg">
					<p class="tab-4">Избери <br>адрес</p>
				</a>
			</div>
		</section>
		<?php include "options.php" ?>
	</div>
	<div class="promo-title">
		<h2>Промоции София</h2>
	</div>
	<div class="promo-offer-col">
		<h4>Papa’s Pizza</h4>
		<div class="promo-box">
			<div class="promo-img">
				<img src="images/g-6-m.png">
			</div>
			<div class="promo-content">
				<p>При поръчка на две фамилни пици получавате подарък трета фамилна пица по избор при поръчка на две фамилни пици получавате подарък</p>
				<div class="promo-overlay"></div>
			</div>
		</div>
	</div>
	<div class="promo-offer-full">
		<h4>Papa’s Pizza</h4>
		<div class="promo-box">
			<div class="promo-img">
				<img src="images/promo.jpg">
			</div>
			<div class="promo-content">
				<p>При поръчка на две фамилни пици получавате подарък трета фамилна пица по избор при поръчка на две фамилни</p>
				<div class="promo-overlay"></div>
			</div>
		</div>
	</div>
	<div class="promo-offer-col">
		<h4>Papa’s Pizza</h4>
		<div class="promo-box">
			<div class="promo-img">
				<img src="images/g-6-m.png">
			</div>
			<div class="promo-content">
				<p>При поръчка на две фамилни пици получавате подарък трета фамилна пица по избор при поръчка на две фамилни пици получавате подарък</p>
				<div class="promo-overlay"></div>
			</div>
		</div>
	</div>
	<div class="promo-offer-full">
		<h4>Papa’s Pizza</h4>
		<div class="promo-box">
			<div class="promo-img">
				<img src="images/promo.jpg">
			</div>
			<div class="promo-content">
				<p>При поръчка на две фамилни пици получавате подарък трета фамилна пица по избор при поръчка на две фамилни</p>
				<div class="promo-overlay"></div>
			</div>
		</div>
	</div>
	<div class="promo-offer-col">
		<h4>Papa’s Pizza</h4>
		<div class="promo-box">
			<div class="promo-img">
				<img src="images/g-6-m.png">
			</div>
			<div class="promo-content">
				<p>При поръчка на две фамилни пици получавате подарък трета фамилна пица по избор при поръчка на две фамилни пици получавате подарък</p>
				<div class="promo-overlay"></div>
			</div>
		</div>
	</div>
	<div class="promo-offer-full">
		<h4>Papa’s Pizza</h4>
		<div class="promo-box">
			<div class="promo-img">
				<img src="images/promo.jpg">
			</div>
			<div class="promo-content">
				<p>При поръчка на две фамилни пици получавате подарък трета фамилна пица по избор при поръчка на две фамилни</p>
				<div class="promo-overlay"></div>
			</div>
		</div>
	</div>
</main>
<?php include "footer.php"; ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.header-shape').click(function(){
		$('.choose-option').toggle('fast');
		$('.header-shape .fa-angle-down, .header-shape .fa-angle-up').toggleClass('fa-angle-down fa-angle-up');
	});
	
})
</script>