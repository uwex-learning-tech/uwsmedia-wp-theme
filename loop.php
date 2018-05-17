<!-- section -->
<section>

    <h1><?php echo sprintf( __( '%s Search Results ', 'uwsmedia' ), $wp_query->found_posts ); ?></h1>
 
    <?php if (have_posts()): ?>
        
        <div class="row">
        
        <?php while (have_posts()) : the_post(); ?>
    
        <!-- article -->
        <article class="col-md-6">
            
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

</section>
<!-- /section -->
