<?php
//definitions
if(!defined('DESIGNED_BLOCK_PATH')) define( 'DESIGNED_BLOCK_PATH', get_template_directory() . '/functions/layout-blocks/' );

// plugin related blocks

// detect plugin 
if ( class_exists( 'MasterMag' ) ) {
	
	

	//  2/3 (content) block
	require_once(DESIGNED_BLOCK_PATH . 'ml-2-3-column-block.php');
	ml_register_block('ML_2_3_Column_Block');
	
	// 1/3 (sidebar) block
	require_once(DESIGNED_BLOCK_PATH . 'ml-3-column-block.php');
	ml_register_block('ML_3_Column_Block');
	
	//blog
	require_once(DESIGNED_BLOCK_PATH . 'ml-blog-classic.php');
	ml_register_block('ML_Blog');
	
	//home1
	require_once(DESIGNED_BLOCK_PATH . 'ml-home-1.php');
	ml_register_block('ML_Home_1');
	
	//home2
	require_once(DESIGNED_BLOCK_PATH . 'ml-home-2.php');
	ml_register_block('ML_Home_2');
	
	//home3
	require_once(DESIGNED_BLOCK_PATH . 'ml-home-3.php');
	ml_register_block('ML_Home_3');
	
	//home4
	require_once(DESIGNED_BLOCK_PATH . 'ml-home-4.php');
	ml_register_block('ML_Home_4');
	
	//mosaic
	require_once(DESIGNED_BLOCK_PATH . 'ml-mosaic.php');
	ml_register_block('ML_Mosaic');
	
	//main slider
	require_once(DESIGNED_BLOCK_PATH . 'ml-main-slider.php');
	ml_register_block('ML_Slider');
	
	//main slider
	require_once(DESIGNED_BLOCK_PATH . 'ml-small-slider.php');
	ml_register_block('ML_Slider_Small');
	
	//info posts
	require_once(DESIGNED_BLOCK_PATH . 'ml-mp-info.php');
	ml_register_block('ML_MP_Info');
	
	//menu posts
	require_once(DESIGNED_BLOCK_PATH . 'ml-custom-menu.php');
	ml_register_block('ML_Custom_Menu');
	
	// ads block
	require_once(DESIGNED_BLOCK_PATH . 'ml-ads-block.php');
	ml_register_block('ML_Ads_Block');
	
	// text (block-width) block
	require_once(DESIGNED_BLOCK_PATH . 'ml-text-block.php');
	ml_register_block('ML_Text_Block');
	
	// text (full-width) block
	require_once(DESIGNED_BLOCK_PATH . 'ml-text-block-full.php');
	ml_register_block('ML_Text_Block_Full');

	// call to action block
	require_once(DESIGNED_BLOCK_PATH . 'ml-text-block-action.php');
	ml_register_block('ML_Text_Block_Action');
	
	// widgets block
	require_once(DESIGNED_BLOCK_PATH . 'ml-widgets.php');
	ml_register_block('ML_Widgets_Block');
	
	// clear block
	require_once(DESIGNED_BLOCK_PATH . 'ml-clear-block.php');
	ml_register_block('ML_Clear_Block');



		
}


/*-----------------------------------------------------------------------------------*/
/* REDUX - speciable */
/*-----------------------------------------------------------------------------------*/

if ( class_exists( 'ReduxFrameworkPlugin' ) ) {

function designed_custom_style() {
			wp_enqueue_style('portal-custom-style',get_template_directory_uri() . '/styles/custom-style.css'
	);
	$themnific_redux = get_option( 'themnific_redux' );
	if (empty($themnific_redux['tmnf-custom-css'])) {} else {
	$custom_redux = $themnific_redux['tmnf-custom-css'];
	wp_add_inline_style( 'portal-custom-style', $custom_redux );
	}

}
add_action( 'wp_enqueue_scripts', 'designed_custom_style' );

} else {
	
	function designed_enqueue_reduxfall() {
		
		// Redux fallback
		wp_enqueue_style('reduxfall', get_template_directory_uri() . '/styles/reduxfall.css');
		
		// google link
		function designed_fonts_url() {
			$font_url = '';
			if ( 'off' !== _x( 'on', 'Google font: on or off','designed') ) {
				$font_url = add_query_arg( 'family', urlencode( 'Varela Round:400|Montserrat:400,700&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
			}
			return $font_url;
		}
    	wp_enqueue_style( 'tmnf-fonts', designed_fonts_url(), array(), '1.0.0' );

		
	}
	add_action( 'wp_enqueue_scripts', 'designed_enqueue_reduxfall' );
	
}




/*-----------------------------------------------------------------------------------*/
/* THE END */
/*-----------------------------------------------------------------------------------*/
?>