<?php
/**
 * Blog Template
 */
?>
<?php get_header('new'); ?>

<main id="content" role="main">
<div id="blog-page" class="container">
	<h1 class="pages-heading-one">Check our video tutorials</h1>
	<h3 class="pages-heading-three">Why is our app so helpfull</h3>
	<section id="posts-container" class="clearfix posts-container">
	<?php query_posts('post_type=post&post_status=publish&paged='. get_query_var('paged')); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	   	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
			<div class="post-image">
       			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
       		</div>
			<section class="post-summary">
               	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="post-excerpt"><?php the_excerpt(__('Continue reading »','example')); ?></div>
				<div class="read-more"><a class="moretag" href="<?php the_permalink(); ?>"> READ MORE <span class="glyphicon glyphicon-menu-right"></span></a></div>
			</section>
           </article>
    <?php endwhile; ?>

	<?php if (function_exists("pagination")) {
	    pagination($additional_loop->max_num_pages);
	} ?>

	<?php else: ?>
		<div id="post-404" class="noposts">
		    <p><?php _e('None found.','example'); ?></p>
	    </div><!-- /#post-404 -->
	<?php endif; wp_reset_query(); ?>
		
	</section>
	<div class="post-navigation">
			<?php echo paginate_links( array(
	         'prev_text' => 'Prev',
	         'next_text' => 'Next',
	       )); ?>
	     
	</div>

</div>

</main><!-- .site-main -->
<?php get_footer(); ?>