<!DOCTYPE html>
<html>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
    	<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon1.png">
    	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png">
    	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/apple-touch-icon-180x180.png">

		<?php wp_head(); ?>
	</head>
	<body>
        <div class="massive-wrapper">
             <div class="background1">
    	   	   <header id="header" role="banner">
    	         <nav class="middle-navbar navbar container">
    	         	<div class="col-sm-2 col-md-3 logo-container">
	                  <a href="/" class="high-resolution-photo">
	                     <div class="main-logo">
	                        <img  src="/wp-content/uploads/2017/10/Logo30.png"  alt="30za30 logo">
	                     </div>
	                   </a>
                	</div>
                        <button type="button" class="navbar-toggle collapsed" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        	<div class="row">
                        		
                                    <div class="hdropdown">
                                        <div class="col-sm-10 col-md-9 top-menu">
                                            <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
                                            <a class="facebook-icon" target="_blank" href="https://www.facebook.com/groups/186669548526686/?fref=ts"></a>
                                        	
                                        </div>
                                        
                                    </div>
    	         	           
                            </div>
                    	
                    	</div>
                    </nav>
            
                </header>