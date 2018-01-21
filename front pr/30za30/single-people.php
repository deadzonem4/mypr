<?php
/**
 * WP Post Template: People Template
 *
 */
?>
<?php get_header(); ?>

	<main>
		<div class="container">
		<section id="blog-post" class="post-content">
			<div class="inner clearfix top-post-nav">
				<div class="back-to-blog"><a href="/blog"><span class="glyphicon glyphicon-menu-left"></span> Back</a></div>
			</div>
			<article class="inner">
				<h1><?php the_title(); ?></h1>
				<div class="featured-img">
					<!--<?php 
						if ( has_post_thumbnail() ) {
		    				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
		    			if ( ! empty( $large_image_url[0] ) ) {
		        		echo '<a href="' . esc_url( $large_image_url[0] ) . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
		        		echo get_the_post_thumbnail( $post->ID, 'large' ); 
		        		echo '</a>';
		    			}
					} ?> -->
				</div>
				<div class="blog-post-content">
				<?php the_content(); ?>
				</div><!-- .blog-post-content -->
			</article><!-- .inner -->
			<div class="grey-box-share-post">
				<div class="inner" style="text-align:center;">
		
				</div>
			</div>
		</section>
		</div>
	</main>	
<!--End mc_embed_signup-->
<?php get_footer(); ?>
