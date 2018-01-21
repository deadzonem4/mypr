<?php

// Add title tag
add_theme_support( 'title-tag' );

// Add menus to Dashboard > Appearance
add_theme_support( 'menus' );

// Contact form 7
add_filter( 'wpcf7_load_js', '__return_false' );

// Add options page to dashboard
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page();
}

// Hide admin bar when logged in
add_filter('show_admin_bar', '__return_false');

// featured post image
add_theme_support( 'post-thumbnails' );

// excerpts 
function wpdocs_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

// Only on front-end pages, NOT in admin area
if (!is_admin()) {

	// Load CSS
	add_action('wp_enqueue_scripts', 'twbs_load_styles');
	function twbs_load_styles() {
		
		// Theme Styles
		wp_register_style('theme-styles', get_template_directory_uri() . '/assets/dist/css/style.css', array(), 99, 'all');
		wp_enqueue_style('theme-styles');
		wp_register_style('theme-styles-1', get_template_directory_uri() . '/style.css', array(), 98, 'all');
		wp_enqueue_style('theme-styles-1');

		 // Bootstrap
		wp_register_style('bootstrap-styles', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), null, 'all');
		wp_enqueue_style('bootstrap-styles'); 

		// Slick
		wp_register_style('slick-styles', get_template_directory_uri() .'/assets/dist/js/slick/slick.css' , array(), null, 'all');
		wp_enqueue_style('slick-styles'); 

		// Slick theme
		wp_register_style('slick-theme-styles', get_template_directory_uri() .'/assets/dist/js/slick/slick-theme.css' , array(), null, 'all');
		wp_enqueue_style('slick-theme-styles'); 

		// Font Awesome
		wp_register_style('FontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' , array(), null, 'all');
		wp_enqueue_style('FontAwesome'); 

		// // Load Javascript
		wp_enqueue_script('jquery-1.12', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js', array('jquery'));
		wp_enqueue_script('sticky-footer', get_template_directory_uri() .'/assets/dist/js/sticky-footer.js', array('jquery'));
		wp_enqueue_script('slick-min-js', get_template_directory_uri() .'/assets/dist/js/slick/slick.min.js', array());
		wp_enqueue_script('script-min-js', get_template_directory_uri() .'/assets/dist/js/scripts.min.js', array('jquery'));
		wp_enqueue_script('bootstrap-js', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array());
		// add_action('wp_enqueue_scripts', 'twbs_load_scripts', 12);
		// function twbs_load_scripts() {
		// 	// jQuery
		// 	wp_deregister_script('jquery');
		// }
		wp_enqueue_script('slick-items', get_template_directory_uri() .'/assets/dist/js/slick-items.js', array('jquery'));
	}	
	
} // end if !is_admin


// menus
function register_my_menu() {
  register_nav_menu('header-menu',__( 'Top Menu Left' ));
  register_nav_menu('enquire-buttons',__( 'enquire buttons' ));
  register_nav_menu('services-menu',__( 'Home services menu' ));
  register_nav_menu('footer-menu-right',__( 'Footer Right' ));
  register_nav_menu('footer-menu-center',__( 'Footer Center' ));
  register_nav_menu('footer-menu-left',__( 'Footer Left' ));

}
add_action( 'init', 'register_my_menu' );

// widgets
function arphabet_widgets_init() {

	register_sidebar( array(
		'name'          => 'menu',
		'id'            => 'menu',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'category',
		'id'            => 'category',
		'before_widget' => '<div style="display:inline;">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

register_sidebar( array(
		'name'          => 'list',
		'id'            => 'list',
		'before_widget' => '<aside class="bull-list">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'video',
		'id'            => 'video',
		'before_widget' => '<aside class="filter-box container">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'video-text-left',
		'id'            => 'video-text-left',
		'before_widget' => '<aside class="col-sm-4 video-text">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'video-text-center',
		'id'            => 'video-text-center',
		'before_widget' => '<aside class="col-sm-4 video-text">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'video-text-right',
		'id'            => 'video-text-right',
		'before_widget' => '<aside class="col-sm-4 video-text">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );


	register_sidebar( array(
		'name'          => 'footer-text',
		'id'            => 'footer-text',
		'before_widget' => '<div class="footer-text">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'arphabet_widgets_init' );


//SLIDER POST TYPE
add_action( 'init', 'cptui_register_my_cpts_slider' );

function cptui_register_my_cpts_slider() {

	$labels = array(
		"name" => __( 'Sliders', 'kota' ),
		"singular_name" => __( 'Slider', 'kota' ),
		);



	$args = array(
		"label" => __( 'Sliders', 'kota' ),
		"labels" => $labels,
		'menu_icon' => 'dashicons-format-gallery',
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "slider", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title", "thumbnail" ),			

	);

	register_post_type( "slider", $args );
}


// REMOVE WP EMOJI
function disable_wp_emojicons() {
// remove all actions related to emojis
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
}
add_action( 'init', 'disable_wp_emojicons' );

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function wpdocs_custom_excerpt_length( $length ) {
    return 8;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );