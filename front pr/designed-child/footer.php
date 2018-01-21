</div><!-- /.container -->

	<div class="footer-fix"></div>
    
    <?php $themnific_redux = get_option( 'themnific_redux' );if (empty($themnific_redux['tmnf-social-bottom-dis'])) {} else { ?>

	<div class="footer-icons ghost p-border">
    
    	<div class="container"> 
	
			<?php 
				$themnific_redux = get_option( 'themnific_redux' );
				if($themnific_redux['tmnf-mailchimp'] == ''){echo'';} else { echo do_shortcode(esc_attr($themnific_redux['tmnf-mailchimp'])),'' ;} 
				
				include( get_template_directory() . '/includes/uni-social.php');	
			?>
        
        </div>
        
    </div>
    
    <?php } ?>

    <div id="footer">
    
        <div class="container woocommerce"> 
        
            <?php include( get_template_directory() . '/includes/uni-bottombox.php');?>
            
            <div class="clearfix"></div>
            
            <div id="copyright">
            
                <div class="footer-logo clearfix">
        
					 <?php if(empty($themnific_redux['tmnf-footer-logo']['url'])) { }
                            
                        else { ?>
                                    
                            <a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
                            
                                <img class="tranz" src="<?php echo esc_url($themnific_redux['tmnf-footer-logo']['url']);?>" alt="<?php bloginfo('name'); ?>"/>
                                    
                            </a>
                            
                    <?php } ?>
                    
                </div>
                
                
                <?php echo '<p>' . esc_attr($themnific_redux['tmnf-footer-editor']) . '</p>' ?>
                
                <?php if ( function_exists('has_nav_menu') && has_nav_menu('bottom-menu') ) {wp_nav_menu( array( 'depth' => 1, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_class' => 'bottom-menu', 'menu_id' => '' , 'theme_location' => 'bottom-menu') );}  ?>
                
                <div class="clearfix"></div>
                      
            </div> 
        
        </div>
            
    </div><!-- /#footer  -->
    
    
</div><!-- /.wrapper  -->

<div id="curtain" class="tranz">
	
	<?php get_search_form();?>
    
    <a class='curtainclose rad' href="#" ><i class="fa fa-times"></i></a>
    
</div>
    
<div class="scrollTo_top ribbon">

    <a title="<?php esc_html_e('Scroll to top','designed');?>" class="rad" href="#">
    
    	<i class="fa fa-chevron-up"></i> 
        
    </a>
    
</div>
</div><!-- /.upper class  -->

<?php wp_footer(); ?>
<script src="">
    var header = $('#mainhead').outerHeight();
           var footer = $('#footer').outerHeight();
           var val = header + footer;
           $('.homebuilder').css('min-height','calc(100vh - '+val+'px)');
</script>
</body>
</html>