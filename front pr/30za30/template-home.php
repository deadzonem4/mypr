<?php
/*
Template Name: Home
*/
?>
<?php get_header('index'); ?>
<script>
    var ml_webform_613872 = ml_account('webforms', '613872', 'q9f1d5', 'load');
    ml_webform_613872('animation', 'fadeIn');
</script>
<section id="section_1">
  <div class="container">
    <?php if ( is_active_sidebar( 'section-1' ) ) : ?>
      
    <?php dynamic_sidebar( 'section-1' ); ?>

    <?php endif; ?>
  </div>
  <div class="container">
  <!-- Trigger the modal with a button -->

  <button type="button" class="btn btn-info btn-lg popup-btn_1" data-toggle="modal" data-target="#myPopup">Включи се в кампанията сега</button>
  
  </div>
</section>
</div>
<script>
    var ml_webform_613900 = ml_account('webforms', '613900', 'j0c8f6', 'load');
    ml_webform_613900('animation', 'fadeIn');
</script>
<section id="section_2">
  <div class="container">
    <?php if ( is_active_sidebar( 'section-2' ) ) : ?>
      
    <?php dynamic_sidebar( 'section-2' ); ?>
     
    <?php endif; ?>
  </div>
</section>

<section id="section_3">
  
  <div class="container">
    <div class="section3-title">
      <h1>ТЕ СЕ ВКЛЮЧИХА</h1>
      <p>Запознай се с нашите ентусиасти</p>
    </div>
    <div class="row row-eq-height">
    <div class="col-md-2"></div>
    <?php 
    $people = new WP_Query( array(
        'post_type' => 'people',
        'posts_per_page' => 3,
        'post_status' =>
        'publish',
        'orderby' => 'post_date',
        'order' => 'DESC',
        'max_num_pages' => 3,
      ) ); 

      while($people -> have_posts()) : $people -> the_post(); ?>
      <div class="col-md-4">
        <div class="max-width-block text-center">
          <div class="hover-box">
            <?php the_post_thumbnail(); ?></div>
          <p class="section3-name"><?php the_title(); ?></p>
          <p class="section3-text"><?php the_content(); ?></p>
          <div class="fb-icon-sec3">
            <?php 
              $fb_field = get_field('facebook_account');
              if( !empty($fb_field)): ?>
              <a target="_blank" class="fb-icon" href="<?php the_field('facebook_account') ?>"><i class="fa fa-facebook" style="font-size: 20px;"></i></a>
            <?php endif; ?>
            <?php 
              $twitter_field = get_field('twitter_account');
              if (!empty($twitter_field)):
            ?>
              <a target="_blank" class="fb-icon" href="<?php the_field('twitter_account') ?>"><i class="fa fa-twitter" style="font-size: 20px;"></i></a>
            <?php endif; ?>
             <?php 
              $website_field = get_field('website_account');
              if (!empty($website_field)):
            ?>
              <a target="_blank" class="fb-icon" href="<?php the_field('website_account') ?>"><i class="website-icon">W</i></a>
            <?php endif; ?>

          </div>
        </div>
      </div>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
    </div>
    <p class="section3-text-bottom">Искаш да си един от нас?</p>
    <button class="btn btn-info btn-lg btn-section3 " type="button" data-toggle="modal" data-target="#myPopup">Включи се и ти!</button>
  </div>
</section>

<section id="section_4">
  <div class="container-fluid">
    <div class="row">
    
    <?php if ( is_active_sidebar( 'section-4' ) ) : ?>
      
    <?php dynamic_sidebar( 'section-4' ); ?>
    
    <?php endif; ?>
    <div class="section4">

      <?php 

        $image1 = get_field('first_image');
        $url1 = $image1['url'];
        $image2 = get_field('second_image');
        $url2 = $image2['url'];
        $image3 = get_field('third_image');
        $url3 = $image3['url'];
        $image4 = get_field('fourth_image');
        $url4 = $image4['url'];
        $image5 = get_field('fifth_image');
        $url5 = $image5['url'];
        $image6 = get_field('sixth_image');
        $url6 = $image6['url'];
        $image7 = get_field('seventh_image');
        $url7 = $image7['url'];
        $image8 = get_field('eighth_image');
        $url8 = $image8['url'];

        ?>
        <div class="parent">
          <a href="<?php echo $url1; ?>" class="zoom-img box-img1 foobox" style="background-image:url(<?php echo $url1; ?>)">
            <div class="overlay"><img class="imgimg" src="/wp-content/uploads/2017/10/Zoom_button.png" /></div>
          </a>
        </div>
        <div class="parent">
          <a href="<?php echo $url2; ?>" class="zoom-img box-img2 foobox"  style="background-image:url(<?php echo $url2; ?>)">     
            <div class="overlay"><img class="imgimg" src="/wp-content/uploads/2017/10/Zoom_button.png" /></div>
          </a> 
        </div>
        <div class="parent">
          <a href="<?php echo $url3; ?>" class="zoom-img box-img3 foobox" style="background-image:url(<?php echo $url3; ?>)">      
            <div class="overlay"><img class="imgimg" src="/wp-content/uploads/2017/10/Zoom_button.png" /></div>
          </a> 
        </div>
        <div class="parent">
          <a  href="<?php echo $url4; ?>" class="zoom-img box-img4 foobox"  style="background-image:url(<?php echo $url4; ?>)">
            <div class="overlay"><img class="imgimg" src="/wp-content/uploads/2017/10/Zoom_button.png" /></div>
          </a>
        </div>
        <div class="parent">
          <a href="<?php echo $url5; ?>" class="zoom-img box-img5 foobox" style="background-image:url(<?php echo $url5; ?>)">
            <div class="overlay"><img class="imgimg" src="/wp-content/uploads/2017/10/Zoom_button.png" /></div>
          </a>
        </div>
        <div class="parent">
          <a href="<?php echo $url6; ?>" class="zoom-img box-img6 foobox" style="background-image:url(<?php echo $url6; ?>)">
            <div class="overlay"><img class="imgimg" src="/wp-content/uploads/2017/10/Zoom_button.png" /></div>
          </a>
        </div>
        <div class="parent">
          <a href="<?php echo $url7; ?>" class="zoom-img box-img7 foobox" style="background-image:url(<?php echo $url7; ?>)">
            <div class="overlay"><img class="imgimg" src="/wp-content/uploads/2017/10/Zoom_button.png" /></div>
          </a>
        </div>
        <div class="parent">
          <a href="<?php echo $url8; ?>" class="zoom-img box-img8 foobox" style="background-image:url(<?php echo $url8; ?>)">
            <div class="overlay"><img class="imgimg" src="/wp-content/uploads/2017/10/Zoom_button.png" /></div>
          </a>
        </div>
      </div>
    </div>
    <p class="section4-text-bottom">Имаш снимки и искаш да ги покажеш</p>
    <?php echo do_shortcode('[contact-form-7 id="57" title="Contact form image upload"]');?>
    
    <button class="btn btn-info btn-lg btn-section4 " type="button" data-toggle="modal" data-target="#myModal5">Сподели снимките си с нас!</button>
  </div>
</section>
<section id="section_5">
  <div class="container">
    <div class="section3-title">
      <h1>НЕ ПРОПУСКАЙ НАШИТЕ СЪБИТИЯ</h1>
      <p class="section5-text">Полезна информация за това, което предстои</p>
    </div>    
    <div class="section5-box">
      <div class="section5-box-title">
        <p class="titlebox-sec5">Предстоящи събития</p>
      </div>
      <?php 
          $events = new WP_Query( array(
              'post_type' => 'events',
              'posts_per_page' => 5,
              'post_status' =>
              'publish',
              'orderby' => 'post_date',
              'order' => 'ASC',
              'max_num_pages' => 5,
            ) ); 

            while($events -> have_posts()) : $events -> the_post(); 
          ?>
      <div class="section5-box-info clearfix">
        <div class="box-date">
          <?php 
            $date = get_field('event_date');
            $dateFields = explode("-",$date);
            $day = $dateFields[2];
            $month = $dateFields[1];
            switch ($month) {
                case "01":
                    $name = 'Ян';
                    break;
                case "02":
                    $name = 'Феб';
                    break;
                case "03":
                    $name = 'Мар';
                    break;
                case "04":
                  $name = 'Апр';
                  break;
                case "05":
                  $name = 'Май';
                  break;
                case "06":
                  $name = 'Юни';
                  break;
                case "07":
                  $name = 'Юли';
                  break;
                case "08":
                  $name = 'Авг';
                  break;
                case "09":
                  $name = 'Сеп';
                  break;
                case "10":
                  $name = 'Окт';
                  break;
                case "11":
                  $name = 'Ное';
                  break;
                case "12":
                  $name = 'Дек';
                  break;
                default:
                    echo $name = '0';;
            } 
          ?>
          <p class="date-num"><?php echo $day ?></p>
          <p class="date-ab"><?php echo $name ?></p>
        </div>
        <div class="box-info">
          <p class="text-info1"><a href="<?php the_field('link_to_event') ?>"><?php the_title(); ?></a></p>
          <p class="text-info2"><?php the_content(); ?></p>
          <p class="text-info3"><?php the_field('event_author'); ?></p>
        </div>
      </div>
  <?php endwhile; ?>
    <?php wp_reset_query(); ?>
</div>
        
    
  </div>
</section>

<section id="section_6">
  <div class="container">
    <div class="row">
    
    <?php if ( is_active_sidebar( 'section-6' ) ) : ?>
      
    <?php dynamic_sidebar( 'section-6' ); ?>
     
    <?php endif; ?>
    
    </div>
  </div>
</section>
<div class="modal fade" id="myPopup" role="dialog">
  <div id="mlb2-6565368" class="ml-subscribe-form ml-subscribe-form-6565368">
    <div class="ml-vertical-align-center">
        <div class="subscribe-form ml-block-success" style="display:none">
            <div class="form-section">
                <h4>Започни сега!</h4>
                <p>Благодаря ви! Вие се абонирахте успешно.</p>
            </div>
        </div>
        <form class="ml-block-form" action="https://app.mailerlite.com/webforms/submit/c5a1a3" data-id="614508" data-code="c5a1a3" method="POST" target="_blank">
           <div class="run-icon"><img src="/wp-content/uploads/2017/07/group-101.png"></div>
            <div class="subscribe-form">
                <div class="form-section mb10">
                    <h4>Започни сега!</h4>
                    <p style="text-align: center;"><span style="font-size: 20px;">Ти си на една стъпка от нашата кампания</span></p>
                    <p style="text-align: center;" class="modal-explain"><span style="font-size: 14px;">Единственото, което ни трябва е твоето име и е-мейл и ние ще ти изпратим наръчника</span></p>
                </div>
                <div class="form-section">
                    <div class="form-group ml-field-name ml-validate-required">
                        <input type="text" name="fields[name]" class="form-control" placeholder="Твоето име..." value="" autocomplete="name" x-autocompletetype="name" spellcheck="false" autocapitalize="off" autocorrect="off">
                    </div>
                    <div class="form-group ml-field-email ml-validate-required ml-validate-email">
                        <input type="email" name="fields[email]" class="form-control" placeholder="Твоят е-мейл..." value="" autocomplete="email" x-autocompletetype="email" spellcheck="false" autocapitalize="off" autocorrect="off">
                    </div>
                </div>
                <input type="hidden" name="ml-submit" value="1" />
                <button type="submit" class="primary">
                    Започни
                </button>
                <button disabled="disabled" style="display: none;" type="button" class="loading">
                    <img src="https://static.mailerlite.com/images/rolling@2x.gif" width="20" height="20" style="width: 20px; height: 20px;">
                </button>
            </div>
        </form>
        <script>
            function ml_webform_success_6565368() {
                var $ = ml_jQuery || jQuery;

                $('.ml-subscribe-form-6565368 .ml-block-success').show();
                $('.ml-subscribe-form-6565368 .ml-block-form').hide();
            };
        </script>
    </div>
  </div>
</div>
<div class="modal fade" id="myPopupImg" role="dialog">
  <div id="mlb2-6572446" class="ml-subscribe-form ml-subscribe-form-6572446">
      <div class="ml-vertical-align-center">
          <div class="subscribe-form ml-block-success" style="display:none">
              <div class="form-section">
                  <h4>Започни сега!</h4>
                  <p>Благодаря Ви! Успешно изпратихте снимките.</p>
              </div>
          </div>
          <form class="ml-block-form" action="https://app.mailerlite.com/webforms/submit/q0m4b0" data-id="615442" data-code="q0m4b0" method="POST" target="_blank">
            <div class="run-icon"><img src="/wp-content/uploads/2017/07/group-101.png"></div>
              <div class="subscribe-form">
                  <div class="form-section mb10">
                      <h4>Започни сега!</h4>
                      <p style="text-align: center;"><span style="font-size: 20px;">Ти си на една стъпка от нашата кампания</span></p>
                      <p style="text-align: center;" class="modal-explain"><span style="font-size: 14px; color: #a8a8a8;">Единственото, което ни трябва е твоето име и е-мейл и ние ще ти изпратим наръчника</span></p>
                  </div>
                  <div class="form-section">
                      <div class="form-group ml-field-name ml-validate-required">
                          <input type="text" name="fields[name]" class="form-control" placeholder="Твоето име..." value="" autocomplete="name" x-autocompletetype="name" spellcheck="false" autocapitalize="off" autocorrect="off">
                      </div>
                      <div class="form-group ml-field-email ml-validate-required ml-validate-email">
                          <input type="email" name="fields[email]" class="form-control" placeholder="Твоят е-мейл..." value="" autocomplete="email" x-autocompletetype="email" spellcheck="false" autocapitalize="off" autocorrect="off">
                      </div>
                      <div>
                          <input type="file" name="fields[file]">
                    </div> 
                  </div>
                  <input type="hidden" name="ml-submit" value="1" />
                  <button type="submit" class="primary">
                      Изпрати
                  </button>
                  <button disabled="disabled" style="display: none;" type="button" class="loading">
                      <img src="https://static.mailerlite.com/images/rolling@2x.gif" width="20" height="20" style="width: 20px; height: 20px;">
                  </button>
              </div>
          </form>
          <script>
              function ml_webform_success_6572446() {
                  var $ = ml_jQuery || jQuery;

                  $('.ml-subscribe-form-6572446 .ml-block-success').show();
                  $('.ml-subscribe-form-6572446 .ml-block-form').hide();
              };
          </script>
      </div>
  </div>
</div>



<script type="text/javascript" src="https://static.mailerlite.com/js/w/webforms.min.js?v3772b61f1ec61c541c401d4eadfdd02f"></script>



<?php get_footer('index'); ?>
</div>





