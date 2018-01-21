<?php

/**
 * Class Es_Html_Helper
 */
class Es_Html_Helper
{
    /**
     * @param $id
     * @param $field
     * @return null|string
     * @throws Exception
     */
    public static function render_field( $id, $field )
    {
        $content = null;
        global $post_ID;
        $options = ' ';

        // Check for field type.
        if ( empty( $field['type'] ) ) {
            throw new Exception( __( "Field type parameter can't be empty", 'es-plugin' ) );
        }

        // Generate label if empty.
        if ( empty( $field['label'] ) || ( isset( $field['label'] ) && $field['label']  == false ) ) {
            $field['label'] = static::generate_label( $id );
        } else {
            $field['label'] = ! empty( $field['label'] ) ? $field['label'] : '';
        }

        if ( empty( $field['template'] ) ) {
            $field['label'] = ! empty( $field['label'] ) ? __( $field['label'], 'es-plugin' ) : '';
            $units_class = ! empty( $field['units'] ) ? 'es-field-area-unit' : null;
            $content = "<div class='es-field es-field-" . $field['type'] . " es-field-" . $id . " " . $units_class . "'><div class='es-field__label'>" . $field['label'] . "</div><div class='es-field__content'>";
//            $content = '<p class="property-data-field es-field-type-' . $field['type'] . '"><label><span class="es-settings-label">' . $field['label'] . '</span>';
        }

        $property = es_get_property( $post_ID );

        $value = $property->$id;

        $field['options']['value'] = ! empty( $field['options']['value'] ) ? $field['options']['value'] : $value;

        if ( empty( $field['options']['id'] ) ) {
            $field['options']['id'] = 'es-' . $id . '-input';
        }

        if ( isset( $field['options']['required'] ) && empty( $field['options']['required'] ) ) {
            unset( $field['options']['required'] );
        }

        if ( isset( $field['type'] ) && ( 'date' == $field['type'] || 'datetime-local' == $field['type'] ) ) {
            $field['type'] = 'text';
        }

        if ( ! empty( $field['options'] ) ) {
            foreach ( $field['options'] as $key => $option ) {
                if ( $key == 'value' && is_array( $option ) ) continue;
                $options .= $key . '="' . $option . '" ';
            }
        }

        switch ( $field['type'] ) {
            case 'list':
                if ( ! empty( $field['values'] ) ) {
                    $content .= '<select name="property[' . $id . ']" ' . $options .'>';

                    if ( ! empty( $field['prompt'] ) ) {
                        $content .= '<option value="">' . $field['prompt'] . '</option>';
                    } else if ( ! empty( $field['fbuilder'] ) ) {
                        $content .= '<option value="">' . __( 'Choose value', 'es-plugin' ) . '</option>';
                    }

                    foreach ( $field['values'] as $value => $label ) {
                        $content .= '<option value="' . $value . '" ' . selected( $value, $field['options']['value'], false ) . '>' . $label . '</option>';
                    }
                    $content .= '</select>';
                } else {
                    return;
                }

                break;

            case 'custom':
                include( $field['template'] );

                break;

            case 'radio':
            case 'checkbox':
                $content .= '<input type="' . $field['type'] . '" name="property[' . $id . ']" id="es-' . $id .'-input"' . $options . ' ' . checked( $value, $field['options']['value'], false ) . '/>';

                break;

            case 'textarea':
                $content .= '<textarea name="property[' . $id . ']" id="es-' . $id .'-input"' . $options . '>' . ( ! empty( $field['options']['value'] ) ? $field['options']['value'] : null ) . '</textarea>';
                break;

            default:
                $content .= '<input type="' . $field['type'] . '" name="property[' . $id . ']" id="es-' . $id .'-input"' . $options .'/>';
        }

        if ( ! empty( $field['units'] ) ) {
            if ( ! empty( $property  ) ) {
                $fields = $property::get_fields();
                $content .= self::render_field( $field['units'], $fields[ $field['units'] ] );
            }
        }

        if ( empty( $field['template'] ) ) {
            $content .= '</div></div>';
        }

        return apply_filters( 'es_render_field', $content, $id, $field );
    }

    /**
     * Generate label for field using field id.
     *
     * @param $name
     * @return mixed
     */
    public static function generate_label( $name )
    {
        return str_replace( '_', ' ', ucfirst( $name ) );
    }

    /**
     * Generate settings input markup.
     *
     * @param $label
     *    Input label text.
     * @param $field_name
     * @param $type
     * @param array $options
     * @return string
     */
    public static function render_settings_field( $label, $field_name, $type, $options = array() )
    {
        $template = '<div class="es-field">
                        <div class="es-field__label">%s</div>
                        <div class="es-field__content">%s</div>
                    </div>';

        $template = apply_filters( 'es_html_helper_settings_fields_template', $template, $label, $options );

        $options_string = null;
        $options['name'] = $field_name;
        $options['value'] = ! empty( $options['value'] ) ? $options['value'] : false;

        foreach ( $options as $key => $value ) {
            if ( is_array( $value ) || ! $value ) continue;
            $options_string .= $key . '="' . $value . '" ';
        }

//es-switch-input
        switch ( $type ) {
            case 'checkbox':
                $field = "<input type='hidden' name='{$field_name}' value='0'/>
                          <input type='checkbox' {$options_string}>";
                break;

            case 'list':
            case 'select':
            case 'selectbox':
                $field = "<select {$options_string}>";

                if ( ! empty( $options['placeholder'] ) ) {
                    $field .= '<option value="">' . $options['placeholder'] . '</option>';
                }

                if ( ! empty( $options['values'] ) ) {
                    foreach ( $options['values'] as $pvalue => $plabel ) {
                        $field .= '<option value="' . $pvalue . '" '. selected( $pvalue, $options['value'], false ) .'>' .
                            ( is_string( $plabel ) ? $plabel : $plabel['label'] )
                            . '</option>';
                    }
                }

                $field .= '</select>';

                break;

            default:
                $field = "<input type='text' {$options_string}>";
        }

        $template = sprintf( $template, $label, $field );

        return $template;
    }
}
