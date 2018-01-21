<?php
/**
 * Blog Template
 */
?>
<?php get_header('new'); ?>
<main id="content" role="main">
	<section class="blog-wrapper">
                <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 blog-content">
                        <h2>Blog posts</h2>
                        <?php query_posts('post_type=post&post_status=publish&paged='. get_query_var('paged')); ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						   	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
								<div class="post-image">
					       			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
					       		</div>
								<section class="post-summary">
									<?php the_category(); ?> 
					               	<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									<div class="post-excerpt"><?php the_excerpt(__('Continue reading »','example')); ?></div>
									<div class="after-content">
									<p class="single-post-author ">by<span itemprop="author" itemscope itemtype="http://schema.org/Person"> <span itemprop="name"><?php the_author(); ?></span></span></p>
									<div class="read-more"><a class="moretag" href="<?php the_permalink(); ?>"> READ MORE <span class="glyphicon glyphicon-menu-right"></span></a></div>
									</div>
								</section>
					           </article>
					    <?php endwhile; ?>

						<?php if (function_exists("pagination")) {
						    pagination($additional_loop->max_num_pages);
						} ?>

						<?php else: ?>
							<div id="post-404" class="noposts">
							    <p><?php _e('None found.','example'); ?></p>
						    </div><!-- /#post-404 -->
						<?php endif; wp_reset_query(); ?>
                    </div>
                </div>
                </div>
            </section>
         </main>   
         <?php get_footer(); ?>