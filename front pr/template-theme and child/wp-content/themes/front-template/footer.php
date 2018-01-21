<footer id="footer">
  <div class="container">
    <div class="footer-placeholder">
      <div class="footer-logo-box">
        <a href="http://localhost/template/">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/footer-logo.svg">
        </a>
      </div>
      <ul class="footer-menu">
        <li class="social"><a href="#"><i class="fa fa-facebook fa-lg"></i></a></li>
        <li class="social"><a href="#"><i class="fa fa-twitter fa-lg"></i></a></li>
        <li class="social"><a href="#"><i class="fa  fa-linkedin fa-lg"></i></a></li>
        <li class="social"><a href="#"><i class="fa fa-google-plus fa-lg"></i></a></li>
        <li class="line"></li>
        <li class="footer-text"><a target="_blank" href="https://tutorials.bg/">Tutorials.bg 2017</a></li>
      </ul>
    </div>
  </div>
</footer>


<script src="<?php echo bloginfo('template_directory'); ?>/assets/dist/js/sticky-footer.js" defer></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <noscript id="deferred-styles">
      <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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