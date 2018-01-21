<div class="postinfo p-border">    

<?php
	$themnific_redux = get_option( 'themnific_redux' ); 


	// related
	if($themnific_redux['tmnf-post-related-dis'] == '1');
	else {
	include( get_template_directory() . '/includes/mag-relatedposts.php');}
	
	// prev/next	
	if($themnific_redux['tmnf-post-nextprev-dis'] == '1');
	else {
	include( get_template_directory() . '/includes/mag-nextprev.php');
	echo '<div class="clearfix"></div>';}
	
	// author
	if($themnific_redux['tmnf-post-author-dis'] == '1');
	else {
	include( get_template_directory() . '/includes/mag-authorinfo.php');
	echo '';}

	
?>
            
</div>

<div class="clearfix"></div>
 			
            

                        
