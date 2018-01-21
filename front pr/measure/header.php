<!DOCTYPE html>
<html>
	<head>
        <meta name="format-detection" content="telephone=no">
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
    	<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta property="og:image" content="http://me-apps.com/wp-content/themes/measure/assets/images/group-4.png" />
    	<meta property="og:description" content="Build your body with our app" />
    	<meta property="fb:app_id" content="966242223397117" />
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png">
    	<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png">
                <script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-99787424-1', 'auto');
ga('send', 'pageview');

</script>
		<?php wp_head(); ?>
	</head>
	<body>
            <header id="header">
                <section class="header-menu">
                    <div class="container">
                        <div class="header-menu-content">
                            <a href="http://me-apps.com/">
                                <div class="header-logo-box"> 
                                </div>
                            </a>
                             <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?> 
                             <div class="hamburger">
                                <span class="glyphicon glyphicon-menu-hamburger"></span>
                            </div>
                        </div>
                     </div>
                </section>
            </header>





















        