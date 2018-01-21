<?php get_header(); ?>
  <main id="content" class="basic-template">
  	<section class="page-content container">
  		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); the_content();
		endwhile; else: ?>
		<p>Page Not Found.</p>
		<?php endif; ?>
  	</div>
  </section>
  </main>
<?php get_footer(); ?>