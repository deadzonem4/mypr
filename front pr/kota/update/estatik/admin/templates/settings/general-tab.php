<?php

/**
 * @var Es_Settings_Container $es_settings
 */

echo Es_Html_Helper::render_settings_field( __( 'Powered by link', 'es-plugin' ), 'es_settings[powered_by_link]', 'checkbox', array(
    'checked' => (bool) $es_settings->powered_by_link ? 'checked' : false,
    'value' => 1,
    'class' => 'es-switch-input',
) );

echo Es_Html_Helper::render_settings_field( __( 'Number of listings per page', 'es-plugin' ), 'es_settings[properties_per_page]', 'number', array(
    'checked' => (bool) $es_settings->properties_per_page ? 'checked' : false,
    'value' => $es_settings->properties_per_page,
    'min' => '1',
) );

echo Es_Html_Helper::render_settings_field( __( 'Show price', 'es-plugin' ), 'es_settings[show_price]', 'checkbox', array(
    'checked' => (bool) $es_settings->show_price ? 'checked' : false,
    'value' => 1,
    'class' => 'es-switch-input',
) ); ?>

<?php if ( $data = $es_settings::get_setting_values( 'title_address' ) ) : $name = 'title_address'; $label = __( 'Title / Address', 'es-plugin' ) ?>
    <?php include( 'fields/radio-list.php' ); ?>
<?php endif; ?>

<?php echo Es_Html_Helper::render_settings_field( __( 'Show Address', 'es-plugin' ), 'es_settings[show_address]', 'checkbox', array(
    'checked' => (bool) $es_settings->show_address ? 'checked' : false,
    'value' => 1,
    'class' => 'es-switch-input',
) );

echo Es_Html_Helper::render_settings_field( __( 'Labels', 'es-plugin' ), 'es_settings[show_labels]', 'checkbox', array(
    'checked' => (bool) $es_settings->show_labels ? 'checked' : false,
    'value' => 1,
    'class' => 'es-switch-input',
) );

echo Es_Html_Helper::render_settings_field( __( 'Date added', 'es-plugin' ), 'es_settings[date_added]', 'checkbox', array(
    'checked' => (bool) $es_settings->date_added ? 'checked' : false,
    'value' => 1,
    'class' => 'es-switch-input',
) );

echo Es_Html_Helper::render_settings_field( __( 'Date format', 'es-plugin' ), 'es_settings[date_format]', 'list', array(
    'value' => $es_settings->date_format,
    'values' => $es_settings::get_setting_values( 'date_format' ),
) );

echo Es_Html_Helper::render_settings_field( __( 'Theme style', 'es-plugin' ), 'es_settings[theme_style]', 'list', array(
    'value' => $es_settings->theme_style,
    'values' => $es_settings::get_setting_values( 'theme_style' ),
) );

echo Es_Html_Helper::render_settings_field( __( 'Google map API key', 'es-plugin' ), 'es_settings[google_api_key]', 'text', array(
    'value' => $es_settings->google_api_key,
) );
