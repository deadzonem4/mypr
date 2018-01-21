<?php
/**
 * Template Name: standart
 */
?>
<?php get_header(); ?>
</div>
  <main id="content">
  	<div class="background-gray">
		<div class="container">
			<h1><?php the_title() ?></h1>
			<div class="breadcrumb"><?php the_breadcrumb(); ?></div>
		</div>
	</div>	
  	<div class="page-content">
  	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
       <?php the_content(); ?>
   	<?php endwhile; ?>
    </div>
  </main>
<?php get_footer(); ?>