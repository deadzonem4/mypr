<?php include "header-3.php"; ?>
<main id="content">
	<section class="login-slider">
		<div class="slider">
			<div><img src="images/slider-img.jpg"></div>
			<div><img src="images/slider-img.jpg"></div>
			<div><img src="images/slider-img.jpg"></div>
			<div><img src="images/slider-img.jpg"></div>
			<div><img src="images/slider-img.jpg"></div>
		</div>
	</section>
	<section class="login-form container text-center">
		<a href="#">
	      	<div class="logo"></div>
	    </a>
		<div class="loggin-menu-top">
			<div>
				<a href="#">
					<img src="images/garbage.svg">
					<p>Любими<br>ястия</p>
				</a>
			</div>
			<div>
				<a href="#">
					<img src="images/list.svg">
					<p class="blue">Моите<br>менюта</p>
				</a>
			</div>
			<div>
				<a href="#">
					<img src="images/garbage.svg">
					<p>Любими<br>заведения</p>
				</a>
			</div>
		</div>
		<div class="loggin-menu-bottom">
			<div>
				<a href="#">
					<img src="images/garbage.svg">
					<p>Архив</p>
				</a>
			</div>
			<div>
				<a href="#">
					<img src="images/list.svg">
					<p class="blue">Бонус<br>точки</p>
				</a>
			</div>
			<div>
				<a href="#">
					<img src="images/garbage.svg">
					<p>Промоции</p>
				</a>
			</div>
		</div>
		<div class="login-grey-line"></div>
	</section>
	<section class="banners container">
		<div class="banners-box">
			<img src="images/banner-1.jpg">
			<img src="images/banner-2.jpg">
			<img src="images/banner-3.jpg">
			<img src="images/banner-1.jpg">
			<img src="images/banner-2.jpg">
		</div>
	</section>
</main>

<script type="text/javascript">
    $(document).ready(function(){
      $(".slider").slick({
        dots: false,
  		infinite: true,
  		speed: 500,
  		slidesToShow: 1,
  		centerMode: true,
  		centerPadding: '10px',
  		variableWidth: true
    });
    });
</script>