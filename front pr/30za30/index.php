<?php get_header(); ?>
</div>
  <main id="content">
  	<div class="page-content">
  	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
       <?php the_content(); ?>
   	<?php endwhile; ?>
    </div>
  </main>
<?php get_footer(); ?>