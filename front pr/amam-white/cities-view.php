<?php include "header.php"; ?>
<main id="content">
	<div class="container">
		<section class="choose-option row">
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
		<section class="city-restorant clearfix">
			<div class="product-list-title-blue row">
				<div class="col-xs-12">
					<p>Варна</p>
					<div class="cities-grey-line"></div>
					<p class="product-list-count pull-right">42</p>
				</div>
			</div>
			<div class="restorant-images">
				<div class="restorant-main-img text-left" data-toggle="modal" data-target="#myModal">
					<img src="images/g-6-m.png">
				</div>
<!--Модал-->
				<div class="modal fade modal-lg" id="myModal" role="dialog">
				    <div class="modal-dialog">
				      <div class="modal-content">
				        <div class="modal-header">
				          <button type="button" class="close" data-dismiss="modal">&times;</button>
				          	<section class="product-info row">
								<div href="#" class="col-xs-4">
									<div class="product-info-img ">
										<img src="images/pizza-logo.png">
										<a href="#">
											<img src="images/info-button.svg">
										</a>
									</div>
								</div>
								<div class="product-info-cont col-xs-4">
									<div class="product-info-work-time">
										<p>Работно време:</p>
										<p>10:00 - 23:00ч</p>
									</div>
									<div class="product-info-delivary">
										<p>Мин. сума - 20,00лв.</p>
										<p>Безплатна - над 30,00лв.</p>
									</div>
								</div>
								<div class="product-info-button col-xs-4">
									<div class="green-button">
										<a href="#">
											<p>60 мин<br><span>натоварено</span></p>
											<img src="images/buttime.svg">	
										</a>
									</div>
									<div class="red-button">
										<a href="#">
											<p>3.00 лв.<br><span>доставка</span></p>
											<img src="images/butcar.svg">
										</a>
									</div>
								</div>
							</section>
							<section class="product-promotion">
								<div class="product-promotion-title text-left">
									<h4>PaPa’s Pizza</h4>
									<img src="images/group-12.svg">
									<span>8,5</span>
								</div>
								<div class="promotion-banner">
									<div class="promotion-banner-overlay">
										<div class="promotion-banner-cont">
											<img src="images/present.png">
											<p>Промоции с пица Капричоза!</p>
											<div class="promotion-number">26</div>
										</div>
									</div>
								</div>
							</section>
				        </div>
				        <div class="modal-body row">
				        	<div class="col-xs-6 text-left">
				        		<h4>Услуги</h4>
				        		<ul>
				        			<li>
				        				<img src="images/modal-car.svg">
				        				<span>Доставка на адрес</span>
				        			</li>
				        			<li>
				        				<img src="images/modal-bag.svg">
				        				<span>Вземи на място</span>
				        			</li>
				        		</ul>
				        	</div>
				        	<div class="col-xs-6 text-left">
				        		<h4>Кухня</h4>
				        		<ul>
				        			<li>
				        				<img src="images/modal-bg.svg">
				        				<span>Българска</span>
				        			</li>
				        			<li>
				        				<img src="images/modal-en.svg">
				        				<span>Европейска</span>
				        			</li>
				        		</ul>
				        	</div>
				        	<div class="col-xs-6 text-left">
				        		<h4>Плащане</h4>
				        		<ul>
				        			<li>
				        				<img src="images/modal-card.svg">
				        				<span>С карта</span>
				        			</li>
				        			<li>
				        				<img src="images/modal-cash.svg">
				        				<span>При доставка</span>
				        			</li>
				        		</ul>
				        	</div>
				        	<div class="col-xs-6 text-left">
				        		<h4>Промоции</h4>
				        		<ul>
				        			<li>
				        				<img src="images/modal-pr.svg">
				        				<span>Да</span>
				        			</li>
				        		</ul>
				        	</div>
				        </div>
				        <div class="modal-footer">
				          	<label>
								<input type="submit" name="submit" value="Към менюто">
								<span><img src="images/submit.svg"></span>
							</label>
							<a href="#"><img src="images/modal-see-more.svg"></a>
				        </div>
				      </div>
				    </div>
				 </div>
<!-- Край модал -->
				<div class="restorant-main-img text-center" data-toggle="modal" data-target="#myModal">
						<img src="images/bombe.png">
				</div>
				<div class="restorant-main-img text-right" data-toggle="modal" data-target="#myModal">
						<img src="images/g-6-m.png">
				</div>
				<div class="cities-button-select">
					<img src="images/two-angle-right.svg">
				</div>
			</div>
		</section>
		<section class="city-restorant clearfix">
			<div class="product-list-title-blue row">
				<div class="col-xs-12">
					<p>Велико Търново</p>
					<div class="cities-grey-line"></div>
					<p class="product-list-count pull-right">42</p>
				</div>
			</div>
			<div class="restorant-images">
				<div class="restorant-main-img text-left" data-toggle="modal" data-target="#myModal">
						<img src="images/g-6-m.png">
				</div>
				<div class="restorant-main-img text-center" data-toggle="modal" data-target="#myModal">
						<img src="images/bombe.png">
				</div>
				<div class="restorant-main-img text-right" data-toggle="modal" data-target="#myModal">
						<img src="images/g-6-m.png">
				</div>
				<div class="cities-button-select">
					<img src="images/two-angle-right.svg">
				</div>
			</div>
		</section>
		<section class="city-restorant clearfix">
			<div class="product-list-title-blue row">
				<div class="col-xs-12">
					<p>Варна</p>
					<div class="cities-grey-line"></div>
					<p class="product-list-count pull-right">42</p>
				</div>
			</div>
			<div class="restorant-images">
				<div class="restorant-main-img text-left" data-toggle="modal" data-target="#myModal">
						<img src="images/g-6-m.png">
				</div>
				<div class="restorant-main-img text-center" data-toggle="modal" data-target="#myModal">
						<img src="images/bombe.png">
				</div>
				<div class="restorant-main-img text-right" data-toggle="modal" data-target="#myModal">						<img src="images/g-6-m.png">
				</div>
				<div class="cities-button-select">
					<img src="images/two-angle-right.svg">
				</div>
			</div>
		</section>
		<section class="city-restorant clearfix">
			<div class="product-list-title-blue row">
				<div class="col-xs-12">
					<p>Велико Търново</p>
					<div class="cities-grey-line"></div>
					<p class="product-list-count pull-right">42</p>
				</div>
			</div>
			<div class="restorant-images">
				<div class="restorant-main-img text-left" data-toggle="modal" data-target="#myModal">
						<img src="images/g-6-m.png">
				</div>
				<div class="restorant-main-img text-center" data-toggle="modal" data-target="#myModal">
						<img src="images/bombe.png">
				</div>
				<div class="restorant-main-img text-right" data-toggle="modal" data-target="#myModal">
						<img src="images/g-6-m.png">
				</div>
				<div class="cities-button-select">
					<img src="images/two-angle-right.svg">
				</div>
			</div>
		</section>
		<section class="city-restorant clearfix">
			<div class="product-list-title-blue row">
				<div class="col-xs-12">
					<p>Стара Загора - заведения</p>
					<div class="cities-grey-line"></div>
					<p class="product-list-count pull-right">42</p>
				</div>
			</div>
			<div class="restorant-images">
				<div class="restorant-main-img text-left" data-toggle="modal" data-target="#myModal">
						<img src="images/g-6-m.png">
				</div>
				<div class="restorant-main-img text-center" data-toggle="modal" data-target="#myModal">
						<img src="images/bombe.png">
				</div>
				<div class="restorant-main-img text-right" data-toggle="modal" data-target="#myModal">
						<img src="images/g-6-m.png">
				</div>
				<div class="cities-button-select">
					<img src="images/two-angle-right.svg">
				</div>
			</div>
		</section>
	</div>
</main>
<?php include "footer.php"; ?>