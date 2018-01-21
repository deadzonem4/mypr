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
        <header id="header">
            <section class="black-line">
                <div class="container">
                    <div class="black-line-content">
                        <div class="upper-header pull-left">
                            <img src="<?php echo bloginfo('template_directory'); ?>/assets/images/phone.png" alt="phone image"/>
                            <p>Phone lines and customer support available 24/7 - 0208 6140 730</p>
                        </div>
                        <div class="pull-right">
                            <button type="button">Free instant quote</button>
                        </div>
                    </div>
                </div>
            </section>
            <section class="header-menu">
                <div class="container">
                    <div class="header-menu-content">
                        <a href="http://cleanandclean.24s.us/">
                            <img src="<?php echo bloginfo('template_directory'); ?>/assets/images/logo.png" alt="phone image"/>
                        </a>
                         <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?> 

                         <div class="hamburger">
                            <span class="glyphicon glyphicon-menu-hamburger"></span>
                        </div>
                    </div>
                 </div>
            </section>

        </header>





















        