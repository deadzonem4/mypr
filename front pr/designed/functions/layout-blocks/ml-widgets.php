<?php
/* Registered Sidebars Blocks */
class ML_Widgets_Block extends ML_Block {
	
	function __construct() {
		$block_options = array(
			'name' => esc_html__('Widgets (for Narrow Column)','designed'),
			'size' => 'span4',
		);
		
		parent::__construct('ML_Widgets_Block', $block_options);
	}
	
	function form($instance) {
		
		
		//get all registered sidebars
		global $wp_registered_sidebars;
		$sidebar_options = array(); $default_sidebar = '';
		foreach ($wp_registered_sidebars as $registered_sidebar) {
			$default_sidebar = empty($default_sidebar) ? $registered_sidebar['id'] : $default_sidebar;
			$sidebar_options[$registered_sidebar['id']] = $registered_sidebar['name'];
		}
		
		$defaults = array(
			'sidebar' => $default_sidebar,
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		?>
		<p class="description half">
			<label for="<?php echo esc_attr($block_id) ?>_title">
				<?php esc_html_e('Title (optional)','designed'); ?>
				<?php echo ml_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>
		<p class="description half last">
			<label for="">
				<?php esc_html_e('Choose widget section','designed'); ?>
				<?php echo ml_field_select('sidebar', $block_id, $sidebar_options, $sidebar); ?>
			</label>
		</p>
		<?php
	}
	
	function block($instance) {
		extract($instance);
		echo '<div class="widgetable">';
		dynamic_sidebar($sidebar);
		echo '</div>';
	}
	
}