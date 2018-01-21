<?php
/*
Template Name: Search
*/
?>
<?php get_header('new'); ?>
<main id="content">
<div class="pages-title mb30">
<div class="container">
<h1><?php the_title() ?></h1>
</div>
</div>
<div class="container">
<section class="prop-search">
<?php the_content() ?>
<?php dynamic_sidebar( 'estatik-search' ); ?>
</section>
</div>
</main>
<?php get_footer(); 