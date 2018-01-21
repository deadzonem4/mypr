<?php get_header(); ?>

<div class="container">

<div id="core">

    <div id="content" class="eightcol item_inn">
    
            <div class="errorentry entry">

            	<h1 class="entry-title" itemprop="headline"><?php esc_html_e('Nothing found here','designed');?></h1>
            
            	<h4><?php esc_html_e('Perhaps You will find something interesting from these lists...','designed');?></h4>
            
            	<div class="hrline p-border"></div>
			
				<?php include( get_template_directory() . '/includes/uni-404-content.php');?>
            
            </div>
            
    </div><!-- #content -->

	<?php get_sidebar();?>
        
</div>
    
<?php get_footer(); ?>