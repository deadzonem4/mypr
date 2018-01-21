<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>
<main id="content">
	<div class="banner-background">
	 <section class="banner-image text-right">
    <div class="container">
        <p class="text-uppercase text">Welcome to the site of</p>
        <h1 class="text"><strong>London’s premier</strong> End of Tenancy<br/> Cleaning Specialists.</h1>
        <div class="text-content-banner text">
          <p class="text">Our phone lines are open 7 days a week, 24/7. Cleaning of the oven is included free of charge in our end of tenancy cleaning. We do also provide great discounts when booking two or more services together. Call today to find out more.</p>
        </div>
        <a href="#scrollToContent" class="index-scroll text-center"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Scroll_1.gif" alt="Scroll"></a>
    </div>
   </section>	
	</div>
  <section class="our-services">
    <div class="our-services-heading text-center container">
      <h2 id="scrollToContent" class="text-uppercase"><span class="bold">Our </span> services</h2>
      <div class="grey-line"></div>
      <div class="text-content-services">
        <p class="text">We have been providing <span class="bold">professional end of tenancy cleaning services</span> for almost a decade.Our brand is associated with excellent customer service and professionalism. Rest assured that our cleaning team will return your property to its former glory.</p>
      </div>
    </div>
    <div class="grey-box-service">
      <div class="container">
        <div class="row">
  
          <aside class="lcol-serv-cont services-container col-md-4 col-sm-6 col-xs-6">
            <ul class="list-unstyled left-col">
              <li class="index-service clearfix">
                <a href="">
                    <object id="svg1" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/006-wiping-swipe-for-floors.svg" type="image/svg+xml"></object>
                    <p>
                      <span class="bold">End of Tenancy</span>
                      <span>Cleaning</span>
                    </p>
                </a>
              </li>
              <li class="index-service clearfix">
                <a href="">
                    <object id="svg1" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/shape.svg" type="image/svg+xml"></object>
                    <p>
                      <span class="bold">Carpet</span>
                      <span>Cleaning</span>
                    </p>
                </a>
              </li>
              <li class="index-service clearfix">
                <a href="">
                    <object id="svg1" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/006-wiping-swipe-for-floors.svg" type="image/svg+xml"></object>
                    <p>
                      <span class="bold">Deep</span>
                      <span>Cleaning</span>
                    </p>
                </a>
              </li>
              <li class="index-service clearfix">
                <a href="">
                    <object id="svg1" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/003-keys.svg" type="image/svg+xml"></object>
                    <p>
                      <span class="bold">After Builders</span>
                      <span>Cleaning</span>
                    </p>
                </a>
              </li>
            </ul>
          </aside>
  
          <div class="col-sm-4 hidden-sm hidden-xs">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/service-image-1@2x.png" alt="services-image">
          </div>
  
          <aside class="col-md-4 col-sm-6 col-xs-6 rcol-serv-cont services-container">
            <ul class="list-unstyled right-col">
              <li class="index-service clearfix">
                <a href="">
                    <object id="svg1" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/006-wiping-swipe-for-floors.svg" type="image/svg+xml"></object>
                    <p>
                      <span class="bold">Move in/out</span>
                      <span>Cleaning</span>
                    </p>
                </a>
              </li>
              <li class="index-service clearfix">
                <a href="">
                    <object id="svg1" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/shape.svg" type="image/svg+xml"></object>
                    <p>
                      <span class="bold">One Off</span>
                      <span>Cleaning</span>
                    </p>
                </a>
              </li>
              <li class="index-service clearfix">
                <a href="">
                    <object id="svg1" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/006-wiping-swipe-for-floors.svg" type="image/svg+xml"></object>
                    <p>
                      <span class="bold">Removals</span>
                      <span>Services</span>
                    </p>
                </a>
              </li>
              <li class="index-service clearfix">
                <a href="">
                    <object id="svg1" data="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/003-keys.svg" type="image/svg+xml"></object>
                    <p>
                      <span class="bold">Uphostery</span>
                      <span>cleaning</span>
                    </p>
                </a>
              </li>
            </ul>
          </aside>
        </div>
      </div>
    </div>
</section>   
<section class="deposit-back">
  <div class="container text-right">
    <h3 class="text">Get Your Full <span class="bold">Deposit Back!</span></h3>
    <div class="text-content-deposit text">
      <p class="text">Unlike other cleaning companies who don’t offer any guarantees at all, we are giving you an adequate guarantee period of 48h. This means that if we have missed anything and you let us know within 48h of completion, we’ll come back to re-clean free of charge. Don’t waste your time and money by hiring someone incapable of completing the job. If you are looking for hassle free cleaning service hire our professional team today. </p>
    </div>
    <a class="text" href="tel:02086140730">Call 0208 6140 730</a>
  </div>
</section>
<section class="index-form">
  <div class="container">
    <div class="text-center">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/end-of-tenancy-cleaning-logo.jpg" alt="Eco friendly badge">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clensa-green-clean-scheme-badge.jpg" alt="Green Clean Scheme badge">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/satisfactionguarantee.jpg" alt="100% Satisfaction Guarantee badge">
    </div>
    <?php echo do_shortcode( '[contact-form-7 id="68" title="Index form"]' ); ?>
  </div>
</section>
</main>
<?php get_footer(); ?>
</div>
