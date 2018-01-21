<?php include "header.php"; ?>
<main id="content">
<div class="container">
	<section class="thank">
		<div class="thank-heading text-center">
			<h2>Благодарим Ви за поръчката!</h2>
			<p>За по-бързо поръчване в бъдеще може да добавите поръчката си в моите менюта</p>
			<a href="#"><img src="images/menu-1.svg">Добави</a>	
		</div>
		<div class="thank-timer text-center">
			<img src="images/timer.svg">
			<p><span>5 </span>минути от пускането на поръчката</p>
		</div>
		<div class="thank-up-option text-center">
			<div>
				<a href="#">
					<img src="images/thank-tel.svg">
					<p>Връзка с AmAm.bg</p>
				</a>
			</div>
			<div>
				<a href="#">
					<img src="images/thank-option.svg">
					<p>Преглед на поръчка</p>
				</a>
			</div>
		</div>
		<div class="thank-down-option text-center">
			<div>
				<a href="#">
					<img src="images/new-order.svg">
					<p>Нова поръчка</p>
				</a>
			</div>
			<div>
				<a href="#">
					<img src="images/take-me-to.svg">
					<p>Заведи ме</p>
				</a>
			</div>
		</div>

	</section>
</div>

<!--Модал-->
				<div class="modal fade modal-lg" id="restaurant-rateModal" role="dialog">
				    <div class="modal-dialog">
				      <div class="modal-content">
				        <div class="modal-header">
				          <button type="button" class="close" data-dismiss="modal">&times;</button>
							<section class="restaurant-rates-title">
								<h2>Оцени поръчка:</h2>
								<p>Ресторант - PaPa’s Pizza<span>17:45ч 17.02.2017</span></p>
							</section>
				        </div>
				        <div class="modal-body">
				        	<div class="restaurant-rates-cont">
					        		<h4>Храна</h4>
					        	<div>
					        		<img src="images/group-12.svg">
					        		<img src="images/group-12.svg">
					        		<img src="images/group-12.svg">
					        		<img src="images/group-12.svg">
					        		<img src="images/rating-star.svg">
					        		<span>4.2</span>
					        	</div>
				        	</div>
				        	<div class="restaurant-rates-cont">
					        		<h4>Бързина за доставка</h4>
					        	<div>
					        		<img src="images/group-12.svg">
					        		<img src="images/group-12.svg">
					        		<img src="images/group-12.svg">
					        		<img src="images/rating-star.svg">
					        		<img src="images/rating-star.svg">
					        		<span>3.0</span>
					        	</div>
				        	</div>
				        	<div class="restaurant-rates-cont">
					        		<h4>Обслужване куриер</h4>
					        	<div>
					        		<img src="images/group-12.svg">
					        		<img src="images/group-12.svg">
					        		<img src="images/group-12.svg">
					        		<img src="images/group-12.svg">
					        		<img src="images/rating-star.svg">
					        		<span>4.2</span>
					        	</div>
				        	</div>
				        	<div class="restaurant-rates-cont">
					        		<h4>Друго</h4>
					        	<div>
					        		<img src="images/group-12.svg">
					        		<img src="images/group-12.svg">
					        		<img src="images/group-12.svg">
					        		<img src="images/group-12.svg">
					        		<img src="images/rating-star.svg">
					        		<span>4.2</span>
					        	</div>
				        	</div>
				        	<div class="rate-us">
				        		<a href="#">Оцени</a>
				        	</div>
				        </div>
				      </div>
				    </div>
				 </div>
<!-- Край модал -->



</main>
<?php include "footer.php"; ?>


<script type="text/javascript">
$(document).ready(function() {
	setTimeout(function() {
	    $('#restaurant-rateModal').modal();
		}, 2000);

})
</script>