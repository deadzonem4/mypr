				<div class="entryhead">
                
                    <?php if ( has_post_thumbnail()){ ?>

                                <a href="<?php designed_permalink(); ?>">
                                    <?php the_post_thumbnail('designed_large',array('class' => 'tranz grayscale grayscale-fade'));  ?>
                                </a>
                
                    <?php } ?>
                
                </div><!-- end .entryhead -->
                    
                <div class="tmnf-product-info ribbon tranz">
                
                    <?php 
                        $product_price = get_post_meta(get_the_ID(), 'themnific_product_price', true); 
                        $product_label = get_post_meta(get_the_ID(), 'themnific_product_label', true);
                        $product_url = get_post_meta(get_the_ID(), 'themnific_product_url', true);
                    ?>
                    
                    <?php if(esc_attr($product_price)) :
        
                        echo '<span class="tmnf-label">'. esc_attr($product_label). '</span><br>'; 
                        echo '<span class="tmnf-price">'. esc_attr($product_price). '</span>'; 
                        if(esc_attr($product_url)) :
                            echo '<a class="tmnf-product-link" href="'. esc_attr($product_url). '"></a>';
                        endif;
                         
                    endif; ?>
                
                </div>     
                
                <div class="mosaicinside">
                
                    <h2><a class="link link--forsure" href="<?php designed_permalink(); ?>"><?php the_title(); ?></a></h2>  
                
                	<?php designed_meta_cat(); ?>  
                   
        		</div>
                
                <div class="icon-rating tranz rating_white">
        
                    <?php if (function_exists('wp_review_show_total')) wp_review_show_total(); ?>
                
                </div>
                
                <?php echo designed_icon();?>