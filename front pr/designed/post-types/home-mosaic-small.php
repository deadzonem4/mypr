				<div class="entryhead">
                
                    <?php if ( has_post_thumbnail()){ ?>

                                <a href="<?php designed_permalink(); ?>">
                                    <?php the_post_thumbnail('designed_vertical',array('class' => 'tranz grayscale grayscale-fade'));  ?>
                                </a>
                
                    <?php } ?>                    
                
                </div><!-- end .entryhead -->z
                
                
                
                <div class="mosaicinside">
                
                    <h2><a class="link link--forsure" href="<?php designed_permalink(); ?>"><?php the_title(); ?></a></h2> 
                
                	<?php designed_meta_cat();?> 
                    
        		</div>
                
                <div class="icon-rating tranz rating_white">
        
                    <?php if (function_exists('wp_review_show_total')) wp_review_show_total(); ?>
                
                </div>
                
                <?php echo designed_icon();?>