 <?php if (have_posts()): ?>
    
    <?php while (have_posts()) : the_post(); ?>

    <!-- article -->
    <article>
        
        <p class="date mb-0"><span class="badge badge-light"><?php the_time('F j, Y'); ?></span></p>
        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        <p><?php uwsmediawp_excerpt( 'uwsmediawp_index' ); ?></p>
        
    </article>
	<!-- /article -->

    <?php endwhile; ?>
    
    </div>
        
<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'uwsmedia' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
        
<?php get_template_part('pagination'); ?>

