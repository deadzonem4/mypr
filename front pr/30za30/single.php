<?php
/**
 * WP Post Template: Post Template
 *
 */
?>
<?php get_header(); ?>
</div>
	<main>
		<div class="background-gray">
			<div class="container">
				<h1>Блог</h1>
				<div class="breadcrumb"><?php the_breadcrumb(); ?></div>
			</div>
		</div>	
		<div class="container">
		<section id="blog-post" class="post-content col-md-9">
			<!-- <div class="inner clearfix top-post-nav">
				<div class="back-to-blog"><a href="/блог"><span class="glyphicon glyphicon-menu-left"></span>Back</a></div>
			</div> -->
			<article class="inner">
			<?php if (have_posts()) :
				   while (have_posts()) :
				      the_post(); 

				  ?>			
				<h1><?php the_title(); ?></h1>
					<div>
			   			<span class="time_post single-post"><img src="/wp-content/uploads/2017/10/002-clock.png" alt=""><?php echo get_the_time('g:i, d/m/Y '); ?></span>
			   			<span class="author_post single-post"><img src="/wp-content/uploads/2017/10/001-user-silhouette.png" alt=""><?php the_author(); ?> </span>
	   			</div>
				<div class="featured-img">
					<?php 
						if ( has_post_thumbnail() ) {
		    				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
		    			if ( ! empty( $large_image_url[0] ) ) {
		        		echo '<a class="foobox" href="' . esc_url( $large_image_url[0] ) . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
		        		echo get_the_post_thumbnail( $post->ID, array( 750, 350) ); 
		        		echo '</a>';
		    			}
					} ?> 
				</div>
				<div class="blog-post-content">
				<?php the_content(); ?>
				</div>
				<?php  endwhile; endif; wp_reset_query();?>
			</article>
			<div class="grey-box-share-post">
				<div class="inner" style="text-align:center;">
		
				</div>
			</div>
		</section>
		<div class="sidebar col-md-3">
				<?php if ( is_active_sidebar( 'category' ) ) : ?>
		      
			    <?php dynamic_sidebar( 'category' ); ?>
	     
	    		<?php endif; ?>
		</div>
		</div>
	</main>	
<!--End mc_embed_signup-->
<?php get_footer(); ?>
