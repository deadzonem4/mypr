<?php

/**
 * @var array $field
 */

?>

<li>
    <a href="#" class="js-es__available-tooltipster--drag"><i class="fa fa-arrows" aria-hidden="true"></i></a>
    <?php echo $field['label']; ?>
    <?php if ( ! empty( $field['fbuilder'] ) ) : ?>
        <a href="<?php echo Es_FBuilder_Helper::get_field_delete_link( $field['id'] ); ?>" class="es-manage-field__link"
           title="<?php _e( 'Remove field', 'es-plugin' ); ?>"><i class="fa fa-times-circle" aria-hidden="true"></i></i></a>

        <a href="<?php echo Es_FBuilder_Helper::get_field_edit_link( $field['id'] ); ?>" class="es-manage-field__link"
           title="<?php _e( 'Edit field', 'es-plugin' ); ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    <?php endif; ?>
</li>
