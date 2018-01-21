<?php

/**
 * Class Es_Property
 *
 * @property string $address
 * @property float $price
 * @property bool $call_for_price
 * @property bool $bedrooms
 * @property bool $bathrooms
 * @property bool $floors
 * @property float $lot_size
 * @property float $area
 * @property float $year_built
 * @property float $latitude
 * @property float $longitude
 */
class Es_Property extends Es_Post
{
    /**
     * @inheritdoc
     */
    public function get_entity_prefix()
    {
        return apply_filters( 'es_property_entity_prefix', 'es_property_' );
    }

    /**
     * Save property address components.

     * @param $data
     */
    public function save_address_components( $data )
    {
        if ( ! empty( $data ) ) {
            foreach ( $data as $item ) {
                $component_id = ES_Address_Components::save_component( $item );
                if ( ! empty( $component_id ) ) {
                    ES_Address_Components::save_property_component( $this->getID(), $component_id );
                }
            }
        }
    }

    /**
     * Return custom fields data.
     *
     * @return mixed
     */
    public function get_custom_data()
    {
        return get_post_meta( $this->_id, 'es_custom_data' );
    }

    /**
     * Save property fields.
     *
     * @param $data
     */
    public function save_fields( $data )
    {
        if ( ! empty( $data ) ) {
            $units = array();
            $fields = static::get_fields();
            $data = apply_filters( 'es_before_save_property_data', $data, $this );

            // Save address components.
            if ( ! empty( $data['address_components'] ) ) {
                $this->save_address_components( json_decode( $data['address_components'] ) );
            }

            // Save another fields.
            foreach ( $fields as $key => $field ) {
                $value = isset( $data[ $key ] ) ? $data[$key] : null;

                $value = $key == 'call_for_price' && ! $value ? 0 : $value;
                $value = $key == 'video' ? esc_attr( $value ) : $value;

                $this->save_field_value( $key, $value );

                if ( ! empty( $field['units'] ) && ! empty( $value ) ) {
                   $units[ $key ] = array(
                       'units' => $fields[ $field[ 'units' ] ]['values'],
                       'value' => $value,
                       'unit' => $data[ $field[ 'units' ] ],
                   );
                }
            }

            if ( ! empty( $units ) ) {
                $this->save_units( $units );
            }
        }
    }

    /**
     * @param $units
     */
    public function save_units( array $units )
    {
        if ( ! empty( $units ) ) {
            foreach ( $units as $field => $item ) {
                if ( empty( $item['units'] ) ) continue;

                foreach ( $item['units'] as $unit => $label ) {
                    if ( $item['unit'] == $unit ) {
                        $value = $item['value'];
                    } else {
                        $func = apply_filters( 'es_prepare_unit_callback', 'es_prepare_unit', $unit, $item, $units, $this );
                        if ( function_exists( $func ) ) {
                            $value = call_user_func( $func, $item['unit'], $unit, $item['value'] );
                        }
                    }

                    if ( ! empty( $unit ) && ! empty( $value ) ) {
                        $this->save_field_value( $field . '_' . $unit, $value );
                    }
                }
            }
        }
    }

    /**
     * Save custom property fields.
     *
     * @param $data
     */
    public function save_custom_data( $data )
    {
        if ( ! empty( $data ) ) {
            delete_post_meta( $this->getID(), 'es_custom_data' );

            foreach ( $data as $key => $value ) {
                if ( ! empty( $key ) && ! empty( $value ) ) {
                    add_post_meta( $this->getID(), 'es_custom_data', array( $key => $value ), false );
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function get_fields()
    {
        /** @var Es_Settings_Container */
        /** @var $session_storage Es_Session_Storage */
        global $es_settings, $session_storage;

        $fields = $session_storage->get( 'property_fields' );
        $builder_fields = $session_storage->get( 'property_builder_fields' );

        if ( ! $builder_fields ) {
            $builder_fields = Es_FBuilder_Helper::get_fields( 'property' );
        }

        if ( ! $fields ) {

            $fields = array(

                'date_added' => array(
                    'section' => 'es-info',
                    'label' => __( 'Date added', 'es-plugin' ),
                ),

                'price' => array(
                    'type' => 'number',
                    'tab' => 'es-basic-info',
                    'label' => __('Price', 'es-plugin'),
                    'search_range_mode' => true,
                ),

                'call_for_price' => array(
                    'type' => 'checkbox',
                    'tab' => 'es-basic-info',
                    'label' => __('Call for price', 'es-plugin'),
                    'options' => array('value' => 1, 'class' => 'es-switch-input'),
                ),

                'bedrooms' => array(
                    'type' => 'number',
                    'label' => __('Bedrooms', 'es-plugin'),
                    'tab' => 'es-basic-info',
                    'search_range_mode' => true,
                    'section' => 'es-info',
                ),

                'bathrooms' => array(
                    'type' => 'number',
                    'label' => __('Bathrooms', 'es-plugin'),
                    'tab' => 'es-basic-info',
                    'search_range_mode' => true,
                    'options' => array('step' => 0.5),
                    'section' => 'es-info',
                ),

                'floors' => array(
                    'type' => 'number',
                    'label' => __('Floors', 'es-plugin'),
                    'tab' => 'es-basic-info',
                    'search_range_mode' => true,
                    'section' => 'es-info',
                ),

                'area' => array(
                    'type' => 'number',
                    'label' => __( 'Area', 'es-plugin' ),
                    'tab' => 'es-basic-info',
                    'search_range_mode' => true,
                    'units' => 'area_unit',
                    'options' => array( 'step' => 0.1 ),
                    'formatter' => 'area',
                    'loop_callback' => array(
                        'callback' => 'es_the_formatted_area',
                        'args' => array( '', ' ', false ),
                    ),
                    'section' => 'es-info',
                ),

                'area_unit' => array(
                    'type' => 'list',
                    'values' => $es_settings::get_setting_values('unit'),
                    'template' => true,
                    'label' => false,
                    'skip_search' => true,
                ),

                'lot_size' => array(
                    'type' => 'number',
                    'label' => __( 'Lot size', 'es-plugin' ),
                    'tab' => 'es-basic-info',
                    'search_range_mode' => true,
                    'units' => 'lot_size_unit',
                    'formatter' => 'area',
                    'loop_callback' => array(
                        'callback' => 'es_the_formatted_lot_size',
                        'args' => array( '', ' ', false ),
                    ),
                    'options' => array( 'step' => 0.1 ),
                    'section' => 'es-info',
                ),

                'lot_size_unit' => array(
                    'type' => 'list',
                    'values' => $es_settings::get_setting_values('unit'),
                    'template' => true,
                    'label' => false,
                    'skip_search' => true,
                ),

                'year_built' => array(
                    'type' => 'text',
                    'label' => __('Year built', 'es-plugin'),
                    'tab' => 'es-basic-info',
                    'section' => 'es-info',
                ),

                'address' => array(
                    'type' => 'text',
                    'label' => __('Address', 'es-plugin'),
                    'tab' => 'es-address',
                    'options' => array('placeholder' => __('Address, City, ZIP', 'es-plugin'))
                ),

                'latitude' => array(
                    'type' => 'number',
                    'label' => __('Latitude', 'es-plugin'),
                    'tab' => 'es-address', 'options' => array('step' => 'any'),
                ),

                'longitude' => array(
                    'type' => 'number',
                    'tab' => 'es-address',
                    'label' => __('Longitude', 'es-plugin'),
                    'options' => array('step' => 'any'),
                ),

                'address_components' => array(
                    'type' => 'hidden',
                    'tab' => 'es-address',
                    'label' => false,
                ),

                'gallery' => array(
                    'type' => 'custom',
                    'tab' => 'es-media',
                    'template' => ES_PLUGIN_PATH . ES_DS . 'admin' . ES_DS . 'templates' .
                        ES_DS . 'property' . ES_DS . 'media.php',
                ),

                'country' => array(
                    'type' => 'list',
                    'values' => array(__('Country', 'es-plugin')),
                    'options' => array(
                        'class' => 'js-es-location',
                        'data-type' => Es_Search_Location::LOCATION_COUNTRY_TYPE,
                        'disabled' => 'disabled'
                    ),
                ),

                'state' => array(
                    'type' => 'list',
                    'values' => array(__('State', 'es-plugin')),
                    'options' => array(
                        'class' => 'js-es-location',
                        'data-type' => Es_Search_Location::LOCATION_STATE_TYPE,
                        'disabled' => 'disabled'
                    ),
                ),

                'city' => array(
                    'type' => 'list',
                    'values' => array(__('City', 'es-plugin')),
                    'options' => array(
                        'class' => 'js-es-location',
                        'data-type' => Es_Search_Location::LOCATION_CITY_TYPE,
                        'disabled' => 'disabled'
                    ),
                ),

                'neighborhood' => array(
                    'type' => 'list',
                    'values' => array(__('Neighborhood', 'es-plugin')),
                    'options' => array(
                        'class' => 'js-es-location',
                        'data-type' => Es_Search_Location::LOCATION_NEIGHBORHOOD_TYPE,
                        'disabled' => 'disabled'
                    )
                ),

                'street' => array(
                    'type' => 'list',
                    'values' => array(__('Street', 'es-plugin')),
                    'options' => array(
                        'class' => 'js-es-location',
                        'data-type' => Es_Search_Location::LOCATION_STREET_TYPE,
                        'disabled' => 'disabled'
                    ),
                ),
            );

            // Add taxonomies as property fields (for search).
            $taxonomies = Es_Taxonomy::get_taxonomies_list();
            unset($taxonomies['es_labels']);
            if (!empty($taxonomies)) {
                foreach ($taxonomies as $taxonomy) {
                    $tax = new Es_Taxonomy($taxonomy);
                    $terms = (array)get_terms($tax->get()->name, array('hide_empty' => true));
                    $values = array();

                    if ($terms) {
                        foreach ($terms as $term) {
                            $values[$term->term_id] = __($term->name, 'es-plugin');
                        }
                    }

                    $loop_callback = $taxonomy == 'es_status' ? array( 'callback' => 'es_the_status_list', 'args' => array(
                        '', ' ', '', false
                    ) ) : null;

                    $loop_callback = $taxonomy == 'es_type' ? array( 'callback' => 'es_the_types', 'args' => array(
                        '', ' ', '', false
                    ) ) : $loop_callback;

                    $loop_callback = $taxonomy == 'es_rent_period' ? array( 'callback' => 'es_the_rent_period', 'args' => array(
                        '', ' ', '', false
                    ) ) : $loop_callback;

                    $fields[$taxonomy] = array(
                        'label' => __($tax->get()->label, 'es-plugin'),
                        'system_type' => 'taxonomy',
                        'type' => 'list',
                        'section' => in_array( $taxonomy, array( 'es_rent_period', 'es_status', 'es_type' ) ) ? 'es-info' : null,
                        'loop_callback' => $loop_callback,
                        'values' => $values,
                        'options' => array(
                            'class' => 'es-select2-tags',
                            'multiple' => 'multiple',
                            'data-placeholder' => __($tax->get()->label, 'es-plugin')
                        ),
                    );
                }
            }

            $labels = self::get_labels_list();
 
            if (!empty($labels)) {
                foreach ($labels as $term) {
                    $fields = Es_Object::push_column(array(
                        $term->slug => array(
                            'type' => 'checkbox',
                            'tab' => 'es-basic-info',
                            'label' => __($term->name, 'es-plugin'),
                            'options' => array(
                                'value' => 1,
                                'class' => 'es-switch-input'
                            ),
                        ),
                    ), $fields, 2);
                }
            }

            $builder_fields['custom'] = array(
                'type' => 'custom',
                'tab' => 'es-basic-info',
                'template' => ES_PLUGIN_PATH . ES_DS . 'admin' . ES_DS . 'templates' .
                    ES_DS . 'property' . ES_DS . 'custom-fields.php',
            );

            $session_storage->set( 'property_fields', $fields );
            $session_storage->set( 'property_builder_fields', $builder_fields );
        }
        return apply_filters( 'es_property_get_fields', array_merge( $fields, $builder_fields ) );
    }

    /**
     * Return list of labels.
     *
     * @return array|int|WP_Error
     */
    public static function get_labels_list()
    {
        return get_terms( array( 'taxonomy' => 'es_labels', 'hide_empty' => false ) );
    }

    /**
     * Save property data. Used for save_post hook.
     *
     * @param $post_id
     * @param $post
     *
     * @return void
     */
    public static function save( $post_id, $post )
    {
        if ( $post->post_type == static::get_post_type_name() ) {
            // Initialize property object.
            $property = new static( $post_id );
            // Get property fields data from the post request.
            $data = filter_input( INPUT_POST, 'property', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
            // Save these fields.
            $property->save_fields( $data );

            // Saving custom property data fields (that created manually).
            $keys = filter_input(INPUT_POST, 'es_custom_key', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $values = filter_input(INPUT_POST, 'es_custom_value', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if ( ! empty( $keys ) && ! empty( $values ) ) {
                $property->save_custom_data( array_combine( $keys, $values ) );
            }
        }
    }

    /**
     * Return post type name.
     *
     * @return mixed
     */
    public static function get_post_type_name()
    {
        return apply_filters( 'es_property_post_type_name', 'properties' );
    }

    /**
     * Find properties ids using address.
     *
     * @param $address
     * @return array
     */
    public static function find_by_address( $address )
    {
        global $wpdb;

        return $wpdb->get_col( "SELECT post_id 
            FROM $wpdb->postmeta 
            WHERE meta_key = 'es_property_address' 
            AND meta_value 
            LIKE '%" . $address . "%'" );
    }
}
