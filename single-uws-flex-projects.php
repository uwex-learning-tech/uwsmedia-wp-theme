<?php 
    
    get_header();
    
    if ( have_posts() ):
        
        while ( have_posts() ) :
            
            the_post();
            
            $postID = $post->ID;
            
            // post thumbnail
            if ( get_post_meta( $post->ID, 'hide_thumbnail' )[0] != '1' ) :
            
                if ( has_post_thumbnail() ) :
    
?>

<div class="post-featured-image">
    <?php the_post_thumbnail(); ?>
</div>

<?php
                endif;
            
            endif; // end post thumbnail
            
            $embedMedia = get_post_meta( $post->ID, 'media_embed_code', true );
            
            if ( !empty( trim( $embedMedia ) ) ) :
            
                $responsive = get_post_meta( $post->ID, 'responsive_choice', true );
            
?>

<div class="top-embed">

    <div class="d-flex align-items-center justify-content-center">

        <?php
                
        if ( !empty( $responsive ) ) {
            
            echo '<div class="embed-responsive embed-responsive-' . $responsive . '">' . $embedMedia . '</div>';
            
        } else {
            
            echo $embedMedia;
            
        }

        ?>

    </div>

</div>

<?php endif; ?>

<main class="container project-content pb-3" role="main">

    <!-- article -->
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <!-- share -->
        <div class="sharings" role="group" aria-label="Share">

            <a id="copy-share-link" class="btn btn-link" href="javascript:void(0);" title="Copy Link"><span
                    class="fa fa-link" aria-hidden="true" aria-hidden="true"></span><input id="hiddenShareLink"
                    type="text" value="<?php the_permalink(); ?>" /></a>

            <a id="shareOnLinkedIn" class="btn btn-link" href="javascript:void(0);"
                data-ref="http://www.linkedin.com/shareArticle?mini=true&amp;title=<?php echo urlencode(get_the_title()); ?>&amp;summary=<?php echo urlencode(get_the_excerpt()); ?>&amp;url=<?php the_permalink(); ?>&amp;source=<?php echo urlencode( get_blogInfo( 'name' ) ); ?>"
                title="Share on LinkedIn"><span class="fa fa-linkedin-square" aria-hidden="true"></span></a>

            <div class="share msg"></div>

        </div>
        <!-- /share -->

        <!-- post title -->
        <h1><?php the_title(); ?></h1>
        <!-- /post title -->

        <p class="classification"><strong><?php 

        $class_terms = get_the_terms( $post->ID, 'flex_classifications' );

        if ( is_array( $class_terms )
        && count( $class_terms ) >= 1 ) {
            
            echo $class_terms[0]->name;
            
        }

        ?></strong></p>

        <!-- post content -->
        <?php the_content(); // Dynamic Content ?>
        <!-- /post content -->

        <!-- instructor -->
        <?php
            
            $instructorStr = trim( get_post_meta( $post->ID, 'other_authors', true ) );
            
            if ( !empty( $instructorStr ) ) {
                
                echo '<p class="instructor"><strong>Instructor:</strong> ';
                
                $instructors = explode( ',', $instructorStr );
                $count = 0;
                
                foreach( $instructors as $instructor ) {
                
                    echo ucwords( trim( $instructor ) );
                    
                    $count++;
                    
                    if ( $count < count( $instructors ) ) {
                        
                        echo ', ';
                        
                    }
                    
                }
                
                echo '</p>';
                
            }
            
        ?>
        <!-- /instructor -->

        <!-- members -->
        <?php
            
            $memberStr = get_post_meta( $post->ID, 'project_authors', true );
            
            if ( !empty( $memberStr ) ) {
                
                echo '<p class="members"><strong>Team Member(s):</strong> ';
            
                $memberIds = explode( ',', $memberStr );
                $count = 0;
                
                foreach( $memberIds as $id ) {
                
                    echo '<a href="' . get_the_permalink( $id ) .'">' . get_the_title( $id ) . '</a>';
                    
                    $count++;
                    
                    if ( $count < count( $memberIds ) ) {
                        
                        echo ', ';
                        
                    }
                    
                }
                
                echo '</p>';
                
            }
            
        ?>
        <!-- /members -->

        <!-- tags -->
        <ul class="tag-pills">
            <?php 

        $tag_terms = null;
        $use_case_terms = get_the_terms( $post->ID, 'flex_media_types' );
        
        if ( is_array( $use_case_terms ) ) {
            
            $tag_before = '<li>';
            $tag_separator = '';
            $tag_after = '</li>';
            
            $tag_counter = count( $use_case_terms );
            
            $i = 0;
            
            foreach ( $use_case_terms as $tags ) {
            
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
        <!-- /tags -->

        <?php edit_post_link( __( 'Edit Project', 'uwsmedia' ), '<p>', '</p>', $postID ); ?>

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

</main>
<!-- /body content container -->

<?php get_footer(); ?>