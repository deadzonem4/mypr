<?php include "header.php"; ?>
<main id="content">
	<section class="short-registration text-center pdt25 personal-data">
		<h4>Лични данни</h4>
		<form>
			<div class="name-form">
				<label>
					<input type="name" placeholder="Име и фамилия">
				</label>
			</div>
			<div class="mail-form">
				<label>
					<input type="mail" placeholder="Е-мейл">
				</label>
			</div>
			<div class="tel-form">
				<label>
					<input type="tel" placeholder="Мобилен телефон">
				</label>
			</div>
			<div class="date-form">
				<label>
					<input type="text" placeholder="Дата на раждане">
				</label>
			</div>
			<div class="submit-form text-center">
				<label>
					<input type="submit" value="Актуализирай">
				</label>
			</div>
			<div class="change-pass">
				<a href="#">Смени парола<img src="images/right-angle-red.svg"></a>
			</div>
		</form>
	</section>
	<aside class="ext-registration text-center password-change">
		<form>
			<p>Смяна на парола</p>
			<div class="password-form">
				<label>
					<input type="password" placeholder="Стара парола">
				</label>
			</div>
			<div class="password-form">
				<label>
					<input type="password" placeholder="Нова парола">
				</label>
			</div>
			<div class="password-form">
				<label>
					<input type="password" placeholder="Потвърди нова парола">
				</label>
			</div>
			<div class="submit-form text-center">
				<label>
					<input type="submit" value="Смени паролата">
				</label>
			</div>
		</form>
	</aside>
</main>
<?php include "footer.php"; ?>