<?php
/*---------------------------------------------------------------------------------*/
/* Blog Author Info */
/*---------------------------------------------------------------------------------*/
class BlogAuthorInfo extends WP_Widget {

   function BlogAuthorInfo() {
	   $widget_ops = array('description' => esc_html__('This is a Blog Info widget','designed'));
	   parent::__construct(false, esc_html__('Themnific - About us','designed'),$widget_ops);      
   }

   function widget($args, $instance) {  
	extract( $args );
	$title = $instance['title'];
	$author_name = $instance['author_name'];
	$bio = $instance['bio'];
	$custom_email = $instance['custom_email'];
	$read_more_text = $instance['read_more_text'];
	$read_more_url = $instance['read_more_url'];
	{
	?>
		<?php echo ($before_widget); ?>
		<?php if ($title) { echo ($before_title) . esc_attr($title) . $after_title; } ?>
		<div class="about-widget">
        <div class="mm-inner">
		<?php if ( esc_url($custom_email) ) echo '<img class="authorlogo" src="'.esc_url($custom_email).'" alt="My Image"/>' ?>
        <?php if ( esc_attr($author_name) ) echo '<h2 class="author_name">'.esc_attr($author_name).'</h2>' ?>
		<p class="authorinfo"><?php echo ($bio); ?></p>
        </div>
		<?php if ( $read_more_url ) echo '<a class="mainbutton" href="' . $read_more_url . '">' . $read_more_text . '</a>'; ?>
        </div>
		<?php echo ($after_widget); ?>   
    <?php
	}
   }

   function update($new_instance, $old_instance) {                
	   return $new_instance;
   }

   function form($instance) {   
   
   		$defaults = array('title' => '','author_name'=>'', 'bio' => '', 'custom_email' => '', 'avatar_size' => '', 'avatar_align' => '', 'read_more_text' => '', 'read_more_url' => '', 'page' => '');
		$instance = wp_parse_args((array) $instance, $defaults);     
   
		$title = esc_attr($instance['title']);
		$author_name = esc_attr($instance['author_name']);
		$bio = esc_attr($instance['bio']);
		$custom_email = esc_attr($instance['custom_email']);
		$avatar_size = esc_attr($instance['avatar_size']);
		$avatar_align = esc_attr($instance['avatar_align']);
		$read_more_text = esc_attr($instance['read_more_text']);
		$read_more_url = esc_attr($instance['read_more_url']);
		?>
		<p>
		   <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','designed'); ?></label>
		   <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
		</p>
		<p>
		   <label for="<?php echo esc_attr($this->get_field_id('author_name')); ?>"><?php esc_html_e('Author Name:','designed'); ?></label>
		   <input type="text" name="<?php echo esc_attr($this->get_field_name('author_name')); ?>"  value="<?php echo esc_attr($author_name); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('author_name')); ?>" />
		</p>
		<p>
		   <label for="<?php echo esc_attr($this->get_field_id('bio')); ?>"><?php esc_html_e('Bio:','designed'); ?></label>
			<textarea rows="10" name="<?php echo esc_attr($this->get_field_name('bio')); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('bio')); ?>"><?php echo esc_attr($bio); ?></textarea>
		</p>
		<p>
		   <label for="<?php echo esc_attr($this->get_field_id('custom_email')); ?>"><?php esc_html_e('Your Image URL','designed'); ?></label>
		   <input type="text" name="<?php echo esc_attr($this->get_field_name('custom_email')); ?>"  value="<?php echo esc_attr($custom_email); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('custom_email')); ?>" />
		</p>
		<p>
		   <label for="<?php echo esc_attr($this->get_field_id('read_more_text')); ?>"><?php esc_html_e('Read More Text (optional):','designed'); ?></label>
		   <input type="text" name="<?php echo esc_attr($this->get_field_name('read_more_text')); ?>"  value="<?php echo esc_attr($read_more_text); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('read_more_text')); ?>" />
		</p>
		<p>
		   <label for="<?php echo esc_attr($this->get_field_id('read_more_url')); ?>"><?php esc_html_e('Read More URL (optional):','designed'); ?></label>
		   <input type="text" name="<?php echo esc_attr($this->get_field_name('read_more_url')); ?>"  value="<?php echo esc_url($read_more_url); ?>" class="widefat" id="<?php echo esc_url($this->get_field_id('read_more_url')); ?>" />
		</p>

		<?php
	}
} 

register_widget('BlogAuthorInfo');
?>