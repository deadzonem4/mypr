<?php

/**
 * Class Es_FBuilder
 */
class Es_FBuilder extends Es_Object {

    /**
     * @inheritdoc
     */
    public function filters() {
        add_filter( 'es_single_fields_data', array( $this, 'single_fields_data' ), 10, 1 );
        add_filter( 'es_save_property_field_value', array( $this, 'save_field_value_format' ), 10, 3 );
        add_filter( 'es_get_entity_field_value', array( $this, 'get_field_value_formatted' ), 10, 3 );
    }

    /**
     * Filter field value output.
     *
     * @param $value
     * @param $field
     * @param $entity
     * @return false|string
     */
    public function get_field_value_formatted( $value, $field, $entity ) {
        $p = new Es_Property();
        if ( $p->get_entity_prefix() == $entity ) {
            $field = Es_Property::get_field_info( $field );

            global $es_settings;

            if ( ! empty( $field['type'] ) ) {
                if ( ! empty( $value ) && ( 'datetime-local' == $field['type'] || 'date' == $field['type'] ) ) {
                    $value = date( 'datetime-local' == $field['type'] ? $es_settings->date_format . ' H:i' : $es_settings->date_format, $value );
                }
            }
        }

        return $value;
    }

    /**
     * Filter saving property value.
     *
     * @param $value
     * @param $field
     * @return mixed
     */
    public function save_field_value_format( $value, $field ) {
        $field = Es_Property::get_field_info( $field );

        if ( ! empty( $field['type'] ) ) {
            if ( ! empty( $value ) && ( 'datetime-local' == $field['type'] || 'date' == $field['type'] ) ) {
                $value = strtotime( $value );
            }
        }
        return $value;
    }

    /**
     * Filter property fields.
     *
     * @param $fields
     * @return array
     */
    public function single_fields_data( $fields ) {
        global $es_property;
        $custom = $es_property->get_custom_data();

        $data = array(
            array( __( 'Status', 'es-plugin' ) => es_the_status_list('', ' ', '', false ) ),
            array( __( 'Type', 'es-plugin' ) => es_the_types('', ' ', '', false ) ),
            array( __( 'Area size', 'es-plugin' ) => es_the_formatted_area( '', ' ', false ) ),
            array( __( 'Lot size', 'es-plugin' ) => es_the_formatted_lot_size( '', ' ', false ) ),
            array( __( 'Rent period', 'es-plugin' ) => es_the_rent_period('', ' ', '', false ) ),
            array( __( 'Date added', 'es-plugin' ) => es_the_date('', '', false ) ),
            // array( __( 'Rent period', 'es-plugin' ) => es_the_rent_period('', ' ', '', false ) ),
            // array( __( 'Bedrooms', 'es-plugin' ) => es_get_the_property_field( 'bedrooms' ) ),
            // array( __( 'Bathrooms', 'es-plugin' ) => es_get_the_property_field( 'bathrooms' ) ),
            // array( __( 'Floors', 'es-plugin' ) => es_get_the_property_field( 'floors' ) ),
            // array( __( 'Year built', 'es-plugin' ) => es_get_the_property_field( 'year_built' ) ),
        );

        $fields = Es_FBuilder_Helper::get_entity_fields( 'property', 'es-info' );

        if ( $fields ) {
            foreach ( $fields as $key => $field ) {
                if ( ! empty( $field['section'] ) && $field['section'] == 'es-info' ) {
                    $data[] = array( __( $field['label'], 'es-plugin' ) => ! empty( $field['formatter'] ) ?
                        es_get_the_formatted_field( $key, $field['formatter'] ) : es_get_the_property_field( $key ) );
                }
            }
        }

        // Include custom fields.
        if ( ! empty( $custom ) ) {
            foreach ( $custom as $value ) {
                $data[] = array( __( key( $value ), 'es-plugin' ) => __( reset($value), 'es-plugin' ) );
            }
        }

        return apply_filters( 'es_fbuilder_single_fields_data', $data );
    }
}
