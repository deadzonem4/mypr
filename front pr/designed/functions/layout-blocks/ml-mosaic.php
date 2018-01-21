<?php
/** A simple text block **/
class ML_Mosaic extends ML_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => esc_html__('Mosaic','designed'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('ML_Mosaic', $block_options);
	}
	
	function form($instance) {
                
	$defaults = array('title' => esc_html__('Recent Posts','designed'),'subtitle' => esc_html__('Optional Subtitle','designed'),'post_type' => 'all', 'categories' => 'all', 'posts' => 12,'urlmore' => '','offset_posts' => "",'yes_margin' => 0, );
	$instance = wp_parse_args((array) $instance, $defaults);
	
			
   	
	extract($instance); ?>		
                
                
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('title')) ?>">
				<?php esc_html_e('Title (optional)','designed');?>
				<input id="<?php echo esc_attr($this->get_field_id('title')) ?>" class="input-full" type="text" value="<?php echo  esc_attr($title) ?>" name="<?php echo esc_attr($this->get_field_name('title')) ?>">
			</label>
		</p>
        
       	<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('subtitle')) ?>">
				<?php esc_html_e('Subtitle (optional)','designed');?>
				<input id="<?php echo esc_attr($this->get_field_id('subtitle')) ?>" class="input-full" type="text" value="<?php echo  esc_attr($subtitle) ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')) ?>">
			</label>
		</p>
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php esc_html_e('Filter by Category','designed');?></label> 
			<select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
				<?php } ?>
			</select>
		</p>
        
        <p class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('urlmore')) ?>">
				<?php esc_html_e('Title URL to archive/any page (optional)','designed');?>
				<input id="<?php echo esc_attr($this->get_field_id('urlmore')) ?>" class="input-full" type="text" value="<?php echo esc_url($urlmore) ?>" name="<?php echo esc_attr($this->get_field_name('urlmore')) ?>">
			</label>
		</p>
        
        <p class="clearfix"></p>
        <hr>
        
        <p class="description">
        <label for="<?php echo esc_attr($this->get_field_id('yes_margin')) ?>">
                <?php echo ml_field_checkbox('yes_margin', $block_id, $yes_margin) ?>
                <?php esc_html_e('Add margin at the bottom','designed');?>
        </label>
        </p>
        
		<?php
	}
		
		
		function block($instance) {
                extract($instance);

        $title = $instance['title'];
		$post_type = 'all';
		$categories = $instance['categories'];
		$urlmore = $instance['urlmore'];
		
		
		$post_types = get_post_types();
		unset($post_types['page'], $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item']);
		
		if($post_type == 'all') {
			$post_type_array = $post_types;
		} else {
			$post_type_array = $post_type;
		}
		?>
            
			<?php if ( $title == "") {} else { ?>
            <h2 class="block container">
            
            	<span class="maintitle">
                
					<?php if ( $urlmore == "") { echo esc_attr($title);} else { ?>
                    
                        <a href="<?php echo esc_url($urlmore); ?>"><?php echo esc_attr($title) ?> <i class="fa fa-long-arrow-right"></i></a>
                    
                    <?php } ?>
                
                </span>
                
                <?php if ( $subtitle == "") {} else { ?>
                    <span class="subtitle"><?php echo esc_attr($subtitle) ?></span>
                <?php } ?>
                    
            </h2>
            <?php } ?><!-- end title section-->
            
        <div class="mosaicwrap <?php if($yes_margin == 1){echo 'yes_margin';} else { } ?>">  
            
        <ul class="tmnf-mosaic">
        
        
        	<?php $recent_posts = new WP_Query(array('showposts' => 1,'cat' => $categories,'ignore_sticky_posts'=>1));
            while($recent_posts->have_posts()): $recent_posts->the_post(); ?>	
            <li class="maso maso-1">
                <?php include( get_template_directory() . '/post-types/home-mosaic.php' ); ?>        
            </li>  
        	<?php  endwhile; ?>
            
            
        	<?php $recent_posts = new WP_Query(array('showposts' => 1,'cat' => $categories,'offset' => 1,'ignore_sticky_posts'=>1));
            while($recent_posts->have_posts()): $recent_posts->the_post(); ?>	
            <li class="maso maso-2">
                <?php include( get_template_directory() . '/post-types/home-mosaic-small.php' ); ?>        
            </li>  
        	<?php  endwhile; ?>
            
            
        	<?php $recent_posts = new WP_Query(array('showposts' => 1,'cat' => $categories,'offset' => 2,'ignore_sticky_posts'=>1));
            while($recent_posts->have_posts()): $recent_posts->the_post(); ?>	
            <li class="maso maso-3">
                <?php include( get_template_directory() . '/post-types/home-mosaic-small.php' ); ?>        
            </li>  
        	<?php  endwhile; ?>
            
            
        	<?php $recent_posts = new WP_Query(array('showposts' => 1,'cat' => $categories,'offset' => 3,'ignore_sticky_posts'=>1));
            while($recent_posts->have_posts()): $recent_posts->the_post(); ?>	
            <li class="maso maso-4">
                <?php include( get_template_directory() . '/post-types/home-mosaic-small.php' ); ?>        
            </li>  
        	<?php  endwhile; ?>
            
            
        	<?php $recent_posts = new WP_Query(array('showposts' => 1,'cat' => $categories,'offset' => 4,'ignore_sticky_posts'=>1));
            while($recent_posts->have_posts()): $recent_posts->the_post(); ?>	
            <li class="maso maso-5">
                <?php include( get_template_directory() . '/post-types/home-mosaic-small.php' ); ?>        
            </li>  
        	<?php  endwhile; ?>
            
            
            
        </ul>
        
        <?php wp_reset_postdata(); ?>
            
        </div>
        
        <?php
                
        }
	
}
ml_register_block('ML_Mosaic');