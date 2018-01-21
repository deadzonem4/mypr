<?php
/*
Template Name: Builder - No Top Padding
*/
?>
<?php get_header(); ?> 

<div class="homebuilder builder container_alt">
    
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <?php the_content(); ?>
    
    <?php endwhile; endif; ?>
        
	<div class="clearfix"></div>

<?php get_footer(); ?>

