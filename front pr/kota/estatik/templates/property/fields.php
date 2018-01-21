<div class="es-property-fields col-sm-5">
    <div class="es-info clearfix" id="es-info">
                     <h2>
                        <div class="es-cat-price">
                            <?php es_the_categories( '<span class="es-category-items">', '', '</span>' ) ?>
                            <?php es_the_formatted_price( '<span class="es-price">', '</span>' ); ?>
                        </div>
                    </h2> 
                   
    </div>

    <ul>
        <?php if ( $fields = Es_Property_Single_Page::get_single_fields_data() ) : ?>
            <?php foreach ( $fields as $field ) : ?>
                <?php if ( ! empty( $field[ key( $field ) ] ) ) : ?>
                    <li><strong><?php echo key( $field ); ?>: </strong><?php echo $field[ key( $field ) ]; ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <?php do_action( 'es_single_share' ); ?>

<div class="property-id"><p><?php _e('Offer number: ', 'your-textdomain'); ?><strong><?php the_ID(); ?></strong></p></div>
</div>
