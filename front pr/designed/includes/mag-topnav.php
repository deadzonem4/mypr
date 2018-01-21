		<div id="topnav">
        
            <div class="container">
            
            	<?php include( get_template_directory() . '/includes/uni-social.php');  ?>
        
                <div class="tickerwrap">
                    <?php 
                    
                    if (isset($themnific_redux['tmnf-ticker-cats']) && !empty($themnific_redux['tmnf-ticker-cats'])) {
                    $ticker_categ = $themnific_redux['tmnf-ticker-cats'];
                    
                    $my_query = new WP_Query('showposts='. $themnific_redux['tmnf-ticker-nr'] .'&cat='. implode(",", $ticker_categ) .'');	 
                    if ($my_query->have_posts()) :
                    ?>
                            
                    <ul id="gticker-news2" class="gticker gticker-hidden">
                        <?php while ($my_query->have_posts()) : $my_query->the_post();$do_not_duplicate = $post->ID; ?>	
                        
                         
                               <li class="gticker-item"><a href="<?php designed_permalink(); ?>"><?php the_title(); ?></a> </li>
                             
                    
                        <?php  endwhile; ?>
                        
                                
                    <?php endif; ?>    
                
                    </ul>
                    
					<?php wp_reset_postdata(); ?>
                    
                    <?php  } else { echo '<p class="cntr">'. esc_html__('Please select featured categories (for ticker) in theme admin panel. You can select as much categories as you want.','designed').'</p>';}?>
                    
                </div>
             
            <div class="clearfix"></div>
        
            </div>
        
        </div>