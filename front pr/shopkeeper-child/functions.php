<?php //Start building your awesome child theme functions

// Redirection
if( is_user_logged_in() ) {
    $page = get_page_by_title( 'Home');
    update_option( 'page_on_front', $page->ID );
    update_option( 'show_on_front', 'page' );
}
else {
    $page = get_page_by_title( 'Under Construction' );
    update_option( 'page_on_front', $page->ID );
    update_option( 'show_on_front', 'page' );
}

/** Register menus **/	
register_nav_menus( array(
    'mobile-navigation' => __( 'Mobile Navigation', 'shopkeeper' ),
) );

/***** Filter to remove the Tinymce Emoji Plugin. *****/
function rswebsols_disable_emojis_tinymce( $plugins ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
}
/***** Disable Emoji *****/
function rswebsols_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'rswebsols_disable_emojis_tinymce' );
}
add_action( 'init', 'rswebsols_disable_emojis' );