<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>
<main id="content">	
  <section class="banner-image text-left">
    <div class="container">
    <div class="row">
    <div class="image-fix clearfix">
        <div class="build-left-col col-xs-6">
           <img class="build-image"  src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-5.png">
           <p>
             Measure every part of your body. Get a free statistics. Choose your own measure schedule. Download now for free!
           </p>
            <div class="social-img">
            <a href="#">
             <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/app-small.png">
             </a>
             <a href="#">
             <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/google-small.png">
             </a>
            </div>
        </div>
         <div class="build-right-col col-sm-6 col-xs-12">
           <img class="dissapear"  src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-4.png">
           <img class="apear"  src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-4-small.png">
        </div>
        <div class="social-img apear col-xs-12">
            <a href="#">
             <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/app-small.png">
             </a>
             <a href="#">
             <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/google-small.png">
             </a>
          </div>
        </div>
    </div>
    </div>
  </section>
  <section class="video-section">
    <div class="container">
      <div class="row">
      <div class="col-sm-12">
        <h2 class="h2-headings"> Check our introduction video</h2>
        <h4 class="h4-headings">Why is our app so helpful</h4>
        </div>
        <div class="video-widget">
          <?php dynamic_sidebar( 'video' ); ?>
          <?php dynamic_sidebar( 'video-text-left' ); ?>
          <?php dynamic_sidebar( 'video-text-center' ); ?>
          <?php dynamic_sidebar( 'video-text-right' ); ?>
        </div>
      </div>
    </div>
  </section>
  <section class="phone-section">
    <div class="container">
    <div class="row">
    <div class="phone-section-container col-sm-12">
      <h2 class="h2-headings"> Check our introduction video</h2>
      <h4 class="h4-headings">Why is our app so helpful</h4>
      <img class="dissapear" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-9.png">
      <img class="apear" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-9-small.png">
      </div>
      </div>
    </div>
  </section>
  <section class="grey-line">
  <div class="movin-banner">
  </div>
  </section>
  <section class="gadget-section">
  <div class="container">
    <div class="row">
      <div class="gadget-left-col col-sm-7 dissapear">
         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-12.png">
      </div>
      <div class="gadget-right-col col-sm-5 col-xs-12">
      <h2 class="gadget-heading ">Make your body a work of art</h2>
        <div class="clearfix"></div>
        <div class="red-line"></div>
        <div class="clearfix"></div>
        <?php dynamic_sidebar( 'list' ); ?>
        <div class="gadget-left-col apear">
         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-12.png">
        </div>
        <div class="social-img-down">
            <a href="#">
             <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/app-small.png">
             </a>
             <a href="#">
             <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/google-small.png">
             </a>
            </div>
      </div>
    </div>
  </div>
  </section>
</main>
<?php get_footer(); ?>
