<?php

if ( ! defined( 'WPINC' ) ) die;


/**
 * Class Es_Fields_Builder_Page
 */
class Es_Fields_Builder_Page extends Es_Object
{
    /**
     * Add actions for dashboard page.
     */
    public function actions()
    {
        add_action( 'admin_enqueue_scripts', array( $this , 'enqueue_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this , 'enqueue_scripts' ) );
        add_action( 'init', array( $this , 'action_save_field' ) );
        add_action( 'es_before_property_metabox_tab_content', array( $this , 'add_property_tab_info' ), 10, 1 );
        add_action( 'init', array( $this , 'action_remove_field' ) );
        add_action( 'wp_ajax_es_fbuilder_load_field_options', array( $this , 'action_load_field_options' ) );
    }

    /**
     * Add info text for basic facts property tab.
     *
     * @param $id
     */
    public function add_property_tab_info( $id ) {
        if ( 'es-basic-info' == $id ) {
            echo '<div class="es-fb-info">' . sprintf( wp_kses( __( 'If you lack some fields, please go to <a href="%s">Fields Builder</a> and add your own custom fields.', 'es-plugin' ),
                array(  'a' => array( 'href' => array() ) ) ), esc_url( es_admin_fields_builder_uri() ) ) . '</div>';
        }
    }

    /**
     * Enqueue styles for dashboard page.
     *
     * @return void
     */
    public function enqueue_styles()
    {
        $custom = 'admin/assets/css/custom/';

        wp_register_style( 'es-fields-builder-style', ES_PLUGIN_URL . $custom . 'fbuilder.css' );
        wp_enqueue_style( 'es-fields-builder-style' );
    }

    /**
     * Enqueue scripts for the page.
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        $custom = 'admin/assets/js/custom/';

        wp_register_script( 'es-fields-builder-script', ES_PLUGIN_URL . $custom . 'fbuilder.js', array(
            'jquery', 'es-cloneya-script',
        ) );
        wp_enqueue_script( 'es-fields-builder-script' );
    }

    /**
     * @inheritdoc
     */
    public static function render()
    {
        $path = self::get_template_path( 'main' );

        if ( file_exists( $path ) ) {
            load_template( $path );
        }
    }

    /**
     * @return mixed
     */
    public static function get_tabs()
    {
        return apply_filters( 'es_fbuilder_get_tabs', array(
            'es-property' => array(
                'label' => __( 'Listing fields' ),
                'template' => self::get_template_path( 'tabs/entity-fields-tab' ),
                'entity' => 'property',
            ),
        ) );
    }

    /**
     * Return template path by template name.
     *
     * @param $template
     * @return string
     */
    public static function get_template_path( $template ) {
        $path = ES_ADMIN_TEMPLATES . 'fields-builder' . ES_DS . $template . '.php';

        return apply_filters( 'es_fields_buider_get_template_path', $path, $template );
    }

    /**
     * Save fbuilder field.
     *
     * @return void
     */
    public function action_save_field() {
        $nonce = 'es_fbuilder_save_field';

        if ( ! empty( $_REQUEST[ $nonce ] ) && wp_verify_nonce( $_REQUEST[ $nonce ], $nonce ) ) {
            $messenger = new Es_Messenger( 'fbuilder' );

            $label = $_POST['fbuilder']['label'];

            if ( Es_FBuilder_Helper::save_field( $_POST['fbuilder'] ) ) {
                $messenger->set_message( sprintf( __( 'Field %s successfully created.', 'es-plugin' ), $label ), 'success' );
            } else {
                $messenger->set_message( sprintf( __( 'Field %s doesn\'t created.', 'es-plugin' ), $label ), 'error' );
            }
        }
    }

    /**
     * Remove field action.
     *
     * @return void
     */
    public function action_remove_field()
    {
        $nonce = 'es-fbuilder-remove-field';

        if ( ! empty( $_GET[ 'nonce' ] ) && wp_verify_nonce( $_GET[ 'nonce' ], $nonce ) && ! empty( $_GET['id'] ) ) {
            $field = Es_FBuilder_Helper::get_field( $_GET['id'] );
            $messenger = new Es_Messenger( 'fbuilder' );

            if ( $field ) {
                Es_FBuilder_Helper::remove_field( $_GET['id'] );
                $messenger->set_message( sprintf( __( 'Field %s successfully removed.', 'es-plugin' ), $field['label'] ), 'success' );
                wp_redirect( 'admin.php?page=es_fbuilder' ); die;
            } else {
                $messenger->set_message( sprintf( __( 'Field #%s isn\'t exist.', 'es-plugin' ), $_GET['id'] ), 'error' );
            }
        }
    }

    /**
     * Ajax action. Get field additional options fields.
     *
     * @return void
     */
    public function action_load_field_options()
    {
        if ( ! empty( $_POST['type'] ) ) {
            $template = Es_FBuilder_Helper::get_field_options_template( $_POST['type'] );
            $path = apply_filters( 'es_fbuilder_field_options_path', self::get_template_path( 'partials/options/' . $template ) );
            if ( $template && file_exists( $path ) ) {
                include $path;
            }
        }

        wp_die();
    }
}
