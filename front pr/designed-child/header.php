<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head><meta charset="<?php bloginfo( 'charset' ); ?>">

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="icon" type="image/ico" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon_72x72.ico">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-98420002-1', 'auto');
ga('send', 'pageview');

</script>
<?php wp_head(); ?>

</head>

     
<body <?php body_class(); ?>>

<div class="wrapper <?php 
	$themnific_redux = get_option( 'themnific_redux' ); 
	if($themnific_redux['tmnf-uppercase'] == '1') echo 'upper ';
	$header_styling = $themnific_redux['tmnf-header-layout']; echo esc_attr($header_styling);
?>
">

    <div id="mainhead">
    
		<?php
            // ticker - start
            $themnific_redux = get_option( 'themnific_redux' ); 
            if(empty($themnific_redux['tmnf-ticker-position'])){} elseif($themnific_redux['tmnf-ticker-position'] == 'pos_above'){
            include( get_template_directory() . '/includes/mag-topnav.php' );}
            // ticker - end
        ?>
        
        <div id="header" itemscope itemtype="http://schema.org/WPHeader">
        
        	<div class="container">
    			<?php include( get_template_directory() . '/includes/mag-headad.php'); ?>
                
                <div id="titles" class="tranz">
                    
                    <?php if(empty($themnific_redux['tmnf-main-logo']['url'])) { ?>
                        
                        <h1><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name');?></a></h1>
                            
                    <?php } 
                            
                        else { ?>
                                    
                            <a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
                            
                                <img class="tranz" src="<?php echo esc_url($themnific_redux['tmnf-main-logo']['url']);?>" alt="<?php bloginfo('name'); ?>"/>
                                    
                            </a>
                            
                    <?php } ?>	
                
                </div><!-- end #titles  -->

                
                
                <div class="clearfix"></div>
                
                <div class="navhead clearfix">
                    
                    <nav id="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement"> 
                    
						<?php if(empty($themnific_redux['tmnf-small-logo']['url'])) { } else { ?>   
                                <a class="nav-logo tranz" href="<?php echo esc_url(home_url('/')); ?>"><img class="tranz" src="<?php echo esc_url($themnific_redux['tmnf-small-logo']['url']);?>" alt="<?php bloginfo('name'); ?>"/></a>
                        <?php } ?>	
                    
                        <?php include( get_template_directory() . '/includes/mag-navigation.php'); ?>
                        
                    </nav>
                
                	<a id="navtrigger" class="ribbon clearfix" href="#"><i class="fa fa-bars"></i></a>
                    
    				<a class="searchtrigger" href="#" ><i class="fa fa-search"></i></a>
                 
                	<div class="clearfix"></div>
                    
                </div><!-- end .navhead  -->  
                 
                <div class="clearfix"></div>
                  
        	</div><!-- end .container  -->
        
        </div><!-- end #header  -->
        
        <div class="afterhead">
    
		<?php
            // ticker - start
            $themnific_redux = get_option( 'themnific_redux' ); 
            if(empty($themnific_redux['tmnf-ticker-position'])){} elseif($themnific_redux['tmnf-ticker-position'] == 'pos_below'){
            include( get_template_directory() . '/includes/mag-topnav.php' );}
            // ticker - end
        ?>
        
        </div>
    
    </div><!-- end #mainhead  -->

<div class="wrapper">