          	<div <?php post_class('item p-border tranz item_3_big p-border'); ?>>
     
                <div class="entryhead">
    
					<?php if ( has_post_thumbnail()){ ?>
                    
                        <div class="imgwrap">
                
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
                        
                            <?php echo designed_icon();?>
                        
                            <a href="<?php designed_permalink(); ?>">
                                <?php the_post_thumbnail('designed_vertical',array('class' => 'tranz standard grayscale grayscale-fade'));  ?>
                            </a>
                        
                        </div>
    
                    <?php } else { } ?> 
                
                </div><!-- end .entryhead -->
    
            	<div class="item_inn tranz">
                    
                    <?php if (function_exists('wp_review_show_total')) wp_review_show_total(); ?>
        
                    <h2 class="posttitle"><a class="link link--forsure" href="<?php designed_permalink(); ?>"><?php the_title(); ?></a></h2>
                    
                    <p class="teaser"><?php echo designed_excerpt( get_the_excerpt(), '230'); ?><span>...</span></p>
                
                    <div class="meta-general p-border meta-center">
                    
                        <?php designed_meta_front(); ?>
                        
                    </div>
                
                </div><!-- end .item_inn -->
        
            </div>