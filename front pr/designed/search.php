<?php get_header(); ?>
    
<div class="container builder woocommerce">

<div id="core">

	<div id="content" class="eightcol first">

        <h2 class="archiv"><span class="maintitle"><?php echo esc_attr($s); ?></span>
        <span class="subtitle"><?php esc_html_e('Search Results','designed');?> </span></h2> 
    
    	<?php if (have_posts()) : ?>

          <div class="blogger">
                                    
                <?php while (have_posts()) : the_post(); ?>
                        
                        <?php if(has_post_format('aside')){} else {
                        	include( get_template_directory() . '/post-types/home-classic-small.php');
                        }?>
                        
				<?php endwhile; ?><!-- end post -->
                    
           	</div><!-- end latest posts section-->
            
            <div class="clearfix"></div>

					<div class="pagination"><?php designed_pagination('&laquo;', '&raquo;'); ?></div>

					<?php else : ?>
			

                            <div class="errorentry entry">
                
                                <h2 class="post entry-title" itemprop="headline"><?php esc_html_e('We could not find any results for your search','designed');?></h2>
                                
                                <?php get_search_form(); ?>
                            
                                <h4><?php esc_html_e('Perhaps You will find something interesting from these lists...','designed');?></h4>
                            
                                <div class="hrline"></div>
                            
                                <?php include( get_template_directory() . '/includes/uni-404-content.php');?>
                            
                            </div>
                        
                        
                        
                        
					<?php endif; ?>
    
    </div><!-- end #content -->
    
    
    <?php get_sidebar(); ?>
    
	<div class="clearfix"></div>
    
</div><!-- end #core -->
    
<div class="clearfix"></div>

<?php get_footer(); ?>