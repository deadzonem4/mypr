<?php
add_action('widgets_init', 'designed_featured_slider_widget');

function designed_featured_slider_widget()
{
	register_widget('designed_featured_slider_widget');
}

class designed_featured_slider_widget extends WP_Widget {
	
	function designed_featured_slider_widget()
	{
		$widget_ops = array('classname' => 'designed_featured_slider_widget', 'description' => esc_html__('Featured posts widget.','designed'));

		$control_ops = array('id_base' => 'designed_featured_slider_widget');

		$this->__construct('designed_featured_slider_widget', esc_html__('Themnific - Featured Slider','designed'), $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		
		$title = $instance['title'];
		$post_type = 'all';
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		
		echo ($before_widget);
		?>
		
		<?php
		$post_types = get_post_types();
		unset($post_types['page'], $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item']);
		
		if($post_type == 'all') {
			$post_type_array = $post_types;
		} else {
			$post_type_array = $post_type;
		}
		?>
		
        	<?php if ( $title == "") {} else { ?>
        
				<h2 class="widget"><span><a href="<?php echo get_category_link($categories); ?>"><?php echo esc_attr($title); ?></a></span></h2>
			
            <?php } ?>
            
			<?php
			
			wp_enqueue_script('tmnf-jquery.flexslider-min', get_template_directory_uri() .'/js/jquery.flexslider-min.js',array( 'jquery' ),'', true);		
			wp_enqueue_script('tmnf-jquery.flexslider.start.widget', get_template_directory_uri() .'/js/jquery.flexslider.start.widget.js',array( 'jquery' ),'', true);	
			
			$recent_posts = new WP_Query(array(
				'showposts' => $posts,
				'ignore_sticky_posts' => 1,
				'cat' => $categories,
			));
			?>
            <div class="widgetflex flexslider smallflex">
            <ul class="slides tmnf-featured-slider">
			<?php  while($recent_posts->have_posts()): $recent_posts->the_post();if(has_post_format('aside')){ } elseif(has_post_format('quote')){ }else { ?>
				<li>
					<?php include( get_template_directory() . '/post-types/tab-slider-post.php'); ?>
				</li>
			<?php } endwhile; ?>
			</ul>
            <?php wp_reset_postdata(); ?>
			<div class="clearfix"></div>
            </div>
		
		<?php
		echo ($after_widget);
	}
	
	function update($new_instance, $old_instance)
	{
		
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['post_type'] = 'all';
		$instance['categories'] = $new_instance['categories'];
		$instance['posts'] = $new_instance['posts'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Posts', 'post_type' => 'all', 'categories' => 'all', 'posts' => 4, 'show_excerpt' => null);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
			<input class="widefat" style="width: 100%;" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('categories')); ?>">Filter by Category:</label> 
			<select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
				<?php } ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('posts')); ?>">Number of posts:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('posts')); ?>" name="<?php echo esc_attr($this->get_field_name('posts')); ?>" value="<?php echo esc_attr($instance['posts']); ?>" />
		</p>
		

	<?php }
}
?>