<?php
/**
 * WP Post Template: Post Template
 *
 */
?>
<?php get_header('new'); ?>
	<main id="content" class="post-detail">
	<div class="pages-title"><div class="container"><h1 class="pages-title"><?php _e('Useful', 'your-textdomain'); ?></h1></div></div>
		<div class="container">
		<div class="row">
		<section id="blog-post" class="post-content">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<article class="col-sm-12 post-article" id="post-<?php the_ID(); ?>"<?php post_class(); ?> itemscope itemtype="http://schema.org/Article" >
<meta itemscope itemprop="mainEntityOfPage" content=""  itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>"/>
	<div class="row">
	<div class="post-article-cont col-sm-8">
		<h2 itemprop="headline"><span itemprop="name"><?php the_title(); ?></span></h2>
		<div class="additional-inf">
    		<!-- <?php the_date('Y-m-d', '<p class="single-post-time" itemprop="datePublished"><img src="http://kota.24s.us/wp-content/themes/custom-template/assets/images/002-clock.svg"><span itemprop="dateModified">', '</span</p>'); ?>
    		<p class="single-post-author "><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/001-user-silhouette.svg"><span itemprop="author" itemscope itemtype="http://schema.org/Person"> <span itemprop="name"><?php the_author(); ?></span></span></p> -->
		</div>
		<div class="featured-img" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
					<?php 
						if ( has_post_thumbnail() ) {
		    				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		    			if ( ! empty( $large_image_url[0] ) ) {
		        		echo '<a itemprop="url" href="' . esc_url( $large_image_url[0] ) . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
		        		echo get_the_post_thumbnail( $post->ID, 'medium' ); 
		        		echo '</a>';
		    			}
					} ?>
			<meta itemprop="width" content="500">
    		<meta itemprop="height" content="200">
		</div>
	    <div class="entry" itemprop="text">
	       <p><span itemprop="description"><?php the_content(); ?></span></p>
	   
	    </div>
    </div>
    <div class="right-sidebar col-sm-4">
			<div class="right-sidebar-post clearfix">
				<h2><?php _e('More posts ', 'your-textdomain'); ?></h2>
				<?php $the_query = new WP_Query( 'posts_per_page=20' ); ?>
				 
				<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
				<div class="right-post-cont col-sm-12">
						<a href="<?php the_permalink() ?>"><h4><?php the_title(); ?></h4>
						</a>
	<!-- 					<div>
						<p class="single-post-author "><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/001-user-silhouette.svg"><span itemprop="author" itemscope itemtype="http://schema.org/Person"> <span itemprop="name">
						<?php the_author(); ?></span></span>
						</p>
						<span class="entry-date"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/002-clock.svg"><?php echo get_the_date(); ?></span>
						</div> -->
				</div>					 
				<?php 
				endwhile;
				wp_reset_postdata();
				?>
			</div>
    </div>
    </div>
</article>
<?php endwhile; ?>
	</section>
		</div>
		</div>
	</main>	
<!--End mc_embed_signup-->
<?php get_footer(); ?>






