<?php do_action( 'es_before_dimensions_tab' ); ?>

<?php $dmi = new Es_Data_Manager_Item(
    'es_units_list' ,
    'unit',
    array(
        'label' => __( 'Area & Lot size unit', 'es-plugin' )
    )
); $dmi ->render(); ?>

<?php do_action( 'es_after_dimensions_tab' );
