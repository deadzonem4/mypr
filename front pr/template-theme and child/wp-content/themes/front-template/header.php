<!DOCTYPE html>
<html>
	<head>
        <meta name="format-detection" content="telephone=no">
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
    	<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?php wp_head(); ?>
	</head>
	<body>
         <header id="header" class="index-page">
            <div class="container">
                <div class="header-placeholder">
                                <a class="logo" href="http://localhost/template/">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.svg">
                                </a>
                                     <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
                                <div class="hamburger">
                                <span class="glyphicon glyphicon-menu-hamburger"></span>
                                </div>
                </div>
            </div>
        </header>




















        