<?php get_header(); ?>

<div class="container">

	<div class="post-wrapper woo-site postbarLeft ghost">

         <div id="content" class="eightcol first">
         
            <div id="woo-inn">
        
                <?php woocommerce_content(); ?>
                
            </div>    
    
        </div><!-- #content -->
        
        <div id="sidebar"  class="fourcol woocommerce">
        
            <?php if ( is_active_sidebar( 'tmnf-shop-sidebar' ) ) { ?>
            
                <div class="widgetable ghost">
                
                    <div class="sidewrap">
        
                    <?php dynamic_sidebar("Shop Sidebar") ?>
                    
                    </div>
                
                </div>
            
            <?php } ?>
               
        </div><!-- #sidebar -->
    
	</div><!-- .post-wrapper  -->
    
</div>

<?php get_footer(); ?>