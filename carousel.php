<?php if ( is_front_page() ) : ?>

<!-- section -->
<section class="project-carousel-wrapper">
    <h2 class="text-center mb-4">Featured Projects</h2>
    <div class="container">
        <div id="project-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

            <?php
        	
        	$query_args = array(
                'post_type' => array('uws-projects','uws-flex-projects'),
                'post_status' => 'publish',
                'meta_query'  => array(
                    array(
                        'key' => 'feature_on_home',
                        'value' => 1
                    )
                )
            );
            
            $carousel = new WP_Query( $query_args );
            
            if ( $carousel->have_posts() ) {
                
                shuffle( $carousel->posts );
                
                $count = 0;

        ?>

            <div class="carousel-indicators">

                <?php
        
                    for( $idx = 0; $idx < (Int) $carousel->found_posts; $idx++ ) {
                        
                        $active = '';
                        $current = 'false';
                        
                        if ( $idx == 0 ) {
                            $active = 'active';
                            $current = 'true';
                        }
                        
                        echo '<button type="button" data-bs-target="#project-carousel" data-bs-slide-to="' . $idx . '" class="' . $active . '" aria-current="'.$current.'" aria-label="Slide '.$idx.'"></button>';
                        
                    }    
                ?>

            </div>

            <div class="carousel-inner">

                <?php
                    while( $carousel->have_posts() ) {
                        
                        $carousel->the_post();
                    
                ?>
                <div class="carousel-item<?php  echo $count == 0 ? ' active' : ''; ?>">
                    <div class="carousel-item-inner-wrapper">
                        <img class="d-block" src="<?php the_post_thumbnail_url( 'full' ); ?>"
                            alt="<?php the_title(); ?>">
                        <div class="carousel-caption">
                            <h3 class="title"><?php the_title(); ?></h3>
                            <p class="excerpt"><?php uwsmediawp_excerpt('uwsmediawp_index'); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">VIEW</a>
                        </div>
                    </div>
                </div>

                <?php        
                        
                        $count++;
                        
                    } // end while
                    wp_reset_postdata();
                ?>

            </div>

            <?php if ( $count > 1 ) :  ?>

            <button type="button" class="carousel-control-prev" data-bs-target="#project-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>

            <button type="button" class="carousel-control-next" data-bs-target="#project-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

            <?php endif;  ?>

            <?php } // end if  ?>
        </div>
    </div>

</section>
<!-- /section -->

<?php endif; ?>
<!-- /end is front page -->