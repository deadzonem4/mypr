<footer id="footer">
      <section class="footer-main">
        <div class="container">
                <nav class="row footer-menus">
                    <div class="col-md-4 col-sm-4 col-xs-4 footer-left-ul">
                       <?php dynamic_sidebar( 'footer-text' ); ?>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-8 footer-center-ul col-md-offset-1 col-sm-offset-1">
                      <h6 class="footer-headings">Services</h6>
                    </div>
                    <div class="col-md-4  col-sm-4 col-xs-4 col-md-offset-1 col-sm-offset-1 footer-right-ul">
                      <?php wp_nav_menu( array( 'theme_location' => 'footer-menu-left' ) ); ?>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-4 footer-right-ul">
                      <?php wp_nav_menu( array( 'theme_location' => 'footer-menu-center' ) ); ?>
                    </div>
                    
                </nav>
        </div>
      </section>
      <section class="all-rights">
         <div class="container">
           <div class="row">
             <p class="col-xs-12">Copyright @ 2017 Clean & Clean</p>
           </div>
         </div>
      </section>
</footer>
</div>
<script src="<?php echo bloginfo('template_directory'); ?>/assets/dist/js/sticky-footer.js" defer></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" >

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
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
    <script src="<?php echo bloginfo('template_directory'); ?>/assets/dist/js/scripts.min.js" defer></script>   
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" defer></script>


    <?php wp_footer(); ?>
  </body>
</html>