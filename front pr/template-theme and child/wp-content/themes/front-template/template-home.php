<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>
<main id="content">
            <section class="main-banner">
                <div class="container">
                    <div class="main-banner-headings">
                        <h1>Tutorials Kit</h1>
                        <h3>Безплатна тема, която е създадена за използване в уроците на <a target="_blank" href="https://tutorials.bg/"> Tutorials.bg</a></h3>
                    </div>
                </div>
            </section>
            <section class="main-content">
                <div class="container">
                    <div class="main-intro-text">
                        <p>Lorem Ipsum е елементарен примерен текст, използван в печатарската и типографската индустрия. Lorem Ipsum е индустриален стандарт от около 1500 година, когато неизвестен печатар взема няколко печатарски букви и ги разбърква</p>
                    </div>
                    <div class="row">
                        <div class="main-widgets clearfix">
                            <div class="col-sm-4 left-widget">
                                <div class="widget-image">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/left-widget.svg">
                                </div>
                                <div class="widget-content">
                                    <h4>Huge Number of Components</h4>
                                    <p>Lorem Ipsum е елементарен примерен текст, използван в печатарската и типографската индустрия. Lorem Ipsum е индустриален стандарт</p>
                                </div>     
                            </div>
                            <div class="col-sm-4 center-widget">
                                <div class="widget-image">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/center-widget.svg">
                                </div>
                                <div class="widget-content">
                                    <h4>Multi-Purpose Sections</h4>
                                    <p>Lorem Ipsum е елементарен примерен текст, използван в печатарската и типографската индустрия. Lorem Ipsum е индустриален стандарт</p>
                                </div>                            
                            </div>
                            <div class="col-sm-4 right-widget">
                                <div class="widget-image">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/right-widget.svg">
                                </div>
                                <div class="widget-content">
                                    <h4>Example Pages</h4>
                                    <p>Lorem Ipsum е елементарен примерен текст, използван в печатарската и типографската индустрия. Lorem Ipsum е индустриален стандарт</p>
                                </div>                                
                            </div>
                        </div>
                        <div class="main-services clearfix">
                            <div class="col-sm-5 service-content-box">
                                <h4>Huge Number of Components</h4>
                                <h5>The core elements of your website</h5>
                                <p>Lorem Ipsum е елементарен примерен текст, използван в печатарската и типографската индустрия. Lorem Ipsum е индустриален стандарт от около 1500 година, когато неизвестен печатар взема няколко печатарски букви и ги разбърква, за да напечата с тях книга с примерни шрифтове. Този начин не само е оцелял повече от 5 века, но е навлязъл и в публикуването на електронни издания като е запазен</p>
                            </div>
                            <div class="col-sm-7 service-image-box">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/components.png">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        
<?php get_footer(); ?>
