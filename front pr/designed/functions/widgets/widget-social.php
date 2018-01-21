<?php
/*---------------------------------------------------------------------------------*/
/* Social Networks widget */
/*---------------------------------------------------------------------------------*/
class SocialNetworks extends WP_Widget {

   function SocialNetworks() {
	   $widget_ops = array('description' => esc_html__('This is Social Networks widget.','designed'));
       parent::__construct(false, esc_html__('Themnific - Social Networks','designed'),$widget_ops);      
   }

   function widget($args, $instance) {  
    extract( $args );
   	$title = $instance['title'];
	?>
		<?php echo ($before_widget); ?>
        <?php if ($title) { echo($before_title) . esc_attr($title) . $after_title; } ?>
        	<?php include( get_template_directory() . '/includes/uni-social.php'); ?>
            <div class="clearfix"></div> 
		<?php echo($after_widget); ?>   
   <?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {  
      	$defaults = array('title' => '');
		$instance = wp_parse_args((array) $instance, $defaults);      
   
       $title = esc_attr($instance['title']);

       ?>
       <p>
	   	   <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','designed'); ?></label>
	       <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
       </p>
      <?php
   }
} 

register_widget('SocialNetworks');
?>