<?php
/** A simple text block **/
class ML_Ads_Block extends ML_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => esc_html__('Ads (Free)','designed'),
			'size' => 'span12',
		);
		
		//create the block
		parent::__construct('ML_Ads_Block', $block_options);
	}
	
	function form($instance) {
                
	$defaults = array('title' => esc_html__('Advertisement','designed'),'block_image' =>'','adcode' => '','targeturl' => '','yes_margin' => 0,);
	$instance = wp_parse_args((array) $instance, $defaults);
   	
	extract($instance); ?>		
                
                
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('title')) ?>">
				<?php esc_html_e('Title (optional)','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('title')) ?>" class="input-full" type="text" value="<?php echo esc_attr($title) ?>" name="<?php echo esc_attr($this->get_field_name('title')) ?>">
			</label>
		</p>
        
        <p class="description">
			<label for="<?php echo ($this->get_field_id('adcode')) ?>">
				<?php esc_html_e('Content','designed'); ?>
				<?php echo ml_field_textarea('adcode', $block_id, $adcode, $size = 'full') ?>
			</label>
		</p>
        
        <p class="clearfix"></p>
        <hr>
        
        <div class="description">
			<label for="<?php echo esc_attr($this->get_field_id('block_image')) ?>">
				<?php esc_html_e('Image URL','designed'); ?><br/>
				<?php echo ml_field_upload('block_image', $block_id, $block_image, $media_type = 'image',$defaults['block_image']) ?>
			</label>
			
		</div>
        
        <p class="description">
			<label for="<?php echo esc_attr($this->get_field_id('targeturl')) ?>">
				<?php esc_html_e('Target URL','designed'); ?>
				<input id="<?php echo esc_attr($this->get_field_id('targeturl')) ?>" class="input-full" type="text" value="<?php echo esc_url($targeturl) ?>" name="<?php echo esc_attr($this->get_field_name('targeturl')) ?>">
			</label>
		</p>
        
        <p class="clearfix"></p>
        <hr>
        
        <p class="description">
        <label for="<?php echo esc_attr($this->get_field_id('yes_margin')) ?>">
                <?php echo ml_field_checkbox('yes_margin', $block_id, $yes_margin) ?>
                <?php esc_html_e('Add margin at the bottom','designed'); ?>
        </label>
        </p>
        
		<?php
	}
	
		
		
		
		function block($instance) {
                extract($instance);

        $title = $instance['title'];
        $adcode = $instance['adcode'];
        $image = $instance['block_image'];
        $targeturl = $instance['targeturl'];
		
		?>
		
			<?php if ( $title == "") {} else { ?>
            <h2 class="ads-block">
                    <span><?php echo esc_attr($title) ?></span>
            </h2>
            <?php } ?><!-- end title section-->
            
            <div class="ads-block <?php if($yes_margin == 1){echo 'yes_margin';} else { } ?>">
            
				<?php if($adcode != ''){ ?>
                        
                    <div class="body3 bgfix"><?php echo do_shortcode(htmlspecialchars_decode($adcode));?></div>
            
                <?php } else { ?>
                
                    <a class="item" href="<?php echo esc_url($targeturl); ?>">
                    
                            <img class="grayscale grayscale-fade" src="<?php echo esc_url($image); ?>" alt="<?php esc_html_e('Visit Sponsor','designed');?>" />
                    
                    </a>
                            
                <?php	} ?>
			
			</div>
                
        <?php }
	
}
ml_register_block('ML_Ads_Block');