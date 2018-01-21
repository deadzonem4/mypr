<?php
/*---------------------------------------------------------------------------------*/
/* Ads Widget */
/*---------------------------------------------------------------------------------*/

class AdWidget125_left extends WP_Widget {

	function AdWidget125_left() {
		$widget_ops = array('description' => esc_html__('Use this widget to add any type of Ad as a widget.','designed') );
		parent::__construct(false, esc_html__('Themnific - Ads 125px 4x','designed'),$widget_ops);      
	}

	function widget($args, $instance) {  
		$title = $instance['title'];
		$image = $instance['image'];
		$image2 = $instance['image2'];
		$href = $instance['href'];
		$href2 = $instance['href2'];
		
		$image3 = $instance['image3'];
		$image4 = $instance['image4'];
		$href3 = $instance['href3'];
		$href4 = $instance['href4'];

		if($title != '')
			echo '<h2 class="widget"><span>'.esc_attr($title).'</span></h2>';

		echo '<div class="ad300 item">';
		
		?>
		
		
		<ul class="ad125">
			<li><a target="_blank" href="<?php echo esc_url($href); ?>"><img class="grayscale grayscale-fade" src="<?php echo esc_url($image); ?>" alt="<?php esc_html_e('Visit Sponsor','designed');?>" /></a></li>
			<li><a target="_blank" href="<?php echo esc_url($href2); ?>"><img class="grayscale grayscale-fade" src="<?php echo esc_url($image2); ?>" alt="<?php esc_html_e('Visit Sponsor','designed');?>" /></a></li>
            
			<li><a target="_blank" href="<?php echo esc_url($href3); ?>"><img class="grayscale grayscale-fade" src="<?php echo esc_url($image3); ?>" alt="<?php esc_html_e('Visit Sponsor','designed');?>" /></a></li>
			<li><a target="_blank" href="<?php echo esc_url($href4); ?>"><img class="grayscale grayscale-fade" src="<?php echo esc_url($image4); ?>" alt="<?php esc_html_e('Visit Sponsor','designed');?>" /></a></li>
		</ul>
		<?php
		
		echo '</div>';	

	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		$instance['image'] = strip_tags( $new_instance['image'] );
		$instance['image2'] = $new_instance['image2'];
		$instance['image3'] = strip_tags( $new_instance['image3'] );
		$instance['image4'] = $new_instance['image4'];
		
		
		$instance['href'] = $new_instance['href'];
		$instance['href2'] = $new_instance['href2'];
		$instance['href3'] = $new_instance['href3'];
		$instance['href4'] = $new_instance['href4'];
		

		return $instance;
	}

	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'title' => esc_html__('Advertisement','designed'), 'image' => '', 'image2' => '','image3' => '', 'image4' => '', 'href' => '', 'href2' => '', 'href3' => '', 'href4' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>


		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title','designed'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>"/>
		</p>





		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'image' )); ?>"><?php esc_html_e('Image URL','designed'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image' )); ?>" value="<?php echo esc_url($instance['image']); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'href' )); ?>"><?php esc_html_e('Target URL','designed'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'href' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'href' )); ?>" value="<?php echo esc_url($instance['href']); ?>"/>
		</p>





		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'image2' )); ?>"><?php esc_html_e('Image 2 URL','designed'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image2' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image2' )); ?>" value="<?php echo esc_url($instance['image2']); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'href2' )); ?>"><?php esc_html_e('Target 2 URL','designed'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'href2' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'href2' )); ?>" value="<?php echo esc_url($instance['href2']); ?>"/>
		</p>   
        
        
        
        
    
    
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'image3' )); ?>"><?php esc_html_e('Image 3 URL','designed'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image3' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image3' )); ?>" value="<?php echo esc_url($instance['image3']); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'href3' )); ?>"><?php esc_html_e('Target 3 URL','designed'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'href3' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'href3' )); ?>" value="<?php echo esc_url($instance['href3']); ?>"/>
		</p>  
        
        
        
        
        
        
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'image4' )); ?>"><?php esc_html_e('Image 4 URL','designed'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image4' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image4' )); ?>" value="<?php echo esc_url($instance['image4']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'href4' )); ?>"><?php esc_html_e('Target 4 URL','designed'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'href4' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'href4' )); ?>" value="<?php echo esc_url($instance['href4']); ?>" />
		</p>   
        
        
        <?php
	}
} 

register_widget('AdWidget125_left');
?>