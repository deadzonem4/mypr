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
    <?php wp_footer(); ?>
  </body>
</html>