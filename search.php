<?php get_header(); ?>
    
<div class="container">
    
        <div class="row">    
    
	<main class="col-12" role="main">
		<!-- section -->
		<section id="projects-archive">

			<h1><?php echo sprintf( __( '%s Search Results ', 'uwsmedia' ), $wp_query->found_posts ); ?></h1>
			
			<?php if ( $post->post_type == 'uws-projects' ) : ?>
            
            <div class="searchQueries">
                <p>
                <?php
                    
                    if ( isset( $_GET['s'] ) && !empty( $_GET['s'] ) ) {
                        
                        echo 'Keyword: <strong>' . $_GET['s'] . '</strong><br>';
                        
                    }
    
                    $filters = null;
                    
                    if ( isset( $_GET['programs'] ) && !empty( $_GET['programs'] ) ) {
                        
                        $filters = is_array( $filters ) ? array_merge( $filters, explode( ',', $_GET['programs'] ) ) : explode( ',', $_GET['programs'] );
                        
                    }
                    
                    if ( isset( $_GET['classifications'] ) && !empty( $_GET['classifications'] ) ) {
            
                        $filters = is_array( $filters ) ? array_merge( $filters, explode( ',', $_GET['classifications'] ) ) : explode( ',', $_GET['classifications'] );
                        
                    }
                    
                    if ( isset( $_GET['media_types'] ) && !empty( $_GET['media_types'] ) ) {
            
                        $filters = is_array( $filters ) ? array_merge( $filters, explode( ',', $_GET['media_types'] ) ) : explode( ',', $_GET['media_types'] );
                        
                    }
                    
                    if ( is_array( $filters ) && count( $filters ) >= 1 ) {
                        
                        echo 'Filters: ';
                        
                        foreach ( $filters as $filter ) {
                            
                            $term = get_term_by( 'name', $filter, 'classifications' );
                            
                            echo '<span class="badge badge-light">' . $term->name . '</span> ';
                            
                        }
                        
                    }
                    
                    unset( $filters );
                    
                ?>
                </p>
            </div>
                
            <?php endif; ?>
            
            <div class="row d-flex flex-row">
			<?php get_template_part('loop'); ?>
            </div> <!-- end grids -->
            
			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

    </div>
    
</div>

<?php get_footer(); ?>
