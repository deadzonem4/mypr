<?php 

// blog posts

$video_input = get_post_meta(get_the_ID(), 'themnific_video', true);
if(preg_match('/https?:\/\/(www\.)*vimeo\.com\/.*/',$video_input)){
    
		//VIMEO
	  if (esc_url($video_input)) {?> 
	  <iframe class="tmnf-video" src="//player.vimeo.com/video/<?php echo (int) substr(parse_url(esc_url($video_input), PHP_URL_PATH), 1); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="790" height="444" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
	  <?php } else {} 

}

else{
	
	//YOUTUBE
	if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_input, $match)) {
		$video_id = $match[1];
	}
	if (esc_url($video_input)) {?> 
		<iframe class="tmnf-video" width="790" height="444" src="//www.youtube.com/embed/<?php echo esc_html($video_id); ?>" frameborder="0" allowfullscreen></iframe>
	<?php } else {}


}


?>