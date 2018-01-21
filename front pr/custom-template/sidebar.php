<?php
/*
	Template Name: Sidebar
*/
?>
<?php get_header(); ?>
<main class="pages">
	<div class="container">
		<h1><?php wp_title(''); ?></h1>
		<section class="col-sm-8">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); the_content();
			endwhile; else: ?>
			<p>Page Not Found.</p>
			<?php endif; ?>
		</section>
		<aside class="right-sidebar col-sm-4 col-xs-10 col-xs-offset-1 col-xs-offset-0">
			<div class="sidebar-image-box">
				<p class="sidebar-upper-text">The best cleaners you will<br>
				find in London</p>
				<p class="sidebar-down-text">Call our friendly team now!</p>
				<a href="tel:02086140730"><object data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/old-telephone2.svg" type="image/svg+xml"></object>Call 0208 6140 730</a>
			</div>
				<div class="sidebar-services-box">
				<h4>Services - Clean&Clean</h4>
				<ul>
				 	<li>
				 		<a href="/carpet-cleaning/">
				 			<object class="services-icons" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-cleaning.svg" type="image/svg+xml"></object>
				 			<object class="services-icons-hover" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-cleaning-white.svg" type="image/svg+xml"></object>
				 		Carpet cleaning
				 			<img class="services-icons" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right.png">
					 		<img class="services-icons-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right-white.png">
				 		</a>
				 	</li>
				 	<li>
				 		<a href="/upholstery-cleaning/">
				 		<object class="services-icons" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-sofa.svg" type="image/svg+xml"></object>
				 			<object class="services-icons-hover" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-sofa-white.svg" type="image/svg+xml"></object>
				 		Upholstery cleaning
				 			<img class="services-icons" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right.png">
					 		<img class="services-icons-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right-white.png">
				 		</a>
				 	</li>
				 	<li>
				 		<a href="/move-inout-cleaning/">
				 			<object class="services-icons" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-van.svg" type="image/svg+xml"></object>
				 			<object class="services-icons-hover" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-van-white.svg" type="image/svg+xml"></object>
				 		Move in/out cleaning
				 			<img class="services-icons" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right.png">
					 		<img class="services-icons-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right-white.png">
				 		</a>
				 	</li>
				 	<li>
				 		<a href="/after-builders-cleaning/">
				 		<object class="services-icons" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-broom.svg" type="image/svg+xml"></object>
				 			<object class="services-icons-hover" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-broom-white.svg" type="image/svg+xml"></object>
				 		After builders cleaning
				 			<img class="services-icons" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right.png">
					 		<img class="services-icons-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right-white.png">
				 		</a>
				 	</li>
				 	<li>
				 		<a href="/end-of-tenancy-cleaning/">
				 			<object class="services-icons" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-keys.svg" type="image/svg+xml"></object>
				 			<object class="services-icons-hover" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-keys-white.svg" type="image/svg+xml"></object>
				 		End of tenansy cleaning
				 			<img class="services-icons" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right.png">
					 		<img class="services-icons-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right-white.png">
				 		</a>
				 	</li>
				 	<li>
				 		<a href="/removals-services/">
				 			<object class="services-icons" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-package.svg" type="image/svg+xml"></object>
				 			<object class="services-icons-hover" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-package-white.svg" type="image/svg+xml"></object>
				 		Removals services
				 			<img class="services-icons" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right.png">
					 		<img class="services-icons-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right-white.png">
				 		</a>
				 	</li>
				 	<li>
				 		<a href="/one-off-cleaning/">
				 			<object class="services-icons" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-swipe.svg" type="image/svg+xml"></object>
				 		<object class="services-icons-hover" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-swipe-white.svg" type="image/svg+xml"></object>
				 		One-off cleaning
				 			<img class="services-icons" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right.png">
					 		<img class="services-icons-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right-white.png">
				 		</a>
				 	</li>
				 	<li>
				 		<a href="/deep-cleaning/">
				 			<object class="services-icons" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-washing.svg" type="image/svg+xml"></object>
				 			<object class="services-icons-hover" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-washing-white.svg" type="image/svg+xml"></object>
				 		Deep cleaning
					 		<img class="services-icons" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right.png">
					 		<img class="services-icons-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/sidebar-right-white.png">
				 		</a>
				 	</li>
				</ul>
				</div>
		</aside>
	</div>
</main>
<?php get_footer(); ?>