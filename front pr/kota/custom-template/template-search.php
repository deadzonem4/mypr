<?php
/*
Template Name: Search
*/
?>
<?php get_header('new'); ?>
<div class="pages-title mb30">
<div class="container">
<h1><?php the_title() ?></h1>
</div>
</div>
<main id="content">
<section class="prop-search">
<?php dynamic_sidebar( 'video' ); ?>
</section>
</main>
<?php get_footer(); ?>