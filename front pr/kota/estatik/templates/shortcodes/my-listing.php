<?php if ( $properties->have_posts() ) : ?>

    <?php do_action( "es_shortcode_before_" . $this->get_shortcode_name() . "_loop" ); ?>

    <div class="es-wrap <?php echo get_option( 'template' ); ?>">
        <?php if ( ! empty( $atts['show_filter'] ) ) : ?>
            <?php do_action( 'es_archive_sorting_dropdown' ); ?>
        <?php endif; ?>
        <ul class="es-listing es-layout-<?php echo $atts['layout']; ?>">
            <?php while ( $properties->have_posts() ) : $properties->the_post(); ?>
                <?php load_template( ES_TEMPLATES . 'content-archive.php', false ); ?>
            <?php endwhile; ?>
        </ul>

        <?php the_posts_pagination( array(
            'prev_next' => false,
            'show_all'     => false,
            'end_size'     => 1,
            'mid_size'     => 1,
            'screen_reader_text' => ' ',
        ) ); ?>
    </div>
    <?php do_action( 'es_shortcode_list_after' ); ?>
    <?php do_action( "es_shortcode_after_" . $this->get_shortcode_name() . "_loop" ); ?>
    <?php wp_reset_postdata(); ?>
<?php else: ?>
    <?php _e( 'Nothing to display', 'es-plugin' ); ?>
<?php endif;
