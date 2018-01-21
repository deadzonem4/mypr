<?php $single_featured = get_post_meta($post->ID, 'themnific_single_banner', true);?>

<?php if($single_featured) { ?>  
    
        <div class="postad">
        
            <a target="_blank"  href="<?php echo esc_url(get_post_meta($post->ID, 'themnific_single_target', true)); ?>"><img src="<?php echo esc_url($single_featured);?>" alt="" /></a>
            
        </div>
        
<?php } else {

	$themnific_redux = get_option( 'themnific_redux' );
	
	if($themnific_redux['postad-script']) { 
    
        echo '<div class="postad">';
     
        echo htmlspecialchars_decode($themnific_redux['headad-script']);
    
        echo '</div>';
    
    } elseif(empty($themnific_redux['postad-image']['url'])) {} else {?> 
    
        <div class="postad">
        
            <a target="_blank" href="<?php echo esc_url($themnific_redux['postad-target']);?>"><img src="<?php echo esc_url($themnific_redux['postad-image']['url']);?>" alt="" /></a>
            
        </div>
        
    <?php }
	
} ?>