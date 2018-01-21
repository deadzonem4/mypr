<?php

// Field rets support input.
echo Es_Html_Helper::render_settings_field(__( 'Min', 'es-plugin' ), 'fbuilder[options][min]', 'number', array(
    'value' => Es_FBuilder_Helper::get_options_value( $instance, 'min' ),
) );

// Field rets support input.
echo Es_Html_Helper::render_settings_field(__( 'Max', 'es-plugin' ), 'fbuilder[options][max]', 'number', array(
    'value' => Es_FBuilder_Helper::get_options_value( $instance, 'max' ),
) );

// Field rets support input.
echo Es_Html_Helper::render_settings_field(__( 'Step', 'es-plugin' ), 'fbuilder[options][step]', 'number', array(
    'value' => Es_FBuilder_Helper::get_options_value( $instance, 'step' ),
) );
