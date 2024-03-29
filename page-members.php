<?php
/**
 * Template Name: Team Members
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage UWS Media
 * @since 1.0.0
 */
 
get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="header-banner">
    <div class="container">
        <h1 class="banner-title"><?php
            
            $pageTitle = get_post_meta( get_the_ID(), 'banner_title' , true );
            
                the_title();
            
            ?></h1>
        <div class="banner-content">
            <?php echo html_entity_decode( get_post_meta( get_the_ID(), 'banner_content' , true ) ); ?></div>
    </div>
</div>

<main class="container pt-4" role="main">

    <section>
        <div class="entry-content-page">
            <?php if ( has_post_thumbnail() ) : ?>
            <img src="<?php the_post_thumbnail_url(); ?>" alt="" />
            <?php endif; ?>
            <?php the_content(); ?>
        </div>
    </section>

    <?php
    endwhile;
    wp_reset_query();
?>

    <section id="member-archive">

        <div class="row d-flex">
            <?php
            
            $query_args = array(
                'post_type' => 'uws-team-members',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query' => array(
                    'show_first' => array(
                        'key' => 'show_first',
                        'value' => array( 0, 1 ),
                        'compare' => 'IN'
                    )
                    
                ),
                'order' => 'ASC',
                'orderby' => array(
                    'show_first' => 'DESC',
                    'title' => 'ASC'
                )
            );
            
            $members = new WP_Query( $query_args );
            
            if ( $members->have_posts() ) :
                
                while( $members->have_posts() ) : $members->the_post();
     
        ?>

            <div class="col-12 col-sm-12 col-md-6 col-lg-4 member">
                <div class="card h-100">

                    <?php
                            
                            if ( has_post_thumbnail() ) : 
                                
                                the_post_thumbnail( 'post-thumbnail', [
                            
                                'class' => 'card-img-top',
                                'alt' => 'Photo of ' . get_the_title()
                                
                                ] );
                                
                            else:
                            
                        ?>

                    <div class="no-pic d-flex align-items-center justify-content-center"></div>

                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                        <p class="card-text text-muted member-title">
                            <?php echo get_post_meta( get_the_ID(), 'job_title', true ); ?><br>
                            <a
                                href="https://media.uwex.edu/content/uwex/resources/pronouns-usage-guide.pdf" target="_blank" referrerpolicy="no-referrer"><?php echo get_post_meta( get_the_ID(), 'pronouns', true ); ?></a>
                        </p>
                        <p class="card-text member-excerpt"><?php the_excerpt(); ?></p>

                        <?php
                            
                            $interestStr = get_post_meta( get_the_ID(), 'member_interests' )[0];   
                            
                            if ( !empty( $interestStr ) ) :
                            
                            ?>

                        <p class="card-text text-center text-muted member-interests">

                            <?php
                                    
                                    $interests = array_filter( explode( ',', $interestStr ) );
                                    $count = 0;
                                    foreach( $interests as $interest ) :
                                    
                                        echo ucwords( trim( $interest ) );
                                        $count++;

                                        if ( $count < count( $interests ) ) {
                                            echo ' &bull; ';
                                        }
                                        
                                    endforeach;
                                
                                  ?>

                        </p>

                        <?php endif; ?>

                    </div>

                    <div class="card-footer text-center social-icons">

                        <?php
                			    
                            $linkedIn = get_post_meta( get_the_ID(), 'linkedin_username', true );
                            
                            if ( !empty( $linkedIn ) ) {
                                echo '<a class="btn btn-link" href="https://www.linkedin.com/in/' . $linkedIn . '" target="_blank"><i class="bi bi-linkedin"><span class="screen-reader-text">LinkedIn Profile Link</span></i></a>';
                            }
                            
                            $twitter = get_post_meta( get_the_ID(), 'twitter_username', true );
                            
                            if ( !empty( $twitter ) ) {
                                echo '<a class="btn btn-link" href="https://twitter.com/' . $twitter . '" target="_blank"><i class="bi bi-twitter"><span class="screen-reader-text">Twitter Profile Link</span></i></a>';
                            }
                            
                            $facebook = get_post_meta( get_the_ID(), 'facebook_username', true );
                            
                            if ( !empty( $facebook ) ) {
                                echo '<a class="btn btn-link" href="https://www.facebook.com/' . $facebook . '" target="_blank"><i class="bi bi-facebook"><span class="screen-reader-text">Facebook Profile Link</span></i></a>';
                            }
                            
                            $youtube = get_post_meta( get_the_ID(), 'youtube_username', true );
                            
                            if ( !empty( $youtube ) ) {
                                echo '<a class="btn btn-link" href="https://www.youtube.com/user/' . $youtube . '" target="_blank"><i class="bi bi-youtube"><span class="screen-reader-text">YouTube Profile Link</span></i></a>';
                            }
                            
                            $behance = get_post_meta( get_the_ID(), 'behance_username', true );
                            
                            if ( !empty( $behance ) ) {
                                echo '<a class="btn btn-link" href="https://www.behance.net/' . $behance . '" target="_blank"><i class="bi bi-behance"><span class="screen-reader-text">Béhance Profile Link</span></i></a>';
                            }
                            
                            $github = get_post_meta( get_the_ID(), 'github_username', true );
                            
                            if ( !empty( $github ) ) {
                                echo '<a class="btn btn-link" href="https://github.com/' . $github . '" target="_blank"><i class="bi bi-github"><span class="screen-reader-text">GitHub Profile Link</span></i></a>';
                            }

                            ?>

                    </div>

                </div>
            </div>

            <?php
                
                endwhile;
                
            wp_reset_postdata();
            
        ?>

        </div>

        <?php else: ?>

        <div class="alert alert-light col-12" role="alert">
            <h2 class="text-center">😱<br>No Members To Show</h2>
            <hr>
            <p class="text-center">Members will show up here after members are added.</p>
        </div>

        <?php endif; ?>

    </section>

</main>

<?php get_footer(); ?>