<?php include "header.php"; ?>
<main id="content">
	<div class="container">
		<section class="my-menu adresses">
			<h2>Адреси</h2>
			<div class="my-menu-box" id="first-menu">
				<h4>бул. “България” 2, Център,<br>Пловдив, Пловдив-град, <br>ет.1, ап. 1, вх. Б</h4>
				<p>Тел: 0887 663 633</p>
				<p>Фирма: 3web</p>
			</div>
			<div class="menu-options" id="first-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/Check.svg">
						<p>поръчай</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/edit.svg">
						<p>промени</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/delete.svg">
						<p>изтрий</p>
					</a>
				</div>
			</div>
			<div class="my-menu-box" id="second-menu">
				<h4>бул. “България” 2, Център,<br>Пловдив, Пловдив-град, <br>ет.1, ап. 1, вх. Б</h4>
				<p>Тел: 0887 663 633</p>
				<p>Фирма: 3web</p>
			</div>
			<div class="menu-options" id="second-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/Check.svg">
						<p>поръчай</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/edit.svg">
						<p>промени</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/delete.svg">
						<p>изтрий</p>
					</a>
				</div>
			</div>
			<div class="my-menu-box" id="third-menu">
				<h4>бул. “България” 2, Център,<br>Пловдив, Пловдив-град, <br>ет.1, ап. 1, вх. Б</h4>
				<p>Тел: 0887 663 633</p>
				<p>Фирма: 3web</p>
			</div>
			<div class="menu-options" id="third-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/Check.svg">
						<p>поръчай</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/edit.svg">
						<p>промени</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/delete.svg">
						<p>изтрий</p>
					</a>
				</div>
			</div>
			<div class="submit-form text-center">
				<label>
					<input type="submit" value="Добави адрес">
				</label>
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