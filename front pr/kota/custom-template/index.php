<?php
/*
Template Name: Book form
*/
?>
<?php get_header('new'); ?>
  <main id="content">
    <div class="page-content">
     <?php dynamic_sidebar( 'video' ); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); the_content();
		endwhile; else: ?>
		<p>Page Not Found.</p>
		<?php endif; ?>

    </div>
  </main>
<?php get_footer(); ?>