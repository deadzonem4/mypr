<?php
/**
 * WP Post Template: Post Template
 *
 */
?>
<?php get_header('new'); ?>
	<main id="content" class="post-detail">
		<div class="container">
		<div class="row">
		<section id="blog-post" class="post-content">
			<div class="inner clearfix top-post-nav">
				<div class="back-to-blog"><a href="/tutorials"><span class="glyphicon glyphicon-menu-left"></span> Back</a></div>
			</div>
			<div class="blog-post-heading">
				<h1 class="pages-heading-one">Check our video tutorials</h1>
				<h3 class="pages-heading-three">Why is our app so helpfull</h3>
			</div>
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<article class="col-sm-12 post-article" id="post-<?php the_ID(); ?>"<?php post_class(); ?> itemscope itemtype="http://schema.org/Article" >
<meta itemscope itemprop="mainEntityOfPage" content=""  itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>"/>
<div class="featured-img col-md-8 col-md-offset-0 col-sm-offset-2 col-sm-8" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
					<?php 
						if ( has_post_thumbnail() ) {
		    				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		    			if ( ! empty( $large_image_url[0] ) ) {
		        		echo '<a itemprop="url" href="' . esc_url( $large_image_url[0] ) . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
		        		echo get_the_post_thumbnail( $post->ID, 'medium' ); 
		        		echo '</a>';
		    			}
					} ?>
					<meta itemprop="width" content="800">
    		<meta itemprop="height" content="800">
				</div>
    <div class="entry-content col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
    <h2 itemprop="headline"><span itemprop="name"><?php the_title(); ?></span></h2>
	<div class="additional-info">
    <p class="single-post-author ">by<span itemprop="author" itemscope itemtype="http://schema.org/Person"> <span itemprop="name"><?php the_author(); ?></span></span></p>
    <div class="separate-line"></div>
    <?php the_date('Y-m-d', '<p class="single-post-time" itemprop="datePublished"><span itemprop="dateModified">', '</span</p>'); ?>
    </div>
    <div class="entry" itemprop="text">
       <p><span itemprop="description"><?php the_content(); ?></span></p>
   
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