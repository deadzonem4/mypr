<div class="tab-post item p-border">

	<?php if ( has_post_thumbnail()) : ?>
    
        <div class="imgwrap">
        
            <a href="<?php designed_permalink(); ?>" title="<?php the_title(); ?>" >
            
              <?php the_post_thumbnail( 'designed_tabs',array('class' => "grayscale grayscale-fade")); ?>
              
            </a>
        
        </div>
         
    <?php endif; ?>
        
    <h4><a href="<?php designed_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
    
	<?php designed_meta_front();  ?>

</div>