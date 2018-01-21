<footer id="footer">
      <section class="footer-main">
        <div class="container">
                <a href="/" class="footer-logo-box"></a>
                <nav class="footer-menus">
                    <div class="footer-center-ul">
                        <aside class="footer-right-ul">
                          <?php wp_nav_menu( array( 'theme_location' => 'footer-menu-center' ) ); ?>
                        </aside>
                        </div>
                    </div>
                </nav>
        </div>
      </section>
      <section class="all-rights">
         <div class="container">
           <div class="row">
             <p class="col-sm-6 col-xs-12"><?php _e('© 2000-2017 Kota Service Ltd. All rights reserved.', 'your-textdomain'); ?></p>
             <div class="col-xs-6 right-footer-items">
               <a href="http://3web-studio.com/" target="_blank" class="text-right">
                  Design § development
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/3-web.png">
                </a>
            </div>
           </div>
         </div>
      </section>
</footer>
</div>
    <link rel="stylesheet" href="/wp-content/themes/custom-template/assets/dist/css/style.css">
    <link rel="stylesheet" href="/wp-content/themes/custom-template/style.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/wp-content/themes/custom-template/assets/dist/js/slick/slick.css">
    <link rel="stylesheet" href="/wp-content/themes/custom-template/assets/dist/js/aos-master/dist/aos.css">
    <link rel="stylesheet" href="/wp-content/themes/custom-template/assets/dist/js/slick/slick-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="/wp-content/themes/custom-template/assets/dist/js/sticky-footer.js"></script>
    <script src="/wp-content/themes/custom-template/assets/dist/js/slick/slick.min.js"></script>
    <script src="/wp-content/themes/custom-template/assets/dist/js/scripts.min.js"></script>
    <script src="/wp-content/themes/custom-template/assets/dist/js/aos-master/dist/aos.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/wp-content/themes/custom-template/assets/dist/js/slick-items.js"></script>
    <?php wp_footer(); ?>
  </body>
</html>