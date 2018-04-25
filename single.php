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
                    
                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        
                        <p class="date"><?php the_time('F j, Y'); ?> | Updated on <?php the_modified_date('F j, Y');?></p>
                        
                        <!-- post title -->
                        <h1><?php the_title(); ?></h1>
                        <!-- /post title -->
                        
                        <p class="categories"><?php 

                            $cat_before = '';
                            $cat_separator = ', ';
                            $cat_after = '';
                            $category_counter = count( get_the_terms( $post->ID, 'category' ) );
                            $i=0; // counter
                            
                            foreach ((get_the_category()) as $category) {
                                
                                $i = $i + 1;
                                
                                while ( $i < $category_counter ) {
                                    echo $cat_before . $category->cat_name . $cat_separator;
                                    break;
                                }
                                
                            }
                            
                            echo $cat_before . $category->cat_name . $cat_after;
                            
                        ?></p>
        
                        <p class="authors"><?php _e( 'By', 'uwsmedia' ); ?> <?php the_author_posts_link(); ?></p>
                        
                        <?php the_content(); // Dynamic Content ?>
                        <ul class="tag-pills">
                        <?php 

                        $tag_before = '<li>';
                        $tag_separator = '';
                        $tag_after = '</li>';
                        $tag_counter = count( get_the_terms( $post->ID, 'post_tag' ) );
                        $i=0; // counter
                        
                        foreach ((wp_get_post_tags($post->ID)) as $tags) {
                            
                            $i = $i + 1;
                            
                            while ( $i < $tag_counter ) {
                                echo $tag_before . $tags->name . $tag_separator;
                                break;
                            }
                            
                        }
                        
                        echo $tag_before . $tags->name . $tag_after;
                        
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
