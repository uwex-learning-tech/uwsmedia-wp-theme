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
        
            <main class="col-9" role="main">
            
                <section id="projects-archive">
                
                    <h1><?php the_title(); ?></h1>
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
                        <div class="col-4 project">
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

                        <?php
                            
                        wp_reset_postdata();

                        } else {
                            
                          esc_html_e( 'No projects found!', 'uwsmedia' );
                          
                        }
                        
                    ?>
                            
                    
                    
                </section>
            
            </main>
            
            <!-- sidebar -->
            <aside class="sidebar col-3" role="complementary">
                
                <!-- search -->
                <div class="search" role="search">
                <div class="input-group">
                    <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />
                    <input id="ajax-search-input" class="ajax-search-input form-control" placeholder="Search <?php echo get_the_title(); ?>" type="text">
                    <div class="input-group-append">
                        <button id="ajax-search-btn" class="btn btn-outline-secondary"><span class="fa fa-search" aria-hidden="true"></span><span class="screen-reader-text">Search</span></button>
                    </div>
                </div>
                </div>
                
                <div class="sidebar-filter">
                    <div class="filter">
                        <h3>Filter</h3>			
                        <form class="filter-form">
                            
                            <h4>Degree Programs</h4>
                            <?php
                                       
                               $degreePrograms = get_terms(array( 'taxonomy' => 'degree_programs', 'hide_empty' => false ));
                               
                               foreach( $degreePrograms as $program ) {
                                   
                                   echo '<div class="form-check"><input type="checkbox" class="form-check-input" id="degree_program_' .$program->slug . '" value="' . $program->slug . '"><label class="form-check-label" for="degree_program_' . $program->slug . '">' . $program->name . '</label></div>';
                                   
                               }
                               
                            ?>
                            
                            <h4>Use Cases</h4>
                            
                            <?php
                                       
                               $useCases = get_terms(array( 'taxonomy' => 'use_cases', 'hide_empty' => false ));
                               
                               foreach( $useCases as $case ) {
                                   
                                   echo '<div class="form-check"><input type="checkbox" class="form-check-input" id="use_case_' .$case->slug . '" value="' . $case->slug . '"><label class="form-check-label" for="use_case_' . $case->slug . '">' . $case->name . '</label></div>';
                                   
                               }
                               
                            ?>
                            
                            <h4>Media Types</h4>
                            <?php
                                       
                               $mediaTypes = get_terms(array( 'taxonomy' => 'media_types', 'hide_empty' => false ));
                               
                               foreach( $mediaTypes as $type ) {
                                   
                                   echo '<div class="form-check"><input type="checkbox" class="form-check-input" id="media_type_' .$type->slug . '" value="' . $type->slug . '"><label class="form-check-label" for="media_type_' . $type->slug . '">' . $type->name . '</label></div>';
                                   
                               }
                               
                            ?>
                        </form>
                    </div>
                </div>
            
            </aside>
            <!-- /sidebar -->
        
        </div>
    
    </div>

 <?php get_footer(); ?>