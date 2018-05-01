<?php if (have_posts()): while (have_posts()) : the_post(); ?>
    
	<!-- article -->
	 <div class="col-3 project">
        <a href="<?php the_permalink(); ?>">
            
            <div class="project-bg">
            <?php the_post_thumbnail(); ?>
            </div>
            
            <div class="project-info">
            <p class="categories"><?php 

            $media_type_terms = get_the_terms( $post->ID, 'media_types' );

            if ( !is_array( $media_type_terms ) || count( $media_type_terms ) <= 0 ) {
                echo '<span aria-hidden="true">&mdash;</span>';
            } else {
                echo $media_type_terms[0]->name;
            }
            
        ?></p>
            <h2 class="d-flex align-items-center justify-content-center"><?php the_title(); ?></h2>
            <p class="date"><?php the_time('F j, Y'); ?></p>
            </div>
            
        </a>
    </div>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'uwsmedia' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
