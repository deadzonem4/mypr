<?php include "header.php"; ?>
<main id="content">
	<div class="container">
		<section class="my-menu messages">
			<h2>Съобщения</h2>
			<div class="my-menu-box" id="first-menu">
				<h4>Забавена поръчка</h4>
				<p>Fusce vehicula dolor arcu, sit amet blandit dolor mollis nec. Donec viverra eleifend lacus…</p>
				<span>17:45ч 17.02.2017</span>
			</div>
			<div class="menu-options" id="first-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/Check.svg">
						<p>отвори</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/see-blue.svg">
						<p>прегледай</p>
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
				<h4>Забавена поръчка</h4>
				<p>Fusce vehicula dolor arcu, sit amet blandit dolor mollis nec. Donec viverra eleifend lacus…</p>
				<span>17:45ч 17.02.2017</span>
			</div>
			<div class="menu-options" id="second-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/Check.svg">
						<p>отвори</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/see-blue.svg">
						<p>прегледай</p>
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
				<h4>Забавена поръчка</h4>
				<p>Fusce vehicula dolor arcu, sit amet blandit dolor mollis nec. Donec viverra eleifend lacus…</p>
				<span>17:45ч 17.02.2017</span>
			</div>
			<div class="menu-options" id="third-menu-options">
				<div class="menu-options-button">	
					<a href="#">
						<img src="images/Check.svg">
						<p>отвори</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/see-blue.svg">
						<p>прегледай</p>
					</a>
				</div>
				<div class="menu-options-button">
					<a href="#">
						<img src="images/delete.svg">
						<p>изтрий</p>
					</a>
				</div>
			</div>
			<div class="to-profile text-center">
				<a href="#"><i class="fa fa-angle-left"></i>Към профила</a>
				<span><img src="images/pen.svg"></span>
			</div>
		</section>
	</div>
</main>
<?php include "footer.php"; ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#first-menu').click(function(){
		$('#first-menu-options').toggle('fast');
		$(this).toggleClass('menu-grey messages-bold');
	});
		$('#second-menu').click(function(){
		$('#second-menu-options').toggle('fast');
		$(this).toggleClass('menu-grey messages-bold');
	});
		$('#third-menu').click(function(){
		$('#third-menu-options').toggle('fast');
		$(this).toggleClass('menu-grey messages-bold');
	});
		$('#fourth-menu').click(function(){
		$('#fourth-menu-options').toggle('fast');
		$(this).toggleClass('menu-grey messages-bold');
	});
	
})
</script>