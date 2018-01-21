<?php get_header(); ?>
    


<div class="container builder woocommerce">
	
<?php // blog content - start ?>
    
<div id="core" class="blog_index">

	<div id="content" class="eightcol first">
            
          <div class="blogger">
          
                	<?php
						if ( get_query_var('paged') ) {
							$paged = get_query_var('paged');
						} else if ( get_query_var('page') ) {
							$paged = get_query_var('page');
						} else {
							$paged = 1;
						}
						query_posts( array( 'post_type' => 'post', 'paged' => $paged ) );
					?>
					<?php if (have_posts()) : ?>
                                        
                    <?php while (have_posts()) : the_post(); ?>
                        
                        <?php if(has_post_format('quote')){include( get_template_directory() . '/post-types/quote-loop.php' );} else {
                        	include( get_template_directory() . '/post-types/home-classic-small.php');
                        }?>
                            
					<?php endwhile; ?><!-- end post -->
                    
           	</div><!-- end latest posts section-->
            
            <div class="clearfix"></div>

					<div class="pagination"><?php designed_pagination('&laquo;', '&raquo;'); ?></div>

					<?php else : ?>
			

                            <div class="errorentry entry ghost">
                
                                <h1 class="post entry-title" itemprop="headline"><?php esc_html_e('Nothing found here','designed');?></h1>
                            
                                <h4><?php esc_html_e('Perhaps You will find something interesting from these lists...','designed');?></h4>
                            
                                <div class="hrline"></div>
                            
                                <?php include( get_template_directory() . '/includes/uni-404-content.php');?>
                            
                            </div>
                        
                        
                        </div><!-- end latest posts section-->
                        
                        
					<?php endif; ?>
    
    </div><!-- end #content -->
    
    
    <?php get_sidebar(); ?>
    
	<div class="clearfix"></div>
    
</div><!-- end #core -->
	
<?php // blog content - end ?>

<?php get_footer(); ?>