<div <?php post_class('normal tranz'); ?>>

<?php 
$image_opt = get_post_meta(get_the_ID(), 'themnific_image_single', true); 
if($image_opt == 'Full'){ echo ''; } 
elseif ($image_opt == 'Large'){ echo ''; }
else {  ?>

    <h1 class="entry-title" itemprop="headline"><span itemprop="name"><?php the_title(); ?></span></h1>
    
    <div class="clearfix"></div>
        
        <div class="meta-general p-border">
        
            <?php designed_meta_full(); ?>
            
        </div>

    <div class="entryhead" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        
        <?php 	
        
            $themnific_redux = get_option( 'themnific_redux' ); 	
            $single_featured = get_post_meta(get_the_ID(), 'themnific_single_featured', true);
        
            if(has_post_format('video')){
        
                include( get_template_directory() . '/functions/theme-video.php');
            
            }elseif(has_post_format('audio')){
            } else {
                if($themnific_redux['tmnf-post-image-dis'] == '1');
                else{
                   
                    if ($single_featured == 'No')  {
                    } else { ?>
                            <?php the_post_thumbnail('designed_single',array('class' => 'standard grayscale grayscale-fade'));  ?>
                        <?php }; 
                    
                }
            }
            
        ?>
    
    </div><!-- end .entryhead -->

<?php }?>    
    
    <div class="clearfix"></div>
                             
<div class="entry" itemprop="text">
            
			<?php 
                $product_price = get_post_meta(get_the_ID(), 'themnific_product_price', true); 
                $product_label = get_post_meta(get_the_ID(), 'themnific_product_label', true);
                $product_url = get_post_meta(get_the_ID(), 'themnific_product_url', true);
				
            ?>
            
            	<?php if(empty($product_price)) { } else { ?>

                	<div class="tmnf-product-info-single ribbon tranz">
                    
                    <?php 
                        echo '<span class="tmnf-label">'. esc_attr($product_label). '</span><br>'; 
                        echo '<span class="tmnf-price">'. esc_attr($product_price). '</span>'; 
                        if(esc_attr($product_url)) :
                        	echo '<a class="tmnf-product-link" href="'. esc_attr($product_url). '"></a>';
                    	endif;
					?>
                    
               		</div>
                
                <?php } ?>
                
                <?php
            
                the_content(); 
				
				if(empty($product_price)) { } else { ?>

                	<div class="tmnf-product-info-single tmnf-info-bottom ribbon tranz">
                    
                    <?php 
				
                        echo '<span class="tmnf-label">'. esc_attr($product_label). '</span><br>'; 
                        echo '<span class="tmnf-price">'. esc_attr($product_price). '</span>'; 
                        if(esc_attr($product_url)) :
                        	echo '<a class="tmnf-product-link" href="'. esc_attr($product_url). '"></a>';
                    	endif; ?>
                    
               		</div>
                
                <?php }
				
				//tags/likes
            	if($themnific_redux['tmnf-post-likes-dis'] == '1');
            	else {
                	the_tags( '<p class="meta taggs p-border"><i class="icon-tag-empty"></i> ', ' ', '</p>');
				}
				
				
                echo '<div class="post-pagination">';
                wp_link_pages( array( 'before' => '<div class="page-link">', 'after' => '</div>',
				'link_before' => '<span>', 'link_after' => '</span>', ) );
				wp_link_pages(array(
					'before' => '<p>',
					'after' => '</p>',
					'next_or_number' => 'next_and_number', # activate parameter overloading
					'nextpagelink' => esc_html__('Next','designed'),
					'previouspagelink' => esc_html__('Previous','designed'),
					'pagelink' => '%',
					'echo' => 1 )
				);
				echo '</div>';
            ?>
            
            
        	<p class="tmnf_mod small" itemprop="dateModified" ><?php esc_html_e('Last modified','designed');?>: <?php the_modified_date(); ?></p>
            
            <div class="clearfix"></div>
            
        </div><!-- end .entry -->
        
            <?php 
                
                include( get_template_directory() . '/includes/mag-postad.php');
            
                include( get_template_directory() . '/single-info.php');
                
                comments_template(); 
                
            ?>
      
</div>