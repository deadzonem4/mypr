<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="container">

<div id="core" class="tmnf-page">

<div class="postbar">

    <div id="content" class="eightcol first">
    
		<div <?php post_class('item_inn  p-border'); ?>>

            <div class="entry">
        
                    <h1 class="post entry-title"><?php the_title(); ?></h1>
                
                    <div class="hrlineB p-border"></div>
                    
                    <?php the_content(); ?>
                    
                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . esc_html__( 'Pages:','designed') . '</span>', 'after' => '</div>' ) ); ?>
                    
                    <?php the_tags( '<p class="tagssingle">','',  '</p>'); ?>
                
                </div>       
                        
                <div class="clearfix"></div> 
                  
                <?php comments_template(); ?>
            
		</div>


	<?php endwhile; else: ?>

		<p><?php esc_html_e('Sorry, no posts matched your criteria','designed');?>.</p>

	<?php endif; ?>

                <div class="clearfix"></div>

	</div><!-- #content -->

    <?php get_sidebar();?>
    
</div>

</div>

<?php get_footer(); ?>