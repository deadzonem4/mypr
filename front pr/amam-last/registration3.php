<?php include "header-4.php"; ?>
	<main id="content">
		<section class="short-registration text-center">
			<h4>Пълна регистрация</h4>
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
				<div class="password-form">
					<label>
						<input type="password" placeholder="Порола">
					</label>
				</div>
				<div class="password-form">
					<label>
						<input type="password" placeholder="Потвърди парола">
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
			</form>
		</section>
		<aside class="ext-registration text-center">
			<form>
				<p>Адрес за доставка</p>
				<div class="adress-form">
					<label>
						<input type="text" placeholder="Град">
					</label>
				</div>
				<div class="adress-form">
					<label class="invalid-input">
						<input type="text" placeholder="Не сте попълнили квартал">
					</label>
				</div>
				<div class="adress-form">
					<label>
						<input type="text" placeholder="Улица, номер">
					</label>
				</div>
				<div class="adress-form">
					<label>
						<input type="text" placeholder="Блок Здравец">
					</label>
				</div>
				<div class="small-form">
					<label>
						<input type="text" placeholder="Вход">
						<input type="text" placeholder="Етаж">
						<input type="text" placeholder="Апартамент">
					</label>
				</div>
				<div class="adress-form">
					<label>
						<input type="text" placeholder="Звънец">
					</label>
				</div>
				<div class="adress-form">
					<label>
						<textarea placeholder="Уточнения за адреса"></textarea>
					</label>
				</div>
				<div class="adress-form">
					<label>
						<input type="tel" placeholder="Телефон за адрес">
					</label>
				</div>
			</form>
		</aside>
		<section class="ext-terms text-center">
			<form>
				<div class="terms">
					<span></span>
					<p>Съгласен съм с <a href="#">общите условия и политиката за лични данни</a></p>
				</div>
				<div class="submit-form">
					<label>
						<input type="submit" value="Регистрирай се">
					</label>
				</div>
			</form>
		</section>
		<section class="container warning">
			<div class="warning-box-red">
				<img src="images/note-white.svg">
				<p>Не сте се съгласили с общите условия и политиката за лични данни</p>
			</div>
		</section>
		<section class="to-short-reg">
			<a href="#">Към кратка регистрация<img src="images/right-angle-red.svg"></a>
		</section>
	</main>
</body>