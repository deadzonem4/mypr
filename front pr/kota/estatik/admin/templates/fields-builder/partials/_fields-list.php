<?php

/**
 * @var $entity string
 */

if ( $sections = Es_FBuilder_Helper::get_sections( $entity ) ) : ?>
    <ul>
        <?php foreach ( $sections as $key => $section ) : ?>
            <li>
                <h1><?php echo $section[ 'label' ]; ?></h1>
                <?php if ( $fields = Es_FBuilder_Helper::get_entity_fields( $entity ) ) : ?>
                    <ul class="es-list__styled">
                        <?php foreach ( $fields as $field ) : ?>
                            <?php if ( empty( $field['section'] ) || $field['section'] != $key ) continue; ?>
                            <?php require ( Es_Fields_Builder_Page::get_template_path( 'partials/_field' ) ); ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif;
