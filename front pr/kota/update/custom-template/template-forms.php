<?php
/*
Template Name: Book form
*/
?>
<?php get_header(); ?>
  <main id="content">
    <div class="page-content tutorials">
    	<div class="container">
      		<div class="homebuilder builder container_alt">
    
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); the_content();
		endwhile; else: ?>
		<p>Page Not Found.</p>
		<?php endif; ?>
        
	<div class="clearfix"></div>
      	</div>
    </div>
  </main>
<?php get_footer(); ?>
