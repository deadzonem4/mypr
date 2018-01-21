<!DOCTYPE html>
<html>
	<head>
        <meta name="format-detection" content="telephone=no">
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
    	<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png">
    	<link rel="icon" type="image/ico" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png">
        <!-- Global Site Tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107387138-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments)};
          gtag('js', new Date());

          gtag('config', 'UA-107387138-1');
        </script>
		<?php wp_head(); ?>
	</head>
	<body>
            <header id="header">
                <section class="upper-header">
                    <div class="container">
                        <ul class="contact-box">
                            <li>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/phone.svg">
                                <p><a href="tel:0888 450 539"><?php _e('+359 888 450 539', 'new'); ?></a> / <a href="tel:0887 930 667"><?php _e('+359 887 930 667', 'new'); ?></a></p>
                            </li>
                            <li>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mail.svg">
                                <p><a href="mailto:office@kotabg.eu">office@kotabg.net</a></p>
                            </li>
                        </ul>

                        <div class="language-box">
                            <a href="/bg/"><img src="/wp-content/uploads/flags/phpTWDjOE" alt="bulgarian"></a>
                             <a href="/en/"><img src="/wp-content/uploads/flags/phpIyosc7" alt="english"></a>
                        </div>
                        
                    </div>
                </section>
                <section class="header-menu">
                    <div class="container">
                        <div class="header-menu-content">
                            <?php if(ICL_LANGUAGE_CODE=='en'): ?>
                                <a href="/en/" rel="Home">
                                    <div class="header-logo-box"> 
                                    </div>
                                </a>

                            <?php elseif(ICL_LANGUAGE_CODE=='bg'): ?>
                                <a href="/bg/" rel="Home">
                                    <div class="header-logo-box"> 
                                    </div>
                                </a>
                            <?php endif;?>
                            <div class="pages-menu">
                             <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?> 
                             <div class="hamburger">
                                <span class="glyphicon glyphicon-menu-hamburger"></span>
                            </div>
                            </div>
                        </div>
                     </div>
                </section>
            </header>