<?php get_header(); ?>
    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <!-- post thumbnail -->
    		<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
    		<div class="post-featured-image">
    			<?php the_post_thumbnail(); ?>
            </div>
    		<?php endif; ?>
    		<!-- /post thumbnail -->
    <div class="container">
        <div class="row">
            <main class="col-10 offset-1" role="main">
                
                <ul class="sharings">
                    <li><a id="copy-share-link" href="javascript:void(0);" title="Copy Link"><span class="fa fa-link" aria-hidden="true" aria-hidden="true"></span><input class="hiddenShareLink" type="text" value="<?php the_permalink(); ?>" /></a></li><li class="separator"></li><li><a id="shareOnLinkedIn" href="javascript:void(0);" data-ref="http://www.linkedin.com/shareArticle?mini=true&amp;title=<?php echo urlencode(get_the_title()); ?>&amp;summary=<?php echo urlencode(get_the_excerpt()); ?>&amp;url=<?php the_permalink(); ?>&amp;source=<?php echo urlencode( get_blogInfo( 'name' ) ); ?>" title="Share on LinkedIn"><span class="fa fa-linkedin-square" aria-hidden="true"></span></a></li>
                    <li class="msg"></li>
                </ul>
                
                <!-- section -->
                <section>
<!--                     https://pippinsplugins.com/create-live-search-wordpress-jquery-ajax/ -->
                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <p class="date">
                        <?php
                            
                            the_time('F j, Y');

                            if ( strcmp( get_the_time( 'F j, Y' ), get_the_modified_date( 'F j, Y' ) ) !== 0 ) {
                                
                                echo ' | Updated on ' . get_the_modified_date( 'F j, Y' );
                                
                            }
                            
                        ?></p>
                        
                        <!-- post title -->
                        <h1><?php the_title(); ?></h1>
                        <!-- /post title -->
                        
                        <p class="categories"><?php 

                                $classification_terms = get_the_terms( $post->ID, 'classifications' );
            
                                if ( !is_array( $classification_terms ) || count( $classification_terms ) <= 0 ) {
                                    echo '<span aria-hidden="true">&nbsp;</span>';
                                } else {
                                    echo $classification_terms[0]->name;
                                }
                                
                            ?></p>
        
                        <?php
                            
                            $authors = get_post_meta( $post->ID, 'project_authors', true );
                            $otherAuthors = trim( get_post_meta( $post->ID, 'other_authors', true ) );
                            
                            if ( !empty( $authors ) || !empty( $otherAuthors ) ) {
                                
                                echo '<p class="authors">By ';
                            
                                if ( !empty( $authors ) ) {
                                    
                                    $count = 0;
                                    $authorIds = explode( ',', get_post_meta( $post->ID, 'project_authors', true ) );
                                    
                                    foreach( $authorIds as $id ) {
                                    
                                        echo '<a href="' . get_the_permalink( $id ) .'">' . get_the_title( $id ) . '</a>';
                                        
                                        $count++;
                                        
                                        if ( $count < count( $authorIds ) 
                                        || !empty( $otherAuthors ) ) {
                                            echo ', ';
                                        }
                                        
                                    }
                                    
                                }
                                
                                if ( !empty( $otherAuthors ) ) {
                                    
                                    $otherArry = explode( ',', $otherAuthors );
                                    
                                    $count = 0;
                                    
                                    foreach( $otherArry as $other ) {
                                    
                                        echo ucwords( trim( $other ) );
                                        
                                        $count++;
                                        
                                        if ( $count < count( $otherArry ) ) {
                                            echo ', ';
                                        }
                                        
                                    }
                                    
                                }
                                
                                echo '</p>';
                                
                            } else {
                                echo '<p class="authors"></p>';
                            }
                            
                        ?>
                        
                        <?php the_content(); // Dynamic Content ?>
                        <ul class="tag-pills">
                        <?php 

                        $tag_terms = null;
                        $use_case_terms = get_the_terms( $post->ID, 'media_types' );
                        $degree_program_terms = get_the_terms( $post->ID, 'programs' );
                        
                        if ( is_array( $use_case_terms )
                        && is_array( $degree_program_terms ) ) {
                            
                            $tag_before = '<li>';
                            $tag_separator = '';
                            $tag_after = '</li>';
                            
                            $tag_terms = array_merge( $use_case_terms, $degree_program_terms );
                            $tag_counter = count( $tag_terms );
                            
                            $i = 0;
                            
                            foreach ( $tag_terms as $tags ) {
                            
                                $i = $i + 1;
                                
                                while ( $i < $tag_counter ) {
                                    echo $tag_before . $tags->name . $tag_separator;
                                    break;
                                }
                                
                            }
                            
                            echo $tag_before . $tags->name . $tag_after;
                            
                        } 

                        ?>
                        </ul>
                        
                        <?php edit_post_link( __( 'Edit Project', 'uwsmedia' ), '<p>', '</p>', null ); ?>
                    
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
