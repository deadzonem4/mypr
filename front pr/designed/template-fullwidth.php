<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>

<div class="container">

	<div id="core" class="fullcontent">
        
    	<div class="entry entryfull">
        
        	<h1 class="entry-title"><?php the_title(); ?></h1>
        
        	<div class="hrlineB"></div>
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <?php the_content(); ?>
            
            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
            
            <?php endwhile; endif; ?>
            
       	</div>
        
	</div> 
    
<div class="clearfix"></div>
    
<?php get_footer(); ?>