<?php
/*
Template Name: Home
*/
?>
<?php get_header('new'); ?>
<main id="content">
		<section class="top-slider">
			<div class="container">
				<div class="row">
			    <?php 
					$loop = new WP_Query( array(
					    'post_type' => 'slider',
					    'posts_per_page' => 0,
					    'post_status' =>
					    'publish',
					    'orderby' => 'title',
					    'order' => 'ASC'
					) ); ?>
					<div class="slider">
					<?php while($loop -> have_posts()) : $loop -> the_post(); ?>
					<?php 
						$pl = get_field('property_language');
						
						if(is_page(3830)):
					?>
						<?php if($pl == "bg"){ ?> 
							<div class="slide">
								<div class="col-xs-12 slider-appear">
									<div class="slide-prop-image">
										<?php echo get_the_post_thumbnail( $loop->ID, array( 520, 320),array( 'class' => 'img-responsive' ) ); ?>
									</div>
								</div>
								<div class="col-xs-6 text-center">
									<p class="slide-prop-name"><?php the_field('property_name'); ?></p>
									<p class="slide-prop-desc"><?php the_field('short_description'); ?></p>
									<p class="slide-prop-price"><?php the_field('property_price'); ?></p>
									<a class="slide-prop-link" href="<?php the_field('property_link'); ?>"><?php _e('See more ', 'your-textdomain'); ?> </a>
								</div>
								<div class="col-xs-6 slider-disappear">
									<div class="slide-prop-image">
										<?php echo get_the_post_thumbnail( $loop->ID, array( 520, 320),array( 'class' => 'img-responsive' ) ); ?>

									</div>
								</div>
							</div>
							<?php } ?>
						<?php else: ?>
							<div class="slide">
								<div class="col-xs-12 slider-appear">
									<div class="slide-prop-image">
										<?php echo get_the_post_thumbnail( $loop->ID, array( 520, 320),array( 'class' => 'img-responsive' ) ); ?>
									</div>
								</div>
								<div class="col-xs-6 text-center">
									<p class="slide-prop-name"><?php the_field('property_name'); ?></p>
									<p class="slide-prop-desc"><?php the_field('short_description'); ?></p>
									<p class="slide-prop-price"><?php the_field('property_price'); ?></p>
									<a class="slide-prop-link" href="<?php the_field('property_link'); ?>"><?php _e('See more ', 'your-textdomain'); ?> </a>
								</div>
								<div class="col-xs-6 slider-disappear">
									<div class="slide-prop-image">
										<?php echo get_the_post_thumbnail( $loop->ID, array( 520, 320),array( 'class' => 'img-responsive' ) ); ?>

									</div>
								</div>
							</div>
						<?php endif; ?> 
					<?php endwhile; ?>
				 	</div>
				</div>
			</div> 
		</section>
		<section class="sort">
			<div class="container">
				<div class="row">
					<div class="col-xs-4"  data-aos="fade-right"
     data-aos-duration="1000"
     data-aos-easing="ease-in-sine">
							<div class="sort-box sort-box-left">
								<img class="dis-left" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-2-grey.svg">
								<img class="show-left" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-2.svg">
								<h4><?php _e('Rents', 'new'); ?></h4>
								<p><?php _e('View real estate rent listings.', 'new'); ?></p>
								<div class="sort-button">
								<div class="more">
										<?php icl_link_to_element(197,'page',__('More', 'textaadomain')); ?>
										<i class="fa fa-angle-right"></i>
									</div>
								</div>
							</div>
					</div>
					<div class="col-xs-4" data-aos="fade-up"
     data-aos-easing="linear"
     data-aos-duration="500">
							<div class="sort-box sort-box-center">
								<img class="dis-center" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-14-grey.svg">
								<img class="show-center" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-14.svg">
								<h4><?php _e('Sales', 'new'); ?></h4>
								<p><?php _e('See current offers for sale of properties!', 'new'); ?></p>
								<div class="sort-button">
									<div class="more">
										<?php icl_link_to_element(199,'page',__('More', 'textaadomain')); ?>
										<i class="fa fa-angle-right"></i>
									</div>
								</div>
							</div>
					</div>
					<div class="col-xs-4" data-aos="fade-left"
     data-aos-easing="linear"
     data-aos-duration="1000">
							<div class="sort-box sort-box-right">
								<img class="dis-right" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-15-grey.svg">
								<img class="show-right" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-15.svg">
								<h4><?php _e('Search', 'new'); ?></h4>
								<p><?php _e('Search listings by type and price', 'new'); ?></p>
								<div class="sort-button">
									<div class="more">
										<?php icl_link_to_element(212,'page',__('More', 'textaadomain')); ?>
										<i class="fa fa-angle-right"></i>
									</div>
							</div>
					</div>
				</div>
			</div>
		</section>
		<section class="popular-listing" data-aos="zoom-in" data-aos-duration="1200">
			<div class="container">
				<h4 class="dark-grey-heading"><?php _e('Most viewed properties', 'your-textdomain'); ?></h4>
				<div class="most-popular">
					<?php echo do_shortcode('[es_featured_props]'); ?>
				</div>
			</div>
		</section>
		<section class="special-offer" data-aos="zoom-in" data-aos-duration="1200">
			<div class="container">
				<h4 class="dark-grey-heading"><?php _e('Our newest properties', 'your-textdomain'); ?></h4>
				<div class="most-popular">
					<?php echo do_shortcode('[es_my_listing sort="recent" posts_per_page="12"]'); ?>
				</div>
			</div>
		</section>
		<section class="useful">
			<div class="spec-post clearfix">
				<div class="container">
				<h2><strong><?php _e('Useful information ', 'your-textdomain'); ?></strong></h2>
				<?php 
				/* if it is root page */
				if (is_page(3830)){
				$the_query = new WP_Query( 'posts_per_page=16' ); 
								 
				if ( $the_query->have_posts() ) {
				    while ( $the_query->have_posts() ) {
				 
				        $the_query->the_post(); 
						$post_language_information = wpml_get_language_information($post->ID);
						$post_locale = $post_language_information['locale'];
						if($post_locale == 'bg_BG'){
				        ?>
						<div class="single-spec-post col-sm-3 col-xs-6 pd5" data-aos="flip-left"
     data-aos-duration="2300">
							
							<div class="post-overflow">
								<a href="<?php the_permalink() ?>"><h4><?php the_title(); ?></h4>
									<span><img class="post-view-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-23.svg"></span>
								</a></div>
								<div class="useful-img">
								<?php 
									if ( has_post_thumbnail() ) {
					    				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
					    			if ( ! empty( $large_image_url[0] ) ) {
					        		echo '<a itemprop="url" href="' . esc_url( $large_image_url[0] ) . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
					        		echo get_the_post_thumbnail( $post->ID, 'medium' ); 
					        		echo '</a>';
					    			}
								} ?></div>
						</div>
				        
				 
				    <?php }
						}
					}
				} else{
					/* rest locales */
					$the_query = new WP_Query( 'posts_per_page=8' );
					if ( $the_query->have_posts() ) {
				    while ( $the_query->have_posts() ) {
				 
				        $the_query->the_post(); 
				        ?>
						<div class="single-spec-post col-sm-3 col-xs-6 pd5" data-aos="flip-left"
     data-aos-duration="2300">
							
							<div class="post-overflow">
								<a href="<?php the_permalink() ?>"><h4><?php the_title(); ?></h4>
									<span><img class="post-view-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-23.svg"></span>
								</a></div>
								<div class="useful-img">
								<?php 
									if ( has_post_thumbnail() ) {
					    				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
					    			if ( ! empty( $large_image_url[0] ) ) {
					        		echo '<a itemprop="url" href="' . esc_url( $large_image_url[0] ) . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
					        		echo get_the_post_thumbnail( $post->ID, 'medium' ); 
					        		echo '</a>';
					    			}
								} ?></div>
						</div>
				        
				 
				    <?php }
						}
					}
				
				wp_reset_postdata();
				?>
				
			</div>
			</div>
		</section>
		<section class="partners-slider container" data-aos="fade-left" data-aos-duration="1500">
			<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
    <!-- Wrapper for slides -->
    			<h4><?php _e('Our partners', 'your-textdomain'); ?></h4>
			    <div class="carousel-inner">
			      <div class="item active">
			      	<div class="slider-item">
			      	<a  target="_blank" href="http://dogovor.at/inovaciyata/">
			        	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/1.jpg">
			        </a>
			        </div>
			        <div class="slider-item">
			        <a  target="_blank" href="https://www.postbank.bg/bg-BG/Individuals/05MortgageLoans/">
				        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/2.jpg">
				    </a>
			        </div>
			        <div class="slider-item">
			        <a  target="_blank" href="http://www.dbank.bg/bg/mortgage-credits">
				        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/3.jpg">
				    </a>
				    </div>
				    <div class="slider-item">
			        <a  target="_blank" href="http://www.sgeb.bg/bg/jilishtni-krediti/jilishten-kredit-za-pokupka-na-imot.html">
				        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/4.jpg">
				    </a>
				    </div>
			       </div>
			       <div class="item">
				        <div class="slider-item">
				        <a  target="_blank" href="https://www.piraeusbank.bg/">
				        	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/5.jpg">
				        </a>
				        </div>
				        <div class="slider-item">
				        <a  target="_blank" href="http://www.sportalm.at/en">
					        <img class="healt60" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/6.jpg">
					    </a>
				        </div>
				       	<div class="slider-item">
				        <a  target="_blank" href="https://www.unicreditbulbank.bg/bg/individualni-klienti/">
					        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/7.jpg">
					    </a>
				        </div>
				        <div class="slider-item">
				        <a  target="_blank" href="http://www.coca-cola.bg/bg/home/">
					        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/8.jpg">
					    </a>
				        </div>
			        </div>
			        <div class="item">
				        <div class="slider-item">
				        <a  target="_blank" href="https://www.heineken.com/bg/agegateway?returnurl=%2fbg%2fAgeGateway.aspx">
					        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/9.jpg">
					    </a>
				        </div>
				        <div class="slider-item">
				        <a  target="_blank" href="#">
					        <img class="he90" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/10.jpg">
					    </a>
				        </div>
				        <div class="slider-item">
				        <a  target="_blank" href="http://www.dm-drogeriemarkt.bg/bg_homepage/">
					        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/11.jpg">
					    </a>
				        </div>
				        <div class="slider-item">
				        <a  target="_blank" href="http://niva.bg/">
					        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/12.jpg">
					    </a>
				        </div>
			       </div>
			       <div class="item">
				        <div class="slider-item last-slide">
				        <a  target="_blank" href="http://www.brra.bg/">
					        <img class="he60" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/13.jpg">
					    </a>
				        </div>
				        <div class="slider-item last-slide">
				        <a  target="_blank" href="http://www.cadastre.bg/">
					        <img class="he60" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/14.jpg">
					    </a>
				        </div>
				    </div>
			    </div>
			    <!-- Left and right controls -->
			    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
			      <span class="fa fa-angle-left"></span>
			      <span class="sr-only">Previous</span>
			    </a>
			    <a class="right carousel-control" href="#myCarousel" data-slide="next">
			      <span class="fa fa-angle-right"></span>
			      <span class="sr-only">Next</span>
			    </a>
  			</div>
		</section>

</main>
<?php get_footer(); ?>


<?php if(ICL_LANGUAGE_CODE=='bg'): ?>
<script>
	$(".sort-box-left").click(function() {
    window.location = "/наеми";
});
	$(".sort-box-center").click(function() {
    window.location = "/продажби";
});
	$(".sort-box-right").click(function() {
    window.location = "/търсене";
});
</script>


<?php elseif(ICL_LANGUAGE_CODE=='en'): ?>
<script>
	$(".sort-box-left").click(function() {
    window.location = "/rent/?lang=en";
});
	$(".sort-box-center").click(function() {
    window.location = "/sales/?lang=en";
});
	$(".sort-box-right").click(function() {
    window.location = "/search/?lang=en";
});
</script>
<?php endif;?>
<script>
    AOS.init();
</script>