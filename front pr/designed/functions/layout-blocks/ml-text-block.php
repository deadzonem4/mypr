<?php
/** A simple text block **/
class ML_Text_Block extends ML_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => esc_html__('Text & Divider** (Free)','designed'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('ML_Text_Block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'text' => '',
			'subtitle' => esc_html__('Optional Subtitle','designed'),
			'wp_autop' => 1,
			'center_text' => 0,
			'block_image' =>'',
			'media' =>'',
			'block_bg_color' => '#fff',
			'block_text_color' => '#333',
			'height' => '100',
			'yes_margin' => 0,
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		?>
		<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('title')) ?>">
				<?php esc_html_e('Title (optional)','designed'); ?>
				<?php echo ml_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>
        
       	<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('subtitle')) ?>">
				<?php esc_html_e('Subtitle (optional)','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('subtitle')) ?>" class="input-full" type="text" value="<?php echo  esc_attr($subtitle) ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')) ?>">
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('text')) ?>">
				<?php esc_html_e('Content','designed'); ?>
				<?php echo ml_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</label>
			<label for="<?php echo esc_attr($this->get_field_id('wp_autop')) ?>">
				<?php echo ml_field_checkbox('wp_autop', $block_id, $wp_autop) ?>
                <?php esc_html_e('Do not create the paragraphs automatically. "wpautop" disable.','designed'); ?>
			</label>
		</p>
        
		<p class="description">
            <label for="<?php echo esc_attr($this->get_field_id('center_text')) ?>">
				<?php echo ml_field_checkbox('center_text', $block_id, $center_text) ?>
                <?php esc_html_e('Center text','designed'); ?>
			</label>
		</p>
        
        <p class="clearfix"></p>
        <hr>

        <div class="description half">
			<label for="<?php echo esc_attr($this->get_field_id('block_bg_color')) ?>">
				<?php esc_html_e('Pick a background color','designed'); ?><br/>
				<?php echo ml_field_color_picker('block_bg_color', $block_id, $block_bg_color, $defaults['block_bg_color']) ?>
			</label>
			
		</div>
        
        <div class="description half last">
			<label for="<?php echo esc_attr($this->get_field_id('block_text_color')) ?>">
				<?php esc_html_e('Pick a link & text color','designed'); ?><br/>
				<?php echo ml_field_color_picker('block_text_color', $block_id, $block_text_color, $defaults['block_text_color']) ?>
			</label>
			
		</div>
        
        <p class="clearfix"></p>
        <hr>
        
        <div class="description">
			<label for="<?php echo esc_attr($this->get_field_id('block_image')) ?>">
				<?php esc_html_e('Image','designed'); ?><br/>
				<?php echo ml_field_upload('block_image', $block_id, $block_image, $media_type = 'image',$defaults['block_image']) ?>
			</label>
			
		</div>
        
        <p class="clearfix"></p>
        <hr>
        
		<div class="description">
			<label for="<?php echo esc_attr($this->get_field_id('height')) ?>">
				<?php esc_html_e('Vertical Padding','designed'); ?><br/>
				<?php echo ml_field_input('height', $block_id, $height, 'min', 'number') ?> px
			</label>

		</div>
        
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

		$wp_autop = ( isset($wp_autop) ) ? $wp_autop : 0; ?>
        
        <div class="widgetwrap text-block <?php if($yes_margin == 1){echo 'yes_margin';} else { } ?> <?php if($center_text == 1){echo 'cntr';} else {} ?>"   style="padding:<?php echo esc_html($height);?>px 0;color:<?php echo esc_attr($block_text_color);?> !important;background-color:<?php echo esc_attr($block_bg_color);?>;background-image:url(<?php echo esc_url($block_image);?>) !important;">
        
        
			<?php if ( $title == "") {} else { ?>
            <h2 class="block"  style="color:<?php echo esc_attr($block_text_color);?>;">
                
                <span class="maintitle"><?php echo esc_attr($title) ?></span>
                
                <?php if ( $subtitle == "") {} else { ?>
                    <span class="subtitle" style="color:<?php echo esc_attr($block_text_color);?>;"><?php echo esc_attr($subtitle) ?></span>
                <?php } ?>
                    
            </h2>
            <?php } ?>
                   
            <?php        
            if($wp_autop == 1){
                echo do_shortcode(htmlspecialchars_decode($text));
            }
            else
            {
                echo wpautop(do_shortcode(htmlspecialchars_decode($text)));
            }?>

        
        </div>
        
        <?php
		
	}
	
}
