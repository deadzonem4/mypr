<?php include "header.php"; ?>
<main id="content">
	<div class="container">
		<section class="my-menu">
			<h2>Моите менюта</h2>
			<div class="my-menu-box" id="first-menu">
				<h4>Меню вечеря</h4>
				<p>Пицария “Тоскана”</p>
				<span class="text-right">35,00лв.</span>
			</div>
			<div class="menu-options" id="first-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/delete.svg">
						<p>изтрий</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/menu-box.svg">
						<p>поръчай</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/see.svg">
						<p>преглед</p>
					</a>
				</div>
			</div>
			<div class="my-menu-box" id="second-menu">
				<h4>Меню вечеря</h4>
				<p>Пицария “Тоскана”</p>
				<span class="text-right">35,00лв.</span>
			</div>
			<div class="menu-options" id="second-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/delete.svg">
						<p>изтрий</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/menu-box.svg">
						<p>поръчай</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/see.svg">
						<p>преглед</p>
					</a>
				</div>
			</div>
			<div class="my-menu-box" id="third-menu">
				<h4>Меню вечеря</h4>
				<p>Пицария “Тоскана”</p>
				<span class="text-right">35,00лв.</span>
			</div>
			<div class="menu-options" id="third-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/delete.svg">
						<p>изтрий</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/menu-box.svg">
						<p>поръчай</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/see.svg">
						<p>преглед</p>
					</a>
				</div>
			</div>
			<div class="my-menu-box" id="fourth-menu">
				<h4>Меню вечеря</h4>
				<p>Пицария “Тоскана”</p>
				<span class="text-right">35,00лв.</span>
			</div>
			<div class="menu-options" id="fourth-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/delete.svg">
						<p>изтрий</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/menu-box.svg">
						<p>поръчай</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/see.svg">
						<p>преглед</p>
					</a>
				</div>
			</div>
		</section>
	</div>
</main>
<?php include "footer.php"; ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#first-menu').click(function(){
		$('#first-menu-options').toggle('fast');
		$(this).toggleClass('menu-grey');
	});
		$('#second-menu').click(function(){
		$('#second-menu-options').toggle('fast');
		$(this).toggleClass('menu-grey');
	});
		$('#third-menu').click(function(){
		$('#third-menu-options').toggle('fast');
		$(this).toggleClass('menu-grey');
	});
		$('#fourth-menu').click(function(){
		$('#fourth-menu-options').toggle('fast');
		$(this).toggleClass('menu-grey');
	});
	
})
</script>