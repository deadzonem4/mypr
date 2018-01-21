<?php

$values = ! empty( $instance['values'] ) ? $instance['values'] : array();
$iterator = new ArrayIterator( $values );

do{ ?>
    <div class="es-clone__wrap">
        <div class="es-field">
            <div class="es-field__label"></div>
            <div class="es-field__content">
                <a href="#" class="clone"><i class="fa fa-plus" aria-hidden="true"></i></a>
                <a href="#" class="drag js-es__available-tooltipster--drag"><i class="fa fa-arrows" aria-hidden="true"></i></a>
                <input placeholder="<?php _e( '-- Input value --', 'es-plugin' ); ?>"
                       type="text" name="fbuilder[values][]" value="<?php echo $values[ $iterator->key() ]; ?>"/>
                <a href="#" class="delete"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
<?php $iterator->next(); } while( $iterator->valid() );
