//SLIDER POST TYPE
add_action( 'init', 'cptui_register_my_cpts_slider' );

function admin_menu_cp() {
    add_menu_page(
        'Funds',
        'Funds',
        'read',
        'funds',
        '', // Callback, leave empty
        'dashicons-calendar',
        10 // Position
    );
}

add_action( 'admin_menu', 'admin_menu_cp' );

function donations() {

    $args = array(
        "labels" => array(
        "name" => __( 'Fundraisers', 'fundraisers' ),
        "singular_name" => __( 'Fundraiser', 'fundraisers' ),
        ),
        'menu_icon' => 'dashicons-format-gallery',
        "description" => "",
        "public" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => 'funds',
        "exclude_from_search" => false,
        "capability_type" => "post",
        'orderby' => 'menu_order',
        'order' => 'ASC',
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "fundraisers", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "thumbnail", "page-attributes" ),
        "taxonomies" => array("category")            

    );


    $args2 = array(
        "labels" => array(
        "name" => __( 'Cause Funds', 'cause-funds'),
        "singular_name" => __( 'Cause Fund', 'cause-funds' ),
        ),
        'menu_icon' => 'dashicons-format-gallery',
        "description" => "",
        "public" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => 'funds',
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "cause-funds", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "thumbnail", "editor" ),
        "taxonomies" => array("category")            

    );

    register_post_type( "fundraisers", $args );
    register_post_type( "cause-funds", $args2 );
}

add_action( 'init', 'donations' );

function shortcode_cause_funds() { 
    ob_start(); 
    $data = '<div class="CauseSlider">'; 
        $query = new WP_Query(array('post_type' => 'cause-funds', 'post_per_page' => -1 )); 
            while( $query->have_posts() ):$query->the_post(); 
            $data .= '<div class="cause-fund slide">'; 
            $thumb_id = get_post_thumbnail_id();
            $thumb_url = wp_get_attachment_image_src($thumb_id,'full', true);
                $data .= '<div class="cause-fund-image"><img src="'.$thumb_url[0].'" alt="cause fund image"></div>';
                $data .= '<div class="cause-fund-details"><h3>'.get_the_title().'</h3><p>'.get_the_content().'</p></div>'; 
                $data .= '<div class="cause-fund-link"><a href="'.get_field("button_link").'"target="_blank">'.get_field("button_text").'</a></div>';
            $data .= '</div>'; 
        endwhile; wp_reset_postdata(); 
    $data .= '</div>'; 
    return $data; 
 } 
add_shortcode('sc_cause_funds','shortcode_cause_funds');

function shortcode_fundraisers() { 
    ob_start(); 
    $data = '<div class="fundraisers-wrapper">'; 
        $query = new WP_Query(array('post_type' => 'fundraisers', 'post_per_page' => -1 )); 
            while( $query->have_posts() ):$query->the_post(); 
            $data .= '<div class="fundraiser">'; 
                $data .'<div class="fundraisers-image"><img src="'.get_the_post_thumbnail_url("full").'" alt="fundraisers image"></div>';
                $data .= '<div class="fundraisers-details"><h3>'.get_the_title().'</h3><p>'.get_the_content().'</p></div>'; 
                $data .= '<div class="fundraisers-link"><a href="'.get_field("button_link").'"target="_blank">'.get_field("button_text").'</a></div>';
            $data .= '</div>'; 
        endwhile; wp_reset_postdata(); 
    $data .= '</div>'; 
    return $data; 
 } 
add_shortcode('sc_fundraisers','shortcode_fundraisers');