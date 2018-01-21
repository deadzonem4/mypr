<?php
add_action('widgets_init', 'facebook_widgets');

function facebook_widgets()
{
	register_widget('Facebook_Widget');
}

class Facebook_Widget extends WP_Widget {
	
	function Facebook_Widget()
	{
		$widget_ops = array('classname' => 'facebook_like', 'description' => esc_html__('Adds support for Facebook Like Box.','designed'));

		$control_ops = array('id_base' => 'facebook-like-widget');

		$this->__construct('facebook-like-widget', esc_html__('Themnific - Facebook Box','designed'), $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$page_url = $instance['page_url'];
		$width = $instance['width'];
		$color_scheme = $instance['color_scheme'];
		$show_faces = isset($instance['show_faces']) ? 'true' : 'false';
		$show_stream = isset($instance['show_stream']) ? 'true' : 'false';
		$show_header = isset($instance['show_header']) ? 'true' : 'false';
		$height = '65';
		
		if($show_faces == 'true') {
			$height = '250';
		}
		
		if($show_stream == 'true') {
			$height = '600';
		}
		
		if($show_header == 'true') {
			$height = '600';
		}
		
		echo ($before_widget);?>
			<script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
    	<div class="twinsbox">
		<?php if($title) {
			echo ($before_title).esc_attr($title).$after_title;
		}
		
		if($page_url): ?>
        
        <div class="fb-page" data-href="<?php echo esc_url($page_url); ?>" data-hide-cover="<?php echo esc_attr($show_header); ?>" data-show-facepile="<?php echo esc_attr($show_faces); ?>" data-show-posts="<?php echo esc_attr($show_stream); ?>" data-width="<?php echo esc_attr($width); ?>"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="<?php echo esc_url($page_url); ?>">Facebook</a></blockquote></div></div>
        
		<?php endif;?>
		</div>
        <div class="clearfix"></div>
		<?php echo ($after_widget);
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['page_url'] = $new_instance['page_url'];
		$instance['width'] = $new_instance['width'];
		$instance['color_scheme'] = $new_instance['color_scheme'];
		$instance['show_faces'] = $new_instance['show_faces'];
		$instance['show_stream'] = $new_instance['show_stream'];
		$instance['show_header'] = $new_instance['show_header'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Find us on Facebook', 'page_url' => '', 'width' => '300', 'color_scheme' => 'light', 'show_faces' => 'on', 'show_stream' => false, 'show_header' => false);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
			<input class="widefat" style="width: 100%;" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('page_url')); ?>">Facebook Page URL:</label>
			<input class="widefat" style="width: 100%;" id="<?php echo esc_attr($this->get_field_id('page_url')); ?>" name="<?php echo esc_attr($this->get_field_name('page_url')); ?>" value="<?php echo esc_attr($instance['page_url']); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('width')); ?>">Width:</label>
			<input class="widefat" style="width: 50px;" id="<?php echo esc_attr($this->get_field_id('width')); ?>" name="<?php echo esc_attr($this->get_field_name('width')); ?>" value="<?php echo esc_attr($instance['width']); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('color_scheme')); ?>">Color Scheme:</label> 
			<select id="<?php echo esc_attr($this->get_field_id('color_scheme')); ?>" name="<?php echo esc_attr($this->get_field_name('color_scheme')); ?>" class="widefat" style="width:100%;">
				<option <?php if ('light' == $instance['color_scheme']) echo 'selected="selected"'; ?>>light</option>
				<option <?php if ('dark' == $instance['color_scheme']) echo 'selected="selected"'; ?>>dark</option>
			</select>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_faces'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_faces')); ?>" name="<?php echo esc_attr($this->get_field_name('show_faces')); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('show_faces')); ?>">Show faces</label>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_stream'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_stream')); ?>" name="<?php echo esc_attr($this->get_field_name('show_stream')); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('show_stream')); ?>">Show stream</label>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_header'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_header')); ?>" name="<?php echo esc_attr($this->get_field_name('show_header')); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('show_header')); ?>">Hide facebook header</label>
		</p>
	<?php
	}
}
?>