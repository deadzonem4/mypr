<?php
/** A simple text block **/
class ML_Text_Block_Action extends ML_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => esc_html__('Call To Action (Full Width)','designed'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('ml_text_block_action', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'text' => '',
			'subtitle' => esc_html__('Optional Subtitle','designed'),
			'wp_autop' => 0,
			'block_image' =>'',
			'center_text' => 0,
			'yes_margin' => 0,
			'media' =>'','moretitle' => '','urlmore' => '',
			'block_bg_color' => '#000',
			'block_text_color' => '#fff',
			'height' => '100'
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
        
        <p class="clearfix"></p>
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('moretitle')) ?>">
				<?php esc_html_e('Button - Title (Label)','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('moretitle')) ?>" class="input-full" type="text" value="<?php echo esc_attr($moretitle) ?>" name="<?php echo esc_attr($this->get_field_name('moretitle')) ?>">
			</label>
		</p>
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('urlmore')) ?>">
				<?php esc_html_e('Button - Link URL (link to any page)','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('urlmore')) ?>" class="input-full" type="text" value="<?php echo esc_url($urlmore) ?>" name="<?php echo esc_attr($this->get_field_name('urlmore')) ?>">
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
        
        </div></div></div>
        
        <div class="widgetwrap text-full text-action  <?php if($yes_margin == 1){echo 'yes_margin';} else { } ?>"   style="padding:<?php echo esc_html($height);?>px 0;color:<?php echo esc_attr($block_text_color);?> !important;background-color:<?php echo esc_attr($block_bg_color);?>;background-image:url(<?php echo esc_url($block_image);?>) !important;">
        
        <div class="container builder woocommerce">
        
			<?php if ( $title == "") {} else { ?>
            <h2 class="block block-action"  style="color:<?php echo esc_attr($block_text_color);?>;">
                
                <span class="maintitle"><?php echo esc_attr($title) ?></span><br/>
                
                <?php if ( $subtitle == "") {} else { ?>
                    <span class="subtitle" style="color:<?php echo esc_attr($block_text_color);?>;"><?php echo esc_attr($subtitle) ?></span>
                <?php } ?>
                    
            </h2>
            <?php } ?>
                   
            <?php echo wpautop(do_shortcode(htmlspecialchars_decode($text)));?>
                        
			<?php if ( $urlmore == "") {} else { ?>
            
                <a class="mainbutton ribbon actionbutton" href="<?php echo esc_url($urlmore); ?>"><?php echo esc_attr($moretitle); ?></a>
            
            <?php } ?>
            
      	</div>      

        </div>
        
        <div class="container builder woocommerce"><div><div>
      <?php
		
	}
	
}
