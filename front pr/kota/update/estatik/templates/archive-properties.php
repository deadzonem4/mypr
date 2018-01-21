<?php

/**
 * @var Es_Settings_Container $es_settings
 */

get_header(); $template = get_option( 'template' ); ?>
<main>
<?php do_action( 'es_before_content' ); ?>

    <div class="es-wrap">

        <header>
                <div class="pages-title">
                <div class="container">
                <h1><?php echo ! empty( $title ) ? $title : __( 'Search results', 'es-plugin' ); ?></h1>
                </div>
                </div>              
        </header><!-- .page-header -->
<div class="container popular-listing custom-list search-results">
        <?php do_action( 'es_before_content_list' ); ?>

        <div class="<?php es_the_list_classes(); ?>">
            <?php do_action( 'es_archive_sorting_dropdown' ); ?>

        <?php if ( have_posts() ) : ?>
                <ul class="result-lists">
                    <?php while ( have_posts() ) : the_post();
                        load_template( ES_TEMPLATES . 'content-archive.php', false );
                    endwhile; ?>
                </ul>
            <?php else: ?>
                <p style="font-size: 18px; font-weight: bold;"><?php _e( 'Nothing to display.', 'es-plugin' ); ?></p>
            <?php endif; ?>
        </div>

        <?php do_action( 'es_after_content_list' ); ?>
        <div>
    <?php the_posts_pagination( array(
        'prev_next' => false,
        'show_all'     => false,
        'end_size'     => 1,
        'mid_size'     => 1,
        'screen_reader_text' => ' ',
    ) ); ?>
</div>
</div>
</div>

<?php do_action( 'es_after_content' ); ?>
</main>
<?php get_footer();