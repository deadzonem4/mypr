<?php
/** A simple text block **/
class ML_Custom_Menu extends ML_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => esc_html__('Custom Menu (Free)','designed'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('ML_Custom_Menu', $block_options);
	}
	
	function form($instance) {
                
	$defaults = array('title' => '','subtitle' => '','menu_name' => '','columns_sel' => '4');

	$columns_type = array(
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
				<input id="<?php echo esc_attr($this->get_field_id('title')) ?>" class="input-full" type="text" value="<?php echo esc_attr($title) ?>" name="<?php echo esc_attr($this->get_field_name('title')) ?>">
			</label>
		</p>
        
       	<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('subtitle')) ?>">
				<?php esc_html_e('Subitle (optional)','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('subtitle')) ?>" class="input-full" type="text" value="<?php echo  esc_attr($subtitle) ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')) ?>">
			</label>
		</p>
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('menu_name')) ?>">
				<?php esc_html_e('Menu Name','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('menu_name')) ?>" class="input-full" type="text" value="<?php echo esc_attr($menu_name) ?>" name="<?php echo esc_attr($this->get_field_name('menu_name')) ?>">
			</label>
		</p>
        
		<p class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('columns_sel')) ?>">
				<?php esc_html_e('Pick number of columns','designed'); ?><br/>
               <?php echo ml_field_select('columns_sel', $block_id, $columns_type, $columns_sel, $block_id); ?>
			</label>
		</p>
        
        
		<?php
	}
		
		function block($instance) {
                extract($instance);

        $title = $instance['title'];
        $subtitle = $instance['subtitle'];
        $menu_name = $instance['menu_name'];
		$columns = $instance['columns_sel'];
		
		?>

        
        <div class="widgetwrap">
        

			<?php if ( $title == "") {} else { ?>
            <h2 class="block ghost container">
            
            	<span class="maintitle">
                
					<?php echo esc_attr($title) ?>
                
                </span>
                
                <?php if ( $subtitle == "") {} else { ?>
                    <span class="subtitle"><?php echo esc_attr($subtitle) ?></span>
                <?php } ?>
                    
            </h2>
            <?php } ?><!-- end title section-->
            
            <div class="tmnf_menu tmnf_menu_<?php echo esc_attr($columns); ?>">
            <?php echo do_shortcode('[menu name="'.  esc_attr($menu_name) .'"]'); ?>   
			</div>
            
        </div>
        <?php
                
        }
	
}
ml_register_block('ML_Custom_Menu');