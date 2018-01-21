	<?php $themnific_redux = get_option( 'themnific_redux' );
	
	if(empty($themnific_redux['tmnf-headad-script'])) {} else { 
    
        echo '<div class="clearfix"></div><div class="headad">';
     
        echo htmlspecialchars_decode($themnific_redux['tmnf-headad-script']);
    
        echo '</div>';
    
    } if(empty($themnific_redux['tmnf-headad-image']['url'])) {} else {?> 
    
        <div class="clearfix"></div>
        <div class="headad">
        
            <a target="_blank" href="<?php echo esc_url($themnific_redux['tmnf-headad-target']);?>"><img src="<?php echo esc_url($themnific_redux['tmnf-headad-image']['url']);?>" alt="" /></a>
            
        </div>
        
    <?php } ?>