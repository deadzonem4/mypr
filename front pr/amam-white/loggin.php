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
		<form>
			<div>
				<label>
					<input type="submit" value="Вход">
				</label>
			</div>
			<div>
				<label>
					<input type="submit" value="Регистрация">
				</label>
			</div>
		</form>
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