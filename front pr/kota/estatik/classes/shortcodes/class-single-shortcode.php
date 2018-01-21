<?php

/**
 * Class Es_Single_Shortcode
 */
class Es_Single_Shortcode extends Es_Shortcode
{
    /**
     * Return proeprty single template name.
     *
     * @return mixed
     */
    public function get_template_path()
    {
        return apply_filters( 'es_single_template_path', ES_TEMPLATES . 'content-single.php' );
    }

    /**
     * @inheritdoc
     */
    public function build( $atts = array() )
    {
        $template = $this->get_template_path();
        if ( file_exists( $template ) ) {
            ob_start();
            include $template;
            return ob_get_clean();
        }
    }

    /**
     * @inheritdoc
     */
    public function get_shortcode_name()
    {
        return 'es_single';
    }
}
