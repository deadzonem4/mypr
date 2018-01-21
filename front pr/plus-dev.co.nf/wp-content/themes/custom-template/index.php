<?php
/*
Template Name: Book form
*/
?>
<?php get_header('new'); ?>
  <main id="content">
    <div class="page-content">
    <div class="container">
    	<div class="row">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); the_content();
		endwhile; else: ?>
		<p>Page Not Found.</p>
		<?php endif; ?>

    		</div>
    	</div>
    </div>
  </main>
<?php get_footer(); ?>