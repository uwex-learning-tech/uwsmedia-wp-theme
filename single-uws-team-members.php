<?php get_header(); ?>
    <div class="container">
        <div class="row">
            
            <?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <!-- post thumbnail -->
    		
    		<aside class="col-12 col-sm-12 col-md-3">
        		
        		<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
        		
        		<div class="post-featured-image">
    			    <?php the_post_thumbnail(); ?>
        		</div>
        		
        		<?php endif; ?>
    		<!-- /post thumbnail -->
        		
        		<ul class="social-networks d-flex">
    			    
    			    <?php
        			    
                    $linkedIn = get_post_meta( get_the_ID(), 'linkedin_username', true );
                    
                    if ( !empty( $linkedIn ) ) {
                        echo '<li class="icon"><a href="https://www.linkedin.com/in/' . $linkedIn . '" target="_blank"><span class="fa fa-linkedin-square"><span class="screen-reader-text">LinkedIn Profile Link</span></span></a></li>';
                    }
                    
                    $twitter = get_post_meta( get_the_ID(), 'twitter_username', true );
                    
                    if ( !empty( $twitter ) ) {
                        echo '<li class="icon"><a href="https://twitter.com/' . $twitter . '" target="_blank"><span class="fa fa-twitter"><span class="screen-reader-text">Twitter Profile Link</span></span></a></li>';
                    }
                    
                    $facebook = get_post_meta( get_the_ID(), 'facebook_username', true );
                    
                    if ( !empty( $facebook ) ) {
                        echo '<li class="icon"><a href="https://www.facebook.com/' . $facebook . '" target="_blank"><span class="fa fa-facebook-official"><span class="screen-reader-text">Facebook Profile Link</span></span></a></li>';
                    }
                    
                    $youtube = get_post_meta( get_the_ID(), 'youtube_username', true );
                    
                    if ( !empty( $youtube ) ) {
                        echo '<li class="icon"><a href="https://www.youtube.com/user/' . $youtube . '" target="_blank"><span class="fa fa-youtube"><span class="screen-reader-text">YouTube Profile Link</span></span></a></li>';
                    }
                    
                    $google = get_post_meta( get_the_ID(), 'googleplus_username', true );
                    
                    if ( !empty( $google ) ) {
                        echo '<li class="icon"><a href="https://plus.google.com/' . $google . '" target="_blank"><span class="fa fa-google-plus-square"><span class="screen-reader-text">Google+ Profile Link</span></span></a></li>';
                    }
                    
                    $behance = get_post_meta( get_the_ID(), 'behance_username', true );
                    
                    if ( !empty( $behance ) ) {
                        echo '<li class="icon"><a href="https://www.behance.net/' . $behance . '" target="_blank"><span class="fa fa-behance-square"><span class="screen-reader-text">Béhance Profile Link</span></span></a></li>';
                    }
                    
                    $github = get_post_meta( get_the_ID(), 'github_username', true );
                    
                    if ( !empty( $github ) ) {
                        echo '<li class="icon"><a href="https://github.com/' . $github . '" target="_blank"><span class="fa fa-github-square"><span class="screen-reader-text">GitHub Profile Link</span></span></a></li>';
                    }
                    
                    ?>
    			    
        		</ul>
        		
            </aside>
            
            <main class="col-12 col-sm-12 col-md-9" role="main">
                
                <!-- section -->
                <section>

                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        
                        <!-- post title -->
                        <h1><?php the_title(); ?></h1>
                        <!-- /post title -->
                        
                        <p class="job-title"><?php echo get_post_meta( get_the_ID(), 'job_title', true ); ?></p>
                        
                        <?php the_content(); // Dynamic Content ?>
                        
                        
                        <?php 
                            
                            $interestStr = get_post_meta( get_the_ID(), 'member_interests' )[0];   
                            
                            if ( !empty( $interestStr ) ) :
                        ?>
                        
                        <h2>Interests</h2>
                        <p class="interests">
                            
                            <?php 
                                
                                $interests = explode( ',', $interestStr );
                                
                                foreach( $interests as $interest ) : ?>
                                    
                                <span class="badge badge-light"><?php echo ucwords( trim( $interest ) ); ?></span>
                                    
                                <?php endforeach; ?>
                            
                        </p>
                        
                        <?php endif; ?>
                        
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
