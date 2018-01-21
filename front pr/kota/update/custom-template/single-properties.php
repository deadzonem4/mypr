<?php
/**
 * WP Post Template: Post Template
 *
 */
?>
<?php get_header('new'); ?>
	<main id="content" class="post-detail">
	
	<div class="pages-title"><div class="container"><h1 class="pages-title" itemprop="headline"><span itemprop="name"><?php the_title(); ?><?php if(function_exists('pf_show_link')){echo pf_show_link();} ?></span></h1></div></div>
		<div class="container">
		<div class="row">
		<section id="blog-post" class="post-content">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<article class="col-sm-12 post-article single-es-view" id="post-<?php the_ID(); ?>"<?php post_class(); ?> itemscope itemtype="http://schema.org/Article" >


		
	   
	       <?php do_action( 'es_before_single_content' ); ?>
    <div class="es-wrap">
        <div class="es-single es-single-<?php echo $es_settings->single_layout; ?>">

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                

                <!-- <?php es_the_address( '<div class="es-address">', '</div>' ); ?> -->

                <?php do_action( 'es_single_tabs' ); ?>

                <div class="es-info" id="es-info">
                     <!-- <h2>
	                    <div class="es-cat-price">
	                        <?php es_the_categories( '<span class="es-category-items">', '', '</span>' ) ?>
	                        <?php es_the_formatted_price( '<span class="es-price">', '</span>' ); ?>
	                    </div>
                	</h2> -->
                    <?php do_action( 'es_single_info' ); ?>
                   
                </div>

                <div class="es-tabbed">

                    <?php if ( $sections = Es_Property_Single_Page::get_sections() ) : ?>
                        <?php foreach ( $sections as $id => $section ) : ?>
                            <?php if ( 'es-info' == $id ) continue; ?>
                            <?php if ( ! empty( $section['render_action'] ) ) : ?>
                                <?php do_action( $section['render_action'], $id, $section ); ?>
                            <?php else: ?>
                                <?php do_action( 'es_single_render_tab', $id, $section ); ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php do_action( 'es_property_after_tabs', $es_property ); ?>
                </div>

            </article>
        </div>
    </div>
<?php do_action( 'es_after_single_content' );?>
	   

</article>
<?php endwhile; ?>
	</section>
	<section class="popular-listing">
			<div class="container">
				<h4 class="dark-grey-heading"><?php _e('Similar', 'your-textdomain'); ?></h4>
				<div class="most-popular">
					<?php echo do_shortcode('[es_featured_props]'); ?>
				</div>
			</div>
</section>
		</div>
		</div>
        <div class="cf-by-id">
            <?php if(ICL_LANGUAGE_CODE=='en'): ?>
                <?php echo do_shortcode('[contact-form-7 id="3813" title="Property id form"]'); ?>
            <?php elseif(ICL_LANGUAGE_CODE=='bg'): ?>
                <?php echo do_shortcode('[contact-form-7 id="3815" title="Property id form_copy"]') ?>
            <?php endif;?>            
        </div>
	</main>	
<?php get_footer(); ?>