<?php
/** A simple text block **/
class ML_Home_4 extends ML_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => esc_html__('Mag 4 (Free)','designed'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('ML_Home_4', $block_options);
	}
	
	function form($instance) {
                
		$defaults = array('title' => 'Recent Posts', 'subtitle' => 'Optional Subtitle', 'moretitle' => '','urlmore' => '','post_type' => 'all', 'categories' => 'all', 'posts' => 6,'offset_posts' => "",'right_lay' => 0,'no_margin' => 0, 'media_type_sel' => 'Featured Image', 'block_bg_color' => '#4591b8','block_text_color' => '#fff');
		

			
		
			
	$instance = wp_parse_args((array) $instance, $defaults);
	extract($instance);	          
    ?>
         
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('title')) ?>">
				<?php esc_html_e('Title (optional)','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('title')) ?>" class="input-full" type="text" value="<?php echo esc_attr($title) ?>" name="<?php echo esc_attr($this->get_field_name('title')) ?>">
			</label>
		</p>
        
       	<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('subtitle')) ?>">
				<?php esc_html_e('Subtitle (optional)','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('subtitle')) ?>" class="input-full" type="text" value="<?php echo  esc_attr($subtitle) ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')) ?>">
			</label>
		</p>
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php esc_html_e('Filter by Category:','designed'); ?></label> 
			<select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
				<?php } ?>
			</select>
		</p>
        
        <p class="clearfix"></p>
        <hr>

		
		<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('posts')); ?>"><?php esc_html_e('Number of posts:','designed'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('posts')); ?>" name="<?php echo esc_attr($this->get_field_name('posts')); ?>" value="<?php echo esc_attr($instance['posts']); ?>" />
		</p>
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('urlmore')) ?>">
				<?php esc_html_e('More Posts - URL to archive (optional)','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('urlmore')) ?>" class="input-full" type="text" value="<?php echo esc_url($urlmore) ?>" name="<?php echo esc_attr($this->get_field_name('urlmore')) ?>">
			</label>
		</p>
        
        <p class="clearfix"></p>
        <hr>
		
		<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('offset_posts')); ?>"><?php esc_html_e('Offset posts','designed'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('offset_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('offset_posts')); ?>" value="<?php echo esc_attr($instance['offset_posts']); ?>" />
		</p>
        
		<?php
	}
	
		
		
		
		function block($instance) {
                extract($instance);
        $title = $instance['title'];
        $subtitle = $instance['subtitle'];
        $urlmore = $instance['urlmore'];
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		$offset_posts = $instance['offset_posts'];

		?>

			<?php if ( $title == "") {} else { ?>
            <h2 class="block">
            
            	<span class="maintitle">
                
					<?php if ( $urlmore == "") { echo esc_attr($title);} else { ?>
                    
                        <a href="<?php echo esc_url($urlmore); ?>"><?php echo esc_attr($title) ?>  <i class="fa fa-long-arrow-right"></i></a>
                    
                    <?php } ?>
                
                </span>
                
                <?php if ( $subtitle == "") {} else { ?>
                    <span class="subtitle"><?php echo esc_attr($subtitle) ?></span>
                <?php } ?>
                    
            </h2>
            <?php } ?><!-- end title section-->


        	
			<?php
			
			$recent_posts = new WP_Query(array(
				'showposts' => esc_attr($posts),
				'ignore_sticky_posts'=>1,
				'cat' => $categories,
				'offset' => esc_attr($offset_posts)
			));
			?>
        
            <div class="mag-block mag-four">
                
				<?php 
                $big_count = round($posts / 20); if(!$big_count) { $big_count = 1; } $counter = 1;
                while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
                if($counter <= $big_count): if($counter == $big_count) { $last = 'block-item-big-last'; } else { $last = ''; };
                ?>
                
                	<?php include( get_template_directory() . '/post-types/home-4.php'); ?>
                
                <?php else: ?>
                
                	<?php include( get_template_directory() . '/post-types/home-4.php'); ?>
                    
				<?php endif; ?>
            
				<?php $counter++; endwhile; ?>
                
                <?php wp_reset_postdata(); ?>
               
            <div class="clearfix"></div>
                
			</div><!-- end. widgetwrap -->
			<?php
                
        }
	
}
ml_register_block('ML_Home_4');