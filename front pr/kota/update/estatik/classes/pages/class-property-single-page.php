<?php

/**
 * Class Es_Property_Single_Page
 */
class Es_Property_Single_Page extends Es_Object
{
    /**
     * Adding actions for single property page.
     */
    public function actions()
    {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'es_property_single_features', array( $this, 'single_features' ) );
        add_action( 'es_single_gallery', array( $this, 'single_gallery' ) );
        add_action( 'es_single_share', array( $this, 'single_share' ) );
        add_action( 'es_single_fields', array( $this, 'single_fields' ) );
        add_action( 'es_single_tabs', array( $this, 'single_tabs' ) );
        add_action( 'es_map', array( $this, 'map' ) );
        add_action( 'es_single_info', array( $this, 'single_info' ) );
        add_action( 'es_single_top_button', array( $this, 'single_top_button' ) );
        add_action( 'wp_head', array( $this, 'es_open_graph' ), 5 );

        add_action( 'es_single_description_tab', array( $this, 'single_description_tab' ) );
        add_action( 'es_single_map_tab', array( $this, 'single_map_tab' ) );
        add_action( 'es_single_features', array( $this, 'single_features' ) );
    }

    /**
     * Render property description tab content.
     *
     * @return void
     */
    function single_description_tab() {
        if ( get_the_content() ) : ?>
            <div class="es-tabbed-item es-description col-sm-12" id="es-description">
                <h3><?php _e( 'Description', 'es-plugin' ); ?></h3>
                <?php es_the_content(); ?>

                <?php do_action( 'es_single_tabbed_content_after', 'es-description' ); ?>
            </div>
        <?php endif;
    }

    /**
     * Render content of the map tab.
     *
     * @return void
     */
    public function single_map_tab() {
        global $post, $es_settings;
        $es_property = es_get_property( $post->ID );
        if ( ! empty( $es_property->latitude ) && ! empty( $es_settings->google_api_key ) ) : ?>
            <div class="es-tabbed-item es-map" id="es-map">
                <h3><?php _e( 'View on map / Neighborhood', 'es-plugin' ); ?></h3>
                <?php do_action( 'es_map' ); ?>
                <?php do_action( 'es_single_tabbed_content_after', 'es-map' ); ?>
            </div>
        <?php endif;
    }

    /**
     * Render features list.
     *
     * @return void
     */
    public function single_features()
    {
        $data = self::get_features_data();

        $template = apply_filters( 'es_features_list_template_path', ES_TEMPLATES . '/property/features-list.php' );

        if ( $data ) : ?>
            <div class="es-tabbed-item es-features col-sm-4 col-sm-offset-2" id="es-features">
                <h3><?php _e( 'Features', 'es-plugin' ); ?></h3>
                <?php foreach ( $data as $features_list_title => $features_list ) : ?>
                    <?php include $template; ?>
                <?php endforeach; ?>
                <?php do_action( 'es_single_tabbed_content_after', 'es-features' ); ?>
            </div>
        <?php endif;
    }

    /**
     * Adding filters for single property page.
     *
     * @return void
     */
    public function filters()
    {
        add_filter( 'es_global_js_variables', array( $this, 'global_js_variables' ), 10, 1 );
        add_filter( 'language_attributes', array( __CLASS__, 'open_graph_doctype' ) );
        add_filter( 'the_content', array( $this, 'the_content' ) );
    }

    /**
     * Register OpenGraph schema.
     *
     * @param $output
     * @return string
     */
    public static function open_graph_doctype( $output )
    {
        global $post_type;

        if ( is_single() && $post_type == Es_Property::get_post_type_name() ) {
            $output = $output . '
            xmlns:og="http://opengraphprotocol.org/schema/"
            xmlns:fb="http://www.facebook.com/2008/fbml"';
        }

        return $output;
    }

    /**
     * Add open graph tags for single property page.
     *
     * @return void.
     */
    public function es_open_graph()
    {
        global $post;

        if( is_single() && $post->post_type == Es_Property::get_post_type_name() ) {
            $property = es_get_property( $post->ID );

            if ( ! empty( $property->gallery[0] ) ) {
                $img_src = wp_get_attachment_image_src( $property->gallery[0], 'thumbnail' );
            }

            if ( $excerpt = $post->post_excerpt ) {
                $excerpt = strip_tags( $post->post_excerpt );
            } else {
                $excerpt = get_bloginfo( 'description' );
            } ?>

            <meta property="og:title" content="<?php the_title(); ?>"/>
            <meta property="og:description" content="<?php echo $excerpt; ?>"/>
            <meta property="og:type" content="article"/>
            <meta property="og:url" content="<?php the_permalink(); ?>"/>
            <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>

            <?php if ( ! empty( $img_src[0] ) ) : ?>
                <meta property="og:image" content="<?php echo $img_src[0]; ?>"/>
            <?php endif; ?>

            <?php
        }
    }

    /**
     * Enqueue scripts for single property page.
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        global $post_type, $es_settings;

        $custom = 'assets/js/custom/';

        $property = es_get_property( null );

        if ( $property::get_post_type_name() == $post_type && is_single() ) {

            $deps = array ( 'jquery', 'es-front-script' );

            if ( ! empty( $es_settings->google_api_key ) ) {
                $deps[] = 'es-admin-map-script';
            }

            wp_register_script( 'es-front-single-script', ES_PLUGIN_URL . $custom . 'front-single.js', $deps );

            wp_enqueue_script( 'es-front-single-script' );

            wp_register_script( 'es-slick-script', 'http://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array (
                'jquery', 'es-front-script',
            ) );

            wp_enqueue_script( 'es-slick-script' );

            wp_register_script( 'es-share-script', 'https://static.addtoany.com/menu/page.js' );
            wp_enqueue_script( 'es-share-script' );

            wp_localize_script( 'es-front-single-script', 'Estatik', Estatik::register_js_variables() );
        }
    }

    /**
     * Enqueue styles for single property page.
     *
     * @return void
     */
    public function enqueue_styles()
    {
        global $post_type;

        $custom = 'assets/css/custom/';

        $property = es_get_property( null );

        if ( $property::get_post_type_name() == $post_type && is_single() ) {
            wp_register_style( 'es-slick-style', 'http://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css' );
            wp_enqueue_style( 'es-slick-style' );

            wp_register_style( 'es-front-single-style', ES_PLUGIN_URL . $custom . 'front-single.css' );
            wp_enqueue_style( 'es-front-single-style' );
        }
    }

    /**
     * Property global javascript variables.
     *
     * @param $data
     * @return mixed
     */
    public function global_js_variables( $data )
    {
        global $post, $es_property;

        $property = es_get_property( null );

        if ( is_single() && $post->post_type == $property::get_post_type_name() ) {

            // Add property coordinates for google maps.
            $data['property'] = array(
                'lat' => (float) $es_property->latitude,
                'lon' => (float) $es_property->longitude,
            );
        }

        return $data;
    }

    /**
     * Return single property page tabs.
     *
     * @return array
     */
    public static function get_tabs()
    {
        return apply_filters( 'es_single_property_tabs', array(
            'es-info' => __( 'Basic facts', 'es-plugin' ),
            'es-map' => __( 'Neighborhood', 'es-plugin' ),
            'es-features' => __( 'Features', 'es-plugin' ),
        ) );
    }

    /**
     * Return single property page tabs.
     *
     * @return array
     */
    public static function get_sections()
    {
        return apply_filters( 'es_property_sections', array(
            'es-info' => array(
                'machine_name' => 'es-info',
                'label' => __( 'Basic facts', 'es-plugin' ),
                'sortable' => false,
            ),
            'es-features' => array(
                'machine_name' => 'es-features',
                'label' => __( 'Features', 'es-plugin' ),
                'render_action' => 'es_single_features',
            ),
            'es-description' => array(
                'machine_name' => 'es-description',
                'label' => __( 'Description', 'es-plugin' ),
                'render_action' => 'es_single_description_tab',
            ),
            'es-map' => array(
                'machine_name' => 'es-map',
                'label' => __( 'Neighborhood', 'es-plugin' ),
                'render_action' => 'es_single_map_tab',
            )            
        ) );
    }

    /**
     * Return features data.
     *
     * @return array
     */
    public static function get_features_data()
    {
        $data = array();

        if ( $features = es_get_the_features() ) {
            $data[ __( 'Features', 'es-plugin' ) ] = $features;
        }

        if ( $features = es_get_the_amenities() ) {
            $data[ __( 'Amenities', 'es-plugin' ) ] = $features;
        }

        return apply_filters( 'es_single_features_data', $data );
    }

    /**
     * Render gallery on property single page.
     *
     * @return void
     */
    public function single_gallery()
    {
        $template = apply_filters( 'es_single_gallery_template_path', ES_TEMPLATES . 'property/gallery.php' );
        include $template;
    }

    /**
     * Render property fields.
     *
     * @return void
     */
    public function single_fields()
    {
        $template = apply_filters( 'es_single_gallery_fields_path', ES_TEMPLATES . 'property/fields.php' );
        include $template;
    }

    /**
     * Return fields for render.
     *
     * @return mixed|array
     */
    public static function get_single_fields_data()
    {
        global $es_property;
        $custom = $es_property->get_custom_data();

        $data = array(
            array( __( 'Status', 'es-plugin' ) => es_the_status_list('', ' ', '', false ) ),
            array( __( 'Type', 'es-plugin' ) => es_the_types('', ' ', '', false ) ),
            array( __( 'Area size', 'es-plugin' ) => es_the_formatted_area( '', ' ', false ) ),
            array( __( 'Lot size', 'es-plugin' ) => es_the_formatted_lot_size( '', ' ', false ) ),  
            array( __( 'Rent period', 'es-plugin' ) => es_the_rent_period('', ' ', '', false ) ),          
            array( __( 'Bedrooms', 'es-plugin' ) => es_get_the_property_field( 'bedrooms' ) ),
            array( __( 'Bathrooms', 'es-plugin' ) => es_get_the_property_field( 'bathrooms' ) ),
            array( __( 'Floors', 'es-plugin' ) => es_get_the_property_field( 'floors' ) ),
            array( __( 'Year built', 'es-plugin' ) => es_get_the_property_field( 'year_built' ) ),
            array( __( 'Date added', 'es-plugin' ) => es_the_date('', '', false ) ),
        );

        // Include custom fields.
        if ( ! empty( $custom ) ) {
            foreach ( $custom as $value ) {
                $data[] = array( __( key( $value ), 'es-plugin' ) => __( reset($value), 'es-plugin' ) );
            }
        }

        return apply_filters( 'es_single_fields_data', $data );
    }

    /**
     * @param $fields
     * @return array
     */
    public static function get_fields_render_data( $fields ) {
        $data = array();

        if ( $fields ) {
            foreach ( $fields as $key => $field ) {
                if ( ! empty( $field['section'] ) ) {
                    $data[ __( $field['label'], 'es-plugin' ) ] = $field['formatter'] ?
                        es_get_the_formatted_field( $key, $field['formatter'] ) : es_get_the_property_field( $key );
                }
            }
        }

        return $data;
    }

    /**
     * Render single property tabs.
     *
     * @return void
     */
    public function single_tabs()
    {
        $template = apply_filters( 'es_single_tabs_template_path', ES_TEMPLATES . 'property/tabs.php' );
        include $template;
    }

    /**
     * Render single property map.
     *
     * @return void
     */
    public function map()
    {
        es_the_map();
    }

    /**
     * Render single property info.
     *
     * @return void
     */
    public function single_info()
    {
        global $es_settings;

        if ( $es_settings->single_layout == 'right' ) {
            do_action( 'es_single_fields' );
            do_action( 'es_single_gallery' );

        } else {
            do_action( 'es_single_gallery' );
            do_action( 'es_single_fields' );
        }
    }

    /**
     * Render Top button.
     *
     * @return void
     */
    function single_top_button()
    {
        ob_start(); ?>
        <div class="es-top-arrow">
            <a href="body" class="es-top-link"><?php _e( 'To top', 'es-plugin' ); ?></a>
        </div><?php
        $result = ob_get_clean();

        echo apply_filters( 'es_single_top_button_markup', $result );
    }

    /**
     * Render share buttons.
     */
    public function single_share()
    {
        $template = apply_filters( 'es_single_share_template_path', ES_TEMPLATES . 'property/share.php' );
        include $template;
    }

    /**
     * @param $content
     * @return mixed
     */
    public function the_content( $content = null )
    {
        global $post_type;

        if ( ! empty( $post_type ) && $post_type == Es_Property::get_post_type_name() && is_single() ) {
            return do_shortcode( '[es_single]' );
        }
        return $content;
    }
}
