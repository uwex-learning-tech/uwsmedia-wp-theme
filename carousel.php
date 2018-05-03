<?php if ( is_front_page() ) : ?>
                    
    <!-- section -->
	<section class="project-carousel-wrapper">
    	
    	<div id="project-carousel" class="carousel slide carousel-fade" data-ride="carousel">
    	<?php
        	
        	$query_args = array(
                'post_type' => 'uws-projects',
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
                
                $count = 0;
        ?>
            
                <ol class="carousel-indicators">
                    
                    <?php
                        
                    for( $idx = 0; $idx < (Int) $carousel->found_posts; $idx++ ) {
                        
                        $active = '';
                        
                        if ( $idx == 0 ) {
                            $active = ' class="active"';
                        }
                        
                        echo '<li data-target="#project-carousel" data-slide-to="' . $idx . '"' . $active . '></li>';
                        
                    }    
                    ?>
                
                </ol>
            
                <div class="carousel-inner h-100">
                
                <?php
                    while( $carousel->have_posts() ) {
                        
                        $carousel->the_post();
                    
                ?>
                    <div class="carousel-item<?php  echo $count == 0 ? ' active' : ''; ?>">
                        <img class="d-block w-100" src="<?php the_post_thumbnail_url( 'full' ); ?>" alt="<?php the_title(); ?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php the_title(); ?></h5>
                            <p><?php the_excerpt(); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn">VIEW</a>
                        </div>
                    </div>
                    
                <?php        
                        
                        $count++;
                        
                    } // end while
                    wp_reset_postdata();
                ?>
                    
                </div>
                
                <a class="carousel-control-prev" href="#project-carousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span></a>
                
                <a class="carousel-control-next" href="#project-carousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span></a>
                
                <?php } // end if  ?>
    	</div>
        
    </section>
	<!-- /section -->

    <?php endif; ?> <!-- /end is front page -->