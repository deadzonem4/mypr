<?php
/** A simple text block **/
class ML_MP_Info extends ML_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => esc_html__('Info Posts (Free)','designed'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('ML_MP_Info', $block_options);
	}
	
	function form($instance) {
                
	$defaults = array('title' => '','subtitle' => esc_html__('Optional Subtitle','designed'), 'post_type' => 'all', 'categories' => '', 'posts' => 4,'type_sel' =>'','layout_sel' =>'','columns_sel' => '4',
	'block_bg_color' => '#F2F2F2','block_text_color' => '#000','height' => '60' );

	$columns_type = array(
				'1' => esc_html__('1 Columns','designed'),
				'2' => esc_html__('2 Columns','designed'),
				'3' => esc_html__('3 Columns','designed'),
				'4' => esc_html__('4 Columns','designed'),
				'5' => esc_html__('5 Columns','designed'),
			);
	$instance = wp_parse_args((array) $instance, $defaults);
	
			
   	
	extract($instance); ?>		
                
                
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('title')) ?>">
				<?php esc_html_e('Title (optional)','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('title')) ?>" class="input-full" type="text" value="<?php echo  esc_attr($title) ?>" name="<?php echo esc_attr($this->get_field_name('title')) ?>">
			</label>
		</p>
        
       	<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('subtitle')) ?>">
				<?php esc_html_e('Subtitle (optional)','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('subtitle')) ?>" class="input-full" type="text" value="<?php echo  esc_attr($subtitle) ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')) ?>">
			</label>
		</p>

        <p class="description half last" style=" clear:right;">
			<label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php esc_html_e('Filter by Category:','designed'); ?></label> 
			<select id="<?php echo esc_attr($this->get_field_name('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories">
				<option value='' <?php if ('' == $instance['categories']) echo 'selected="selected"'; ?>></option>
				<?php $categories = get_categories($args = array(
															'type'		=> 'mp_info_post',
															'orderby'	=> 'name',
															'order'		=> 'ASC',
															'taxonomy'	=> 'mp_specifics'
															)) ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo esc_attr($category->cat_name); ?>' <?php if ($category->cat_name == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
				<?php } ?>
			</select>
		</p>
        
        <p class="clearfix"></p>
        
		<p class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('columns_sel')) ?>">
				<?php esc_html_e('Pick number of columns','designed'); ?><br/>
               <?php echo ml_field_select('columns_sel', $block_id, $columns_type, $columns_sel, $block_id); ?>
			</label>
		</p>
        
        <p class="clearfix"></p>
		
		<p class="description half last spec">
			<label for="<?php echo esc_attr($this->get_field_id('posts')); ?>"><?php esc_html_e('Number of posts:','designed'); ?></label>
			<input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('posts')); ?>" name="<?php echo esc_attr($this->get_field_name('posts')); ?>" value="<?php echo  esc_attr($instance['posts']); ?>" />
		</p>
        
        
		<?php
	}
		
		
		function block($instance) {
                extract($instance);

        $title = $instance['title'];
        $subtitle = $instance['subtitle'];
		$post_type = 'all';
		$categories = $instance['categories'];
		$columns = $instance['columns_sel'];
		$posts = $instance['posts'];
		
		?>
			

        
        <div class="widgetwrap">
        

			<?php if ( $title == "") {} else { ?>
            <h2 class="block container">
            
            	<span class="maintitle">
                
					<?php echo esc_attr($title) ?>
                
                </span>
                
                <?php if ( $subtitle == "") {} else { ?>
                    <span class="subtitle"><?php echo esc_attr($subtitle) ?></span>
                <?php } ?>
                    
            </h2>
            <?php } ?><!-- end title section-->
            <?php echo do_shortcode('[mm-info category="'.  esc_attr($categories) .'" columns="'. esc_attr($columns).'"  posts="'. esc_attr($posts).'"]'); ?>   

        </div>
        <?php wp_reset_postdata(); ?>
        <?php
                
        }
	
}
ml_register_block('ML_MP_Info');