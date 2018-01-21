<footer id="footer">
      <div class="container footer-main">
          <nav class="row footer-menus">
            <a class="footer-logo" href="/" >
                  <div class="footer-img">
                      <img  src="/wp-content/uploads/2017/10/logo-30-copy@2x.png"  alt="30za30 logo">
                  </div>
            </a>
            <div class="footer-left-ul">
              <?php wp_nav_menu( array( 'theme_location' => 'footer-menu-left' ) ); ?>
            </div>
            <div class="dev-logo" >
              <?php if ( is_active_sidebar( 'footer-text' ) ) : ?>
      
              <?php dynamic_sidebar( 'footer-text' ); ?>
               
              <?php endif; ?>
            </div>
            
          </nav>
      </div>
</footer>

</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo bloginfo('template_directory'); ?>/assets/dist/js/sticky-footer.js" defer></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" >

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js" defer></script>
    <noscript id="deferred-styles">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    </noscript>
    <script>
      var loadDeferredStyles = function() {
        var addStylesNode = document.getElementById("deferred-styles");
        var replacement = document.createElement("div");
        replacement.innerHTML = addStylesNode.textContent;
        document.body.appendChild(replacement)
        addStylesNode.parentElement.removeChild(addStylesNode);
      };
      var raf = requestAnimationFrame || mozRequestAnimationFrame ||
          webkitRequestAnimationFrame || msRequestAnimationFrame;
      if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
      else window.addEventListener('load', loadDeferredStyles);
    </script>
    <!-- <script src="<?php echo bloginfo('template_directory'); ?>/assets/dist/js/scripts.min.js" defer></script> -->   
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" defer></script>
    <script src="<?php echo bloginfo('template_directory'); ?>/assets/dist/js/scripts.min.js" defer></script>

    <?php wp_footer(); ?>
  </body>
</html>