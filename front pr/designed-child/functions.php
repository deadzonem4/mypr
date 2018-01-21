<?php 

// load parent styles
add_action( 'wp_enqueue_scripts', 'designed_child_enqueue_styles' );
function designed_child_enqueue_styles() {
    wp_enqueue_style( 'designed_child-style', get_template_directory_uri() . '/style.css' );
			
}

// start editing


?>