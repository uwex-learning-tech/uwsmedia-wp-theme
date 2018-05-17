<!-- section -->
<section id="projects-archive">

    <h1><?php echo sprintf( __( '%s Search Results ', 'uwsmedia' ), $wp_query->found_posts ); ?></h1>
		
     <div class="searchQueries">
        <p><?php
            
            if ( isset( $_GET['s'] ) && !empty( $_GET['s'] ) ) {
                
                echo 'Keyword: <strong>' . $_GET['s'] . '</strong><br>';
                
            }

            $terms = [];
            
            if ( isset( $_GET['programs'] ) && !empty( $_GET['programs'] ) ) {
                
                $filters = explode( ',', $_GET['programs'] );
                
                foreach ( $filters as $filter ) {
                    
                    $term = get_term_by( 'slug', $filter, 'programs' )->name;
                    
                    array_push( $terms, $term );
                    
                }
                
            }
            
            if ( isset( $_GET['classifications'] ) && !empty( $_GET['classifications'] ) ) {
    
                $filters = explode( ',', $_GET['classifications'] );
                
                foreach ( $filters as $filter ) {
                    
                    $term = get_term_by( 'slug', $filter, 'classifications' )->name;
                    
                    array_push( $terms, $term );
                    
                }
                
            }
            
            if ( isset( $_GET['media_types'] ) && !empty( $_GET['media_types'] ) ) {
                
                $filters = explode( ',', $_GET['media_types'] );
                
                foreach ( $filters as $filter ) {
                    
                    $term = get_term_by( 'slug', $filter, 'media_types' )->name;
                    
                    array_push( $terms, $term );
                    
                }
                
            }
            
            if ( is_array( $terms ) && count( $terms ) >= 1 ) {
                
                echo 'Filters: ';
                
                foreach ( $terms as $term ) {
                    
                    echo '<span class="badge badge-light">' . $term . '</span> ';
                    
                }
                
            }
            
            unset( $filters );
            
        ?></p>
    </div>
        
    <div class="row d-flex flex-row">
        
    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
    
	    <!-- article -->
        <article class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 project">
            
            <a href="<?php the_permalink(); ?>">
            
                <div class="project-bg">
                    <?php the_post_thumbnail(); ?>
                </div>
            
                <div class="project-info">
                    
                    <p class="categories"><?php 

                    $class_terms = get_the_terms( $post->ID, 'classifications' );

                    if ( !is_array( $class_terms ) || count( $class_terms ) <= 0 ) {
                        echo '<span aria-hidden="true">&nbsp;</span>';
                    } else {
                        echo $class_terms[0]->name;
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
        </article>
    	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

    	<!-- article -->
    	<article>
    		<h2><?php _e( 'Sorry, nothing to display.', 'uwsmedia' ); ?></h2>
    	</article>
    	<!-- /article -->

<?php endif; ?>
    </div> <!-- end grids -->
        
    <?php get_template_part('pagination'); ?>

</section>
<!-- /section -->
