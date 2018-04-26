<?php
/**
 * Template Name: Faculty Showcase
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
            
                <section>
                
                    <h1><?php the_title(); ?></h1>
                    <div class="row d-flex flex-row">
                    <?php
                        
                        $query_args = array(
                            'post_type' => 'uws-projects',
                            'post_status' => 'publish',
                            'meta_query'  => array(
                                    array(
                                        'key' => 'post_group_id',
                                        'value' => get_post_meta( $post->ID, 'post_group_id', true )
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

                                $cat_separator = ' | ';

                                $category_counter = count( get_the_terms( $post->ID, 'category' ) );
                                
                                $i=0; // counter
                                
                                foreach ( (get_the_category()) as $category ) {
                                    
                                    $i = $i + 1;
                                    
                                    while ( $i < $category_counter ) {
                                        echo $category->cat_name . $cat_separator;
                                        break;
                                    }
                                    
                                }
                                
                                echo $category->cat_name ;
                                
                            ?></p>
                                <h2 class="d-flex align-items-center justify-content-center"><?php the_title(); ?></h2>
                                <p class="date"><?php the_time('F j, Y'); ?></p>
                                </div>
                                
                            </a>
                        </div>
                            
                    <?php
                        }
                        
                        wp_reset_postdata();

                        } else {
                            
                          esc_html_e( 'No projects found!', 'uwsmedia' );
                        }
                        
                    ?>
                            
                    </div>
                    
                </section>
            
            </main>
            
            <!-- sidebar -->
            <aside class="sidebar col-3" role="complementary">
                
                <!-- search -->
                <form class="search" method="get" action="http://localhost/local-wp/uwex" role="search">
                    
                    <div class="input-group">
                        <input class="search-input form-control" name="s" placeholder="Search Faculty Showcase" type="search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary search-submit" type="submit"><span class="fa fa-search" aria-hidden="true"></span><span class="screen-reader-text">Search</span></button>
                        </div>
                    </div>
                    
                </form>
                
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