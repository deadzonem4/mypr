<?php

/**
 * Class Es_FBuilderRepository
 */
class Es_FBuilder_Helper
{
    /**
     * @return mixed
     */
    public static function get_field_types()
    {
        return apply_filters( 'es_fbuilder_field_types', array(
            'text' => __( 'Text', 'es-plugin' ),
            'number' => __( 'Number', 'es-plugin' ),
            'price' => __( 'Price', 'es-plugin' ),
            'area' => __( 'Area', 'es-plugin' ),
            'list' => __( 'Select', 'es-plugin' ),
            'textarea' => __( 'Text area', 'es-plugin' ),
            'date' => __( 'Date', 'es-plugin' ),
            'datetime-local' => __( 'Date time', 'es-plugin' ),
            'email' => __( 'Email', 'es-plugin' ),
            'tel' => __( 'Tel', 'es-plugin' ),
            'url' => __( 'Url', 'es-plugin' ),
        ) );
    }

    /**
     * Return field edit link.
     *
     * @param $id
     *    Field ID.
     * @return string
     *    Return field edit link.
     */
    public static function get_field_edit_link( $id ) {
        return add_query_arg( array(
            'action' => 'es-fbuilder-edit-field',
            'id' => $id,
        ) );
    }

    /**
     * Return remove field link.
     *
     * @param $id
     * @return string
     */
    public static function get_field_delete_link( $id )
    {
        return add_query_arg( array(
            'action' => 'es-fbuilder-remove-field',
            'id' => $id,
            'nonce' => wp_create_nonce( 'es-fbuilder-remove-field' )
        ) );
    }

    /**
     * Check if edit page is active.
     *
     * @return bool
     */
    public static function is_edit_action() {
        return self::get_edit_field() ? true : false;
    }

    /**
     * @return array|null|object
     */
    public static function get_edit_field()
    {
        if ( ! empty( $_GET['id'] ) && ! empty( $_GET['action'] ) ) {
            $field =  self::get_field( $_GET['id'] );

            $field['type'] = ! empty( $field['formatter'] ) ? $field['formatter'] : $field['type'];

            return $field;
        }

        return null;
    }

    /**
     * @param $entity
     * @param $section
     *
     * @return mixed
     */
    public static function get_entity_fields( $entity, $section = null ) {
        $result = array();
        $fields = array();

        $callback = apply_filters( 'es_fbuilder_get_entity_section_fields_callback', 'es_get_' . $entity, $entity );

        if ( function_exists( $callback ) ) {
            /** @var Es_Entity $entity */
            $entity = $callback( null );
            $fields = $entity::get_fields();
        }

        if ( $section ) {
            $result = ! $result ? $fields : $result;

            foreach ( $result as $key => $field ) {
                if ( empty( $field['section'] ) || ( ! empty( $field['section'] ) && $field['section'] != $section ) ) {
                    unset( $result[ $key ] );
                }
            }
        }

        $result = empty( $result ) && empty( $section ) ? $fields : $result;

        return apply_filters( 'es_fbuilder_get_entity_section_fields', $result, $entity );
    }


    /**
     * @param $entity
     * @return array|null|object
     */
    public static function get_fields( $entity ) {
        global $wpdb, $es_settings;

        $fields = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "fbuilder_fields WHERE entity='$entity'" );
        $result = array();

        if ( $fields ) {
            foreach ( $fields as $key => $field ) {
                $field = (array) $field;
                $field['fbuilder'] = true;
                $field['options'] = ! empty( $field['options'] ) ? unserialize( $field['options'] ) : array();
                $field['values'] = ! empty( $field['values'] ) ? unserialize( $field['values'] ) : array();

                if ( $field['formatter'] == 'area' ) {
                    $field['units'] = $field['machine_name'] .'_unit';
                    $result[ $field['machine_name'] .'_unit' ] = array(
                        'type' => 'list',
                        'values' => $es_settings::get_setting_values( 'unit' ),
                        'template' => true,
                        'label' => false,
                    );
                }

                $result[ $field['machine_name'] ] = $field;
            }
        }

        return apply_filters( 'es_fbuilder_get_entity_fields', $result, $entity );
    }

    /**
     * @param $type
     *    Field type string.
     * @return string
     *    Return template name for input type.
     */
    public static function get_field_options_template( $type )
    {
        $templates = apply_filters( 'es_fbuilder_field_types_templates', array(
            'text' => 'default',
            'number' => 'number',
            'price' => 'number',
            'area' => null,
            'select' => 'multiple',
            'list' => 'multiple',
            'textarea' => null,
            'date' => null,
            'datetime' => null,
            'email' => 'default',
            'tel' => 'default',
            'url' => 'default',
        ) );

        return ! empty( $templates[ $type ] ) ? $templates[ $type ] : null;
    }

    /**
     * Return settings field value.
     *
     * @param $instance
     * @param $key
     * @param null $default
     * @return null
     */
    public static function get_settings_value( $instance, $key, $default = null )
    {
        return apply_filters( 'es_fbuilder_get_field_value', ! empty( $instance[ $key ] ) ? $instance[ $key ] : $default, $key, $instance );
    }

    /**
     * @param $instance
     * @param $key
     * @param null $default
     * @return mixed
     */
    public static function get_options_value( $instance, $key, $default = null )
    {
        return apply_filters( 'es_fbuilder_get_field_option', ! empty( $instance['options'][ $key ] ) ? $instance['options'][ $key ] : $default, $key, $instance );
    }

    /**
     * Return sections by entity param.
     *
     * @param $entity
     * @return array
     */
    public static function get_sections( $entity )
    {
        return apply_filters( 'es_fbuilder_entity_sections', array(
            'es-info' => array(
                'machine_name' => 'es-info',
                'label' => __( 'Basic facts', 'es-plugin' ),
            ),
        ), $entity );
    }

    /**
     * Return sections for select box field.
     *
     * @param $entity
     * @return array
     */
    public static function get_sections_options( $entity )
    {
        $result = array();

        if ( $data = self::get_sections( $entity ) ) {
            foreach ( $data as $item ) {
                $result[ $item['machine_name'] ] = $item['label'];
            }
        }

        return $result;
    }

    /**
     * Insert or update new field.
     *
     * @param $data
     * @return false|int
     */
    public static function save_field( $data ) {
        global $wpdb;

        $entity = self::get_settings_value( $data, 'entity', 'property' );

        $values = ! empty( $data['values'] ) ? array_filter ( $data['values'] ) : null;

        $type = self::get_settings_value( $data, 'type' );
        $formatter = $type == 'price' ? 'price' : null;
        $formatter = $type == 'area' ? 'area' : $formatter;
        $formatter = $type == 'url' ? 'url' : $formatter;

        $instance = apply_filters( 'es_fbuilder_field_presave_instance', array(
            'label' => self::get_settings_value( $data, 'label' ),
            'type' => $type == 'price' || $type == 'area' ? 'number' : $type,
            'formatter' => $formatter,
            'tab' => self::get_settings_value( $data, 'tab' ),
            'section' => self::get_settings_value( $data, 'section' ),
            'options' => ! empty( $data['options'] ) ? serialize( $data['options'] ) : null,
            'entity' => $entity,
            'values' => $values ? serialize( array_combine( $values, $values  ) ) : null,
            'rets_support' => self::get_settings_value( $data, 'rets_support' ),
            'search_support' => self::get_settings_value( $data, 'search_support' ),
        ) );

        if ( ! empty( $data['id'] ) ) {
            return $wpdb->update( $wpdb->prefix . 'fbuilder_fields', $instance, array( 'id' => $data['id'] ) );
        } else {
            $machine_name = sanitize_title( self::get_settings_value( $data, 'label' ) . time() . uniqid( 'f' ) );

            return $wpdb->insert( $wpdb->prefix . 'fbuilder_fields', array_merge( array(
                'machine_name' => $machine_name ), $instance )
            );
        }
    }

    /**
     * @param $id
     * @return array|null|object
     */
    public static function get_field( $id ) {
        global $wpdb;
        $instance = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "fbuilder_fields WHERE id = '{$id}'", ARRAY_A );

        if ( $instance ) {
            $instance['options'] = ! empty( $instance['options'] ) ? unserialize( $instance['options'] ) : array();
            $instance['values'] = ! empty( $instance['values'] ) ? unserialize( $instance['values'] ) : array();
        }

        return $instance;
    }

    /**
     * Remove field by ID.
     *
     * @param $id
     * @return false|int
     */
    public static function remove_field( $id )
    {
        global $wpdb;

        return $wpdb->delete( $wpdb->prefix . 'fbuilder_fields', array( 'id' => $id ) );
    }
}
