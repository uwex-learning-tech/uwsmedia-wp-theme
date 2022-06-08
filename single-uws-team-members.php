<?php get_header(); ?>
    <div class="container">
        <div class="row">
            
            <?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <!-- post thumbnail -->
    		
    		<aside class="col-12 col-sm-12 col-md-12 col-lg-4 p-4">
        		
        		<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
        		
        		<div class="post-featured-image">
    			    <?php the_post_thumbnail(); ?>
        		</div>
        		
        		<?php else: ?>
        		
        		<div class="no-pic d-flex align-items-center justify-content-center"></div>
        		
        		<?php endif; ?>
    		<!-- /post thumbnail -->
        		
        		<ul class="social-networks d-flex">
    			    
    			    <?php
        			    
                    $linkedIn = get_post_meta( get_the_ID(), 'linkedin_username', true );
                    
                    if ( !empty( $linkedIn ) ) {
                        echo '<li class="icon"><a href="https://www.linkedin.com/in/' . $linkedIn . '" target="_blank"><i class="bi bi-linkedin"><span class="screen-reader-text">LinkedIn Profile Link</span></i></a></li>';
                    }
                    
                    $twitter = get_post_meta( get_the_ID(), 'twitter_username', true );
                    
                    if ( !empty( $twitter ) ) {
                        echo '<li class="icon"><a href="https://twitter.com/' . $twitter . '" target="_blank"><i class="bi bi-twitter"><span class="screen-reader-text">Twitter Profile Link</span></i></a></li>';
                    }
                    
                    $facebook = get_post_meta( get_the_ID(), 'facebook_username', true );
                    
                    if ( !empty( $facebook ) ) {
                        echo '<li class="icon"><a href="https://www.facebook.com/' . $facebook . '" target="_blank"><i class="bi bi-facebook"><span class="screen-reader-text">Facebook Profile Link</span></i></a></li>';
                    }
                    
                    $youtube = get_post_meta( get_the_ID(), 'youtube_username', true );
                    
                    if ( !empty( $youtube ) ) {
                        echo '<li class="icon"><a href="https://www.youtube.com/user/' . $youtube . '" target="_blank"><i class="bi bi-youtube"><span class="screen-reader-text">YouTube Profile Link</span></i></a></li>';
                    }
                    
                    $behance = get_post_meta( get_the_ID(), 'behance_username', true );
                    
                    if ( !empty( $behance ) ) {
                        echo '<li class="icon"><a href="https://www.behance.net/' . $behance . '" target="_blank"><i class="bi bi-behance"><span class="screen-reader-text">Béhance Profile Link</span></i></a></li>';
                    }
                    
                    $github = get_post_meta( get_the_ID(), 'github_username', true );
                    
                    if ( !empty( $github ) ) {
                        echo '<li class="icon"><a href="https://github.com/' . $github . '" target="_blank"><i class="bi bi-github"><span class="screen-reader-text">GitHub Profile Link</span></i></a></li>';
                    }
                    
                    ?>
    			    
        		</ul>
        		
            </aside>
            
            <main class="col-12 col-sm-12 col-md-12 col-lg-8" role="main">
                
                <!-- section -->
                <section>

                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        
                        <!-- post title -->
                        <h1><?php the_title(); ?></h1>
                        <!-- /post title -->
                        
                        <p class="job-title"><?php echo get_post_meta( get_the_ID(), 'job_title', true ); ?><br><?php echo get_post_meta( get_the_ID(), 'pronouns', true ); ?></p>
                        
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
                                    
                                <span class="badge rounded-pill bg-light text-dark"><?php echo ucwords( trim( $interest ) ); ?></span>
                                    
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
        
        <!-- projects -->
        <input name="post_id" type="hidden" value="<?php echo $post->ID; ?>"/>
        <input type="hidden" name="bloginfo" value="<?php echo get_bloginfo( 'url' ); ?>" />
        <section id="member-projects"></section>

	</div>
	<!-- /body content container -->


<?php get_footer(); ?>
