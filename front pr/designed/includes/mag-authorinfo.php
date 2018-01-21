        <?php 
		$user_description = get_the_author_meta( 'user_description', $post->post_author );
		if ( ! empty( $user_description ) ) { ?>
        <div class="postauthor vcard author rad p-border"  itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
        	<h3 class="additional"><?php esc_html_e('About the Author','designed');?> / <span class="fn" itemprop="name"><?php the_author_posts_link(); ?></span></h3>
            <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
				<?php  echo get_avatar( get_the_author_meta('ID'), '120' );   ?>
            </div>
            
 			<div class="authordesc"><?php the_author_meta('description'); ?></div>
            
            <div class="authoricons">
                <p>
                    <a href="<?php esc_url(the_author_meta('facebook')); ?>" class="<?php if(the_author_meta('facebook') == '') echo 'hidd'; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                    <a href="<?php esc_url(the_author_meta('twitter')); ?>" class="<?php if(the_author_meta('twitter') == '') echo 'hidd'; ?>" target="_blank" ><i class="fa fa-twitter"></i></a>
                    <a href="<?php esc_url(the_author_meta('google')); ?>?rel=author" class="<?php if(the_author_meta('google') == '') echo 'hidd'; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                    <a href="<?php esc_url(the_author_meta('pinterest')); ?>" class="<?php if(the_author_meta('pinterest') == '') echo 'hidd'; ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
                    <a href="<?php esc_url(the_author_meta('instagram')); ?>" class="<?php if(the_author_meta('instagram') == '') echo 'hidd'; ?>" target="_blank"><i class="fa fa-instagram"></i></a>
                    <a href="<?php esc_url(the_author_meta('linkedin')); ?>" class="<?php if(the_author_meta('linkedin') == '') echo 'hidd'; ?>" target="_blank" ><i class="fa fa-linkedin"></i></a>
                    <a href="<?php esc_url(the_author_meta('link')); ?>" itemprop="url" class="<?php if(the_author_meta('link') == '') echo 'hidd'; ?>" target="_blank"><i class="fa fa-link"></i></a>
                </p>
            </div>
            
		</div>
		<div class="clearfix"></div>
        <?php }  ?>