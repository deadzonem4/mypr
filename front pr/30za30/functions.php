<?php

// Add title tag
add_theme_support( 'title-tag' );

// Add menus to Dashboard > Appearance
add_theme_support( 'menus' );

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

//Remove Query Strings 
function _remove_script_version( $src ){
	$parts = explode( '?ver', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

// Only on front-end pages, NOT in admin area
if (!is_admin()) {

	// Load CSS
	add_action('wp_enqueue_scripts', 'twbs_load_styles', 11);
	function twbs_load_styles() {
		
		// Theme Styles
		wp_register_style('theme-styles', get_template_directory_uri() . '/assets/dist/css/style.css', array(), null, 'all');
		wp_enqueue_style('theme-styles');

		wp_register_style('helper-styles', get_template_directory_uri() . '/style.css', array(), null, 'all');
		wp_enqueue_style('helper-styles');

		/* // Bootstrap
		wp_register_style('bootstrap-styles', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), null, 'all');
		wp_enqueue_style('bootstrap-styles'); */
	}

	// Load Javascript
	/*add_action('wp_enqueue_scripts', 'twbs_load_scripts', 12);
	function twbs_load_scripts() {
		// jQuery
		wp_deregister_script('jquery');
	}*/

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
		'before_widget' => '<div class="container">',
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
		'name'          => 'section-1',
		'id'            => 'section-1',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'section-2',
		'id'            => 'section-2',
		'before_widget' => '<div class="col-md-6 section2">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => 'section-6',
		'id'            => 'section-6',
		'before_widget' => '<div class="section6 clearfix">',
		'after_widget'  => '</div>',
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
remove_filter('widget_text_content', 'wpautop');

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

// Custom post type - People
function theyHaveJoined() {
  register_post_type( 'People',
    array(
      'labels' => array(
        'name' => __( 'People' ),
        'singular_name' => __( 'Person' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports'           => array( 'title', 'editor', 'thumbnail' )
    )
  );
}
add_action( 'init', 'theyHaveJoined' );

// Custom post type - Events
function events() {
  register_post_type( 'Events',
    array(
      'labels' => array(
        'name' => __( 'Events' ),
        'singular_name' => __( 'Event' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title','editor','excerpt'),
    )
  );
}
add_action( 'init', 'events' );

//WPautop
remove_filter('the_content','wpautop');
remove_filter('the_excerpt','wpautop');


function the_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow">Начало</a>';
    if (is_home()){
    	echo " &nbsp;/&nbsp;";
            global $post;
            $page_for_posts_id = get_option('page_for_posts');
            if ( $page_for_posts_id ) { 
                $post = get_page($page_for_posts_id);
                setup_postdata($post);
                the_title();
                rewind_posts();
            }
    }
    if (is_page()) {
    		echo " &nbsp;/&nbsp;";
            echo the_title();
    }
    
    if (is_category() || is_single()) {
        echo "&nbsp;/&nbsp;";
        the_category('/');
            if (is_single()) {
                echo " &nbsp;/&nbsp;";
                 the_title();
            }
     
    } elseif (is_search()) {
        echo "&nbsp;/&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '<p></em></p>"';
    }
}


