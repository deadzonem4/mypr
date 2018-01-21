<?php get_header();  

designed_count_views(get_the_ID());
$image_opt = get_post_meta(get_the_ID(), 'themnific_image_single', true);
$sidebar_opt = get_post_meta(get_the_ID(), 'themnific_sidebar', true);
if (have_posts()) : while (have_posts()) : the_post();
	
?>
<?php if(has_post_format('quote'))  { ?>
    <div class="container">
    <?php
	include( get_template_directory() . '/post-types/post-quote-post.php' );
	} else {?>  
      
<div itemscope itemtype="http://schema.org/NewsArticle">
<meta itemscope itemprop="mainEntityOfPage" content=""  itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>"/>


<?php
$themnific_redux = get_option( 'themnific_redux' ); 	
$single_featured = get_post_meta(get_the_ID(), 'themnific_single_featured', true);
if ( has_post_thumbnail()) {
?>

<?php if($image_opt == 'Full'){  ?>

	<div class="page-head full-image">
    
    	<div  itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
  
    		<?php the_post_thumbnail('designed_slider',array('class' => 'standard grayscale grayscale-fade'));  ?>
        
        </div>
        
        <h1 class="entry-title container" itemprop="headline"><span itemprop="name"><?php the_title(); ?></span></h1>
        
        <div class="meta-general p-border">
        
            <?php designed_meta_full(); ?>
            
        </div>
    
    </div>
    
<?php } elseif($image_opt == 'Large'){  ?>

	<div class="page-head large-image container">
    
    	<div  itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
    
    	<?php the_post_thumbnail('designed_single',array('class' => 'standard grayscale grayscale-fade'));  ?>
        
        </div>
        
        <h1 class="entry-title" itemprop="headline"><span itemprop="name"><?php the_title(); ?></span></h1>      
        
        <div class="meta-general p-border">
        
            <?php designed_meta_full(); ?>
            
        </div>
    
    </div>

<?php } else { echo'';}?>
    
    <?php } ?>
    
    <div class="container_alt">
   
    <div class="postbar postbar<?php echo esc_attr($sidebar_opt);?>">

        <div id="content" class="eightcol first">
            
            <?php include( get_template_directory() . '/single-content.php' ); ?>
               
        </div><!-- end #content -->
    
        <?php if($sidebar_opt == 'None'){ } else { get_sidebar();} ?>
   
    </div><!-- end .postbar -->
    
</div> 

<?php }?>


        
        <?php endwhile; else: ?>
        
            <p><?php esc_html_e('Sorry, no posts matched your criteria','designed');?>.</p>
        
        <?php endif; ?>
   
<?php get_footer(); ?>