<?php
/**
 * Template Name: Showcase
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage UWS Media
 * @since 1.0.0
 */
 
 get_header(); ?>
 
    <div class="container">
    
        <div class="row">
        
            <main class="col-12 col-sm-12 col-md-9" role="main">
                
                <section>
                
                    <h1><?php the_title(); ?></h1>
                    
                    <div id="projects-archive">
                    
                    <div class="row d-flex flex-row">
                    <?php
                        
                        $group = get_post_meta( $post->ID, 'post_group_id', true );
                        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                        
                        $query_args = array(
                            'post_type' => 'uws-projects',
                            'post_status' => 'publish',
                            'posts_per_page' => 9,
                            'paged' => $paged,
                            'meta_query'  => array(
                                    array(
                                        'key' => 'post_group_id',
                                        'value' => $group
                                    )
                                )
                        );
                        
                        $facultyProjects = new WP_Query( $query_args );
                        
                        if ( $facultyProjects->have_posts() ) {

                        while( $facultyProjects->have_posts() ) {
                            
                            $facultyProjects->the_post();
                    ?>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 project">
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
                            
                    <?php
                        }
                        ?>
                        
                        </div> <!-- end grids -->

                        <div class="projects-pagnigation">
                        <?php
                            
                            $total_pages = $facultyProjects->max_num_pages;
                            $current_page = max( 1, get_query_var( 'paged' ) );

                            echo paginate_links( array(
                                'base' => get_pagenum_link( 1 ) . '%_%',
                                'format' => 'page/%#%',
                                'current' => $current_page,
                                'total' => $total_pages,
                                'prev_text'    => __('<span class="fa fa-chevron-left"></span> <span class="screen-reader-text">previous</span>'),
                                'next_text'    => __('<span class="fa fa-chevron-right"></span> <span class="screen-reader-text">next</span>'),
                                'show_all' => true,
                                'type' => 'list'
                            ) );
                        ?>
                        </div>
                        
                        </div>

                        <?php
                            
                        wp_reset_postdata();

                        } else {
                            
                          ?>
                          
                          <div class="col-12">

                    <div class="alert alert-light" role="alert">
                        <h2 class="text-center">💔<br>No Projects To Show</h2>
                        <hr>
                        <p class="text-center">Projects will show up here after projects are added.</p>
                    </div>
                              
                          </div>
                          
                          <?php
                          
                        }
                        
                    ?>
                            
                    
                    
                </section>
            
            </main>
            
            <!-- sidebar -->
            <aside class="sidebar col-12 col-sm-12 col-md-3" role="complementary">
                
                <!-- search -->
                <div class="search" role="search">
                <div class="input-group">
                    <input type="hidden" name="postId" value="<?php echo $post->ID; ?>" />
                    <input id="ajaxSearchInput" class="ajaxSearchInput form-control" placeholder="Search <?php echo get_the_title(); ?>" type="text">
                    <div class="input-group-append">
                        <button id="ajaxSearchBtn" class="btn btn-outline-secondary"><span class="fa fa-search" aria-hidden="true"></span><span class="screen-reader-text">Search</span></button>
                    </div>
                </div>
                </div>
                
                <div class="sidebarFilter">
                    <div class="filter">
                        <h3>Filter</h3>			
                        <div class="filter-form">
                            
                            <h4>Programs</h4>
                            <?php
                                       
                               $programs = get_terms(array( 'taxonomy' => 'programs', 'hide_empty' => false ));
                               
                               foreach( $programs as $program ) {
                                   
                                   echo '<div class="form-check"><input type="checkbox" class="form-check-input program-cb" id="program_' .$program->slug . '" value="' . $program->slug . '"><label class="form-check-label" for="program_' . $program->slug . '">' . $program->name . '</label></div>';
                                   
                               }
                               
                            ?>
                            
                            <h4>Classifications</h4>
                            
                            <?php
                                       
                               $classifications = get_terms(array( 'taxonomy' => 'classifications', 'hide_empty' => false ));
                               
                               foreach( $classifications as $classification ) {
                                   
                                   echo '<div class="form-check"><input type="checkbox" class="form-check-input classification-cb" id="classification_' .$classification->slug . '" value="' . $classification->slug . '"><label class="form-check-label" for="classification_' . $classification->slug . '">' . $classification->name . '</label></div>';
                                   
                               }
                               
                            ?>
                            
                            <h4>Media Types</h4>
                            <?php
                                       
                               $mediaTypes = get_terms(array( 'taxonomy' => 'media_types', 'hide_empty' => false ));
                               
                               foreach( $mediaTypes as $type ) {
                                   
                                   echo '<div class="form-check"><input type="checkbox" class="form-check-input media-cb" id="media_type_' .$type->slug . '" value="' . $type->slug . '"><label class="form-check-label" for="media_type_' . $type->slug . '">' . $type->name . '</label></div>';
                                   
                               }
                               
                            ?>
                            
                        </div>
                    </div>
                </div>
            
            </aside>
            <!-- /sidebar -->
        
        </div>
    
    </div>

 <?php get_footer(); ?>