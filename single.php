<?php get_header(); ?>
    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <!-- post thumbnail -->
	<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
	<div class="post-featured-image">
		<?php the_post_thumbnail(); ?>
    </div>
	<?php endif; ?>
	<!-- /post thumbnail -->
    <div class="container">
        <div class="row">
            <main class="col-10 offset-1" role="main">
                
                <!-- section -->
                <section>

                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <!-- post title -->
                        <h1><?php the_title(); ?></h1>
                        <!-- /post title -->
        
                        <p class="date text-muted mb-0"><small>
                        <?php
                            
                            the_time('F j, Y');

                            if ( strcmp( get_the_time( 'F j, Y' ), get_the_modified_date( 'F j, Y' ) ) !== 0 ) {
                                
                                echo ' | Updated on ' . get_the_modified_date( 'F j, Y' );
                                
                            }
                            
                        ?></small></p>
                        <p class="authors"><?php _e( 'By', 'uwsmedia' ); ?> <strong><?php echo get_the_author(); ?></strong></p>
                        
                        <?php the_content(); // Dynamic Content ?>
                        
                        <?php edit_post_link( __( 'Edit', 'uwsmedia' ), '<p>', '</p>', null ); ?>
                    
                    </article>
                    <!-- /article -->
                    
                    <?php endwhile; ?>
                    
                    <?php else: ?>
                    
                    <!-- article -->
                    <article>
                    
                    <h1><?php _e( 'Sorry, nothing to display.', 'uwsmedia' ); ?></h1>
                    
                    </article>
                    <!-- /article -->
                    
                    <?php endif; ?>
                
                </section>
                <!-- /section -->
            </main>
			    
        </div>
	</div>
	<!-- /body content container -->


<?php get_footer(); ?>
