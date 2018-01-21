<?php
/** A simple text block **/
class ML_Slider extends ML_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => esc_html__('Main Slider (Full Width)','designed'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('ML_Slider', $block_options);
	}
	
	function form($instance) {
                
	$defaults = array('title' => '','subtitle' => '', 'post_type' => 'all', 'categories1' => 'all',  'posts' => 5,'flex_type' => '','offset_posts' => "",'yes_margin' => 0,);
	$flex_type_select = array(
				'navi' => esc_html__('Slider With Navigation','designed'),
				'plain' => esc_html__('Plain Slider','designed'),
			);
	$instance = wp_parse_args((array) $instance, $defaults);
	
			
   	
	extract($instance); ?>		
                
                
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('title')) ?>">
				<?php esc_html_e('Optional Title (not visible on the front-end)','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('title')) ?>" class="input-full" type="text" value="<?php echo esc_attr($title) ?>" name="<?php echo esc_attr($this->get_field_name('title')) ?>">
			</label>
		</p>

        <p class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('categories1')); ?>"><?php esc_html_e('Filter by Category:','designed'); ?></label> 
			<select id="<?php echo esc_attr($this->get_field_id('categories1')); ?>" name="<?php echo esc_attr($this->get_field_name('categories1')); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories1']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories1 = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories1 as $category1) { ?>
				<option value='<?php echo esc_attr($category1->term_id); ?>' <?php if ($category1->term_id == $instance['categories1']) echo 'selected="selected"'; ?>><?php echo esc_attr($category1->cat_name); ?></option>
				<?php } ?>
			</select>
		</p>   
        
        <p class="clearfix"></p>
		
		<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('posts')); ?>"><?php esc_html_e('Number of posts:','designed'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('posts')); ?>" name="<?php echo esc_attr($this->get_field_name('posts')); ?>" value="<?php echo esc_attr($instance['posts']); ?>" />
		</p>
        
        <p class="clearfix"></p>
        <hr>
        <p class="clearfix"></p>
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('flex_type')) ?>">
				<?php esc_html_e('Select styling for main slider','designed'); ?><br/>
               <?php echo ml_field_select('flex_type', $block_id, $flex_type_select, $flex_type, $block_id); ?>
			</label>
		</p>
        
        <p class="clearfix"></p>
        <hr>
        <p class="clearfix"></p>
		
		<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('offset_posts')); ?>"><?php esc_html_e('Offset posts','designed'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('offset_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('offset_posts')); ?>" value="<?php echo esc_attr($instance['offset_posts']); ?>" />
		</p>
        
        <p class="clearfix"></p>
        <hr>
        
        <p class="description">
        <label for="<?php echo esc_attr($this->get_field_id('yes_margin')) ?>">
                <?php echo ml_field_checkbox('yes_margin', $block_id, $yes_margin) ?>
                <?php esc_html_e('Add margin at the bottom.','designed'); ?>
        </label>
        </p>
        
		<?php
	}
		
		
		function block($instance) {
                extract($instance);
		wp_enqueue_script('tmnf-jquery.flexslider-min', get_template_directory_uri() .'/js/jquery.flexslider-min.js',array( 'jquery' ),'', true);		
		wp_enqueue_script('tmnf-jquery.flexslider.start.main', get_template_directory_uri() .'/js/jquery.flexslider.start.main.js',array( 'jquery' ),'', true);		

        $title = $instance['title'];
		$post_type = 'all';
		$categories1 = $instance['categories1'];
		$posts = $instance['posts'];
		$flex_type = $instance['flex_type'];
		$offset_posts = $instance['offset_posts'];
		
		?>
			
		<?php
			$recent_posts = new WP_Query(array(
				'showposts' => esc_attr($posts),
				'cat' => $categories1,
				'ignore_sticky_posts'=>1,
				'offset' => esc_attr($offset_posts)
			)); 
        ?>
        
        </div></div></div>
        
        <div class="flexwrap builder <?php if($yes_margin == 1){echo 'yes_margin';} else { } ?>">
            
            <div class="mainflex mainflex-large flexslider loading ghost mainflex<?php echo esc_attr($flex_type); ?>">
            
            	<div class="loading-inn"><i class="fa fa-circle-o-notch fa-spin"></i></div>
                
                <ul class="slides">    
        
                    <?php if ($recent_posts->have_posts()) : while($recent_posts->have_posts()): $recent_posts->the_post();
                    ?>
        
                    <li>
                    
 						<?php include( get_template_directory() . '/post-types/home-slider.php'); ?>
                                
                    </li>
                    
                    <?php endwhile; endif;  ?>
        
        
                </ul>
                
            <div class="slide-nav-wrap">        
                    
            <ul class="slide-nav p-border">
                
                <?php if ($recent_posts->have_posts()) : while($recent_posts->have_posts()): $recent_posts->the_post(); ?>	
                        
                     <li class="p-border">
                        
                        <a class="islink p-border" href="#" title="<?php the_title(); ?>">
                        
                            <?php // the_post_thumbnail( 'tmnf-tabs',array('class' => "grayscale grayscale-fade")); ?>
                        
                            <span class="title"><?php the_title(); ?></span>
                            
                        </a>
                        
                     </li>
                
                <?php  endwhile; endif; ?>
                
            </ul> 
            
            </div> 
              
            </div>
            
        </div>
        
        <?php wp_reset_postdata(); ?>
        
        <div class="container homebuilder builder woocommerce"><div><div>
        
        <?php
                
        }
	
}
ml_register_block('ML_Slider');