<?php if (have_posts()): while (have_posts()) : the_post(); ?>
    
	<!-- article -->
	 <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 project">
        <a href="<?php the_permalink(); ?>">
            
            <div class="project-bg">
            <?php the_post_thumbnail(); ?>
            </div>
            
            <div class="project-info">
            <p class="categories"><?php 

                                $classification_terms = get_the_terms( $post->ID, 'classifications' );
            
                                if ( !is_array( $classification_terms ) || count( $classification_terms ) <= 0 ) {
                                    echo '<span aria-hidden="true">&nbsp;</span>';
                                } else {
                                    echo $classification_terms[0]->name;
                                }
                                
                            ?></p>
            <h2 class="d-flex align-items-center justify-content-center"><?php the_title(); ?></h2>
            <p class="categories"><?php 

                $media_type_terms = get_the_terms( $post->ID, 'media_types' );

                if ( !is_array( $media_type_terms ) || count( $media_type_terms ) <= 0 ) {
                    echo '<span aria-hidden="true">&mdash;</span>';
                } else {
                    echo strip_tags( get_the_term_list( $post->ID, 'media_types', '', ', ', '' ) );
                }
                
            ?></p>
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
