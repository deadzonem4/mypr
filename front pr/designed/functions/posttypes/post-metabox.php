<?php 
$meta_boxes = array();
$meta_box = array(
    'id' => 'meta-box-video',
    'title' => esc_html__( 'Themnific Post Options','designed' ),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(	

	
		array(
			'name' => '',
			'desc' => esc_html__( 'Sidebar/Featured Image Options','designed' ),
			'id' => 'themnific_main_rating',
			'type' => 'heading',
			'std' => ''
		),
				
				array(
					'name' => esc_html__( 'Show featured image in Single post','designed' ),
					'desc' => esc_html__( 'Optional usage','designed' ),
					'id' => 'themnific_single_featured',
					'type' => 'select',
					'std' => '',
					'options' => array('Yes','No')
				),
		
				array(
					'name' => esc_html__( 'Image Size & Position','designed' ),
					'desc' => '',
					'id' => 'themnific_image_single',
					'type' => 'select',
					'std' => 'Classic',
					'options' => array('Classic','Full','Large')
				),
		
				array(
					'name' => esc_html__( 'Post sidebar','designed' ),
					'desc' => '',
					'id' => 'themnific_sidebar',
					'type' => 'select',
					'std' => '',
					'options' => array('Right','Left','None')
				),

		
		array(
			'name' => '',
			'desc' => esc_html__( 'Post Formats','designed' ),
			'id' => 'themnific_main_rating',
			'type' => 'heading',
			'std' => ''
		),
				
			
				array(
					'name' => esc_html__( 'Video URL','designed' ),
					'desc' => esc_html__( 'Paste plain video URL (YouTube or Vimeo); e.g. http://vimeo.com/115014610  ','designed' ),
					'id' => 'themnific_video',
					'type' => 'textarea',
					'std' => ''
				),
				
				
				array(
					'name' => esc_html__( 'Link','designed' ),
					'desc' => esc_html__( 'Insert the URL you wish to link to','designed' ),
					'id' => 'themnific_linkss',
					'type' => 'text',
					'std' => ''
				),	

	
		array(
			'name' => '',
			'desc' => esc_html__( 'Product Options','designed' ),
			'id' => 'themnific_main_rating',
			'type' => 'heading',
			'std' => ''
		),
		
		
				array(
					'name' => esc_html__( 'Product: Price','designed' ),
					'desc' => esc_html__( 'Enter product price, do not forget currency sign ($, €, ¥ etc.)','designed' ),
					'id' => 'themnific_product_price',
					'type' => 'text',
					'std' => ''
				),	
				
				array(
					'name' => esc_html__( 'Product: "Buy" label','designed' ),
					'desc' => esc_html__( 'Enter some label; e.g. Buy Now, Buy from','designed' ),
					'id' => 'themnific_product_label',
					'type' => 'text',
					'std' => ''
				),	
				
				array(
					'name' => esc_html__( 'Product: Target URL','designed' ),
					'desc' => esc_html__( 'Paste target link (URL)','designed' ),
					'id' => 'themnific_product_url',
					'type' => 'text',
					'std' => ''
				),	
				
				
		array(
			'name' => '',
			'desc' => esc_html__( 'Advertisement - override Post Static Ad (set in Admin panel)','designed' ),
			'id' => 'themnific_main_rating',
			'type' => 'heading',
			'std' => ''
		),	
				
				array(
					'name' => esc_html__( 'Ad Banner','designed' ),
					'desc' => esc_html__( 'You can add 728px wide image here - paste URL of the image','designed' ),
					'id' => 'themnific_single_banner',
					'type' => 'text',
					'std' => ''
				),	
				
				array(
					'name' => esc_html__( 'Ad Target URL','designed' ),
					'desc' => esc_html__( 'Paste target URL','designed' ),
					'id' => 'themnific_single_target',
					'type' => 'text',
					'std' => ''
				),	
		
				
	
    )
);




add_action('admin_menu', 'themnific_add_box');

// Add meta box
function themnific_add_box() {
    global $meta_box;

    add_meta_box($meta_box['id'], $meta_box['title'], 'themnific_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}


// enqueue scripts and styles, but only if is_admin
add_action('admin_head','tmnf_add_custom_scripts');
function tmnf_add_custom_scripts() {

	if(is_admin()) {
		wp_enqueue_style('metaboxes', get_template_directory_uri().'/functions/posttypes/style.css');
	}

}

// Callback function to show fields in meta box
function themnific_show_box() {
    global $meta_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="themnific_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr class="meta">',
                '<th style="width:15%; padding-left:30px;"><label for="', esc_attr( $field['id']), '">', esc_attr($field['name']), '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input style="width:34%;" type="text" name="', esc_attr( $field['id']), '" id="', esc_attr( $field['id']), '" value="', esc_attr($meta ? $meta : $field['std']), '" size="30" style="width:97%" />', '<br />', esc_attr( $field['desc']);
                break;
				
            case 'heading':
                echo '<h3 id="',esc_attr(  $field['id']), '" class="meta">'; echo esc_attr( $field['desc']); echo '</h3>';
                break;
				
				
            case 'line':
                echo '<hr class="meta">';
                break;
				
            case 'textarea':
                echo '<textarea name="',esc_attr(  $field['id']), '" id="',esc_attr(  $field['id']), '" cols="60" rows="4" style="width:97%">',esc_textarea( $meta ? $meta : $field['std']), '</textarea>', '<br />', $field['desc'];
                break;
            case 'select':
                echo '<select name="', esc_attr( $field['id']), '" id="', esc_attr( $field['id']), '" class="meta">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', esc_attr($option), '</option>';
                }
                echo '</select>', '<br />', esc_attr($field['desc']);
        }
        echo     '<td>',
            '</tr>';
    }

    echo '</table>';
}


add_action('save_post', 'themnific_save_data');

// Save data from meta box
function themnific_save_data($post_id) {
    global $meta_box;

    // verify nonce
	
	if (isset($_POST['themnific_meta_box_nonce'])) {
	
    if (!wp_verify_nonce($_POST['themnific_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;

    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, sanitize_text_field($field['id']), $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, sanitize_text_field($field['id']), $old);
        }
    }
}}

?>