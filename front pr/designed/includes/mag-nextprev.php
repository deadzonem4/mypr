<div id="post-nav" class="imgsmall">
    <?php $prevPost = get_previous_post(true);// false = all categories
        if($prevPost) {
            $args = array(
                'posts_per_page' => 1,
                'include' => $prevPost->ID
            );
            $prevPost = get_posts($args);
            foreach ($prevPost as $post) {
                setup_postdata($post);
    ?>
        <div class="post-previous tranz p-border">
            <h4 class="uppercase"><i class="fa fa-angle-left" aria-hidden="true"></i> <?php esc_html_e('Previous Story','designed');?></h4>
            <?php include( get_template_directory() . '/post-types/home-classic-small.php'); ?>
        </div>
    <?php
                wp_reset_postdata();
            } //end foreach
        } // end if
         
        $nextPost = get_next_post(true);// false = all categories
        if($nextPost) {
            $args = array(
                'posts_per_page' => 1,
                'include' => $nextPost->ID
            );
            $nextPost = get_posts($args);
            foreach ($nextPost as $post) {
                setup_postdata($post);
    ?>
        <div class="post-next tranz p-border">
            <h4 class="uppercase"><?php esc_html_e('Next Story','designed');?> <i class="fa fa-angle-right" aria-hidden="true"></i></h4>
            <?php include( get_template_directory() . '/post-types/home-classic-small.php'); ?>
        </div>
    <?php
                wp_reset_postdata();
            } //end foreach
        } // end if
    ?>
</div>