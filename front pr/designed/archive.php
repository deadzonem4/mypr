<?php get_header(); ?>
    
<div class="container builder woocommerce">

<div id="core" class="blog_archive">

	<div id="content" class="eightcol first">
    
            <?php if (is_category()) { ?>
    			<h2 class="archiv"><span class="maintitle"><?php single_cat_title(); ?></span>
    			<span class="subtitle"><?php echo strip_tags(category_description()); ?> </span></h2>     
        
            <?php } elseif (is_day()) { ?>
            
    			<h2 class="archiv"><span class="maintitle"><?php the_time( get_option( 'date_format' ) ); ?></span>
    			<span class="subtitle"><?php esc_html_e('Archive','designed');?></span></h2>  

            <?php } elseif (is_month()) { ?>
            
    			<h2 class="archiv"><span class="maintitle"><?php the_time( 'F, Y' ); ?></span>
    			<span class="subtitle"><?php esc_html_e('Archive','designed');?></span></h2>  

            <?php } elseif (is_year()) { ?>
            
    			<h2 class="archiv"><span class="maintitle"><?php the_time( 'Y' ); ?></span>
    			<span class="subtitle"><?php esc_html_e('Archive','designed');?></span></h2>  

            <?php } elseif (is_author()) { ?>
            
    			<h2 class="archiv"><span class="maintitle"><?php  $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); echo esc_attr($curauth->nickname);?></span>
                <span class="subtitle"><?php esc_html_e( 'Author','designed' ); ?></span></h2>  
                <div class="authorpage">
                    <?php echo esc_attr($curauth->user_description); ?>
                </div>
                
            <?php } elseif (is_tag()) { ?>
            
    			<h2 class="archiv"><span class="maintitle"><?php echo single_tag_title( '', true); ?></span>
    			<span class="subtitle"><?php esc_html_e('Tag Archive','designed');?></span></h2>  
            
            <?php } ?>
    
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

<div class="clearfix"></div>

<?php get_footer(); ?>