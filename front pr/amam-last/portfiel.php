<?php include "header-1.php"; ?>
<main id="content">
	<div class="container">
		<section class="portfeil">
			<div class="portfeil-heading">
				<h4>Зареждане</h4>
				<p>Моля преведете желаната сума по сметка:Моля преведете желаната сума по сметка:Моля преведете желаната сума по сметка:</p>
			</div>
			<div class="portfeil-content">
				<div class="portfeil-item" id="portfeil-item-1">
					<p>Зареди с ваучер</p>
				</div>
				<div class="portfeil-option" id="portfeil-option-1">
					<div>
						<input type="text" placeholder="Въведете номер на ваучер">
					</div>
					<div>
						<input type="submit" value="Потвърди">
					</div>
				</div>
				<div class="portfeil-item" id="portfeil-item-2">
					<p>Зареди с Kарта, ePay, PayPal</p>
				</div>
				<div class="portfeil-option" id="portfeil-option-2">
					<div>
						<input type="text" placeholder="Въведете сума">
					</div>
					<div class="pay-method">
						<div>
							<img src="images/credit-card.png">
							<p>Карта</p>
						</div>
						<div>
							<img src="images/epay.png">
							<p>ePay</p>
						</div>
						<div>
							<img src="images/pay-pal.png">
							<p>PayPal</p>
						</div>
					</div>
				</div>
				<div class="portfeil-item" id="portfeil-item-3">
					<p>Зареди по банков път</p>
				</div>
				<div class="portfeil-option" id="portfeil-option-3">
					<div class="portfeil-option-content">
						<h4>Моля преведете желаната сума по сметка:</h4>
						<p>Моля преведете желаната сума по сметка:Моля преведете желаната сума по сметка:Моля преведете желаната сума по сметка:Моля преведете желаната сума по сметка:</p>
					</div>
					<div>
						<input type="submit" value="Изпрати">
					</div>
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