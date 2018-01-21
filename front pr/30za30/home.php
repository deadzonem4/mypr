<?php
/**
 * Blog Template
 */
?>
<?php get_header(); ?>
</div>
<main id="content" role="main">
	<div class="background-gray">
		<div class="container">
			<h1>Блог</h1>
			<div class="breadcrumb"><?php the_breadcrumb(); ?></div>
		</div>
	</div>	
<div id="blog-page" class="container">
	
	<section id="posts-container" class="clearfix posts-container col-md-9">
	<?php query_posts('post_type=post&post_status=publish&paged='. get_query_var('paged')); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	   	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
			<div class="post-image">
       			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('small'); ?></a>
       		</div>
			<section class="post-summary">
               	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
               	<div>
		   			<span class="time_post"><img src="/wp-content/uploads/2017/10/002-clock.png" alt=""><?php echo get_the_time('g:i, d/m/Y '); ?></span>
		   			<span class="author_post"><img src="/wp-content/uploads/2017/10/001-user-silhouette.png" alt=""><?php the_author(); ?> </span>
	   			</div>
				<div class="post-excerpt"><?php the_excerpt(__('Continue reading »','example')); ?></div>
				<!-- <div class="read-more"><a class="moretag" href="<?php the_permalink(); ?>"> READ MORE <span class="glyphicon glyphicon-menu-right"></span></a></div> -->

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
	<div class="sidebar col-md-3">
				<?php if ( is_active_sidebar( 'category' ) ) : ?>
		      
			    <?php dynamic_sidebar( 'category' ); ?>
	     
	    		<?php endif; ?>
	</div>
	<div class="post-navigation">
			<?php echo paginate_links( array(
	         'prev_text' => 'Prev',
	         'next_text' => 'Next',
	       )); ?>
	     
	</div>

</div>

</main><!-- .site-main -->
<?php get_footer(); ?>