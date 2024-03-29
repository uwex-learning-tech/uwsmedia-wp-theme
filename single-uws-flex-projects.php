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

    <div class="container">

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

<main class="container project-content pt-4 pb-3" role="main">

    <!-- article -->
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <!-- share -->
        <div class="sharings" role="group" aria-label="Share">

            <a id="copy-share-link" class="btn btn-link" title="Copy Link"><i class="bi bi-link-45deg" aria-hidden="true"></i><input id="hiddenShareLink" type="text"
                    value="<?php the_permalink(); ?>" /></a>

            <a id="shareOnLinkedIn" class="btn btn-link"
                data-ref="http://www.linkedin.com/shareArticle?mini=true&amp;title=<?php echo urlencode(get_the_title()); ?>&amp;summary=<?php echo urlencode(get_the_excerpt()); ?>&amp;url=<?php the_permalink(); ?>&amp;source=<?php echo urlencode( get_blogInfo( 'name' ) ); ?>"
                title="Share on LinkedIn"><i class="bi bi-linkedin" aria-hidden="true"></i></a>

            <div class="share msg"></div>

        </div>
        <!-- /share -->

        <?php

            $now = new DateTime("NOW");
            $postCreationDate = new DateTime(get_the_date( 'Y-m-d' ));
            $numOfDays = $postCreationDate->diff($now)->format("%a");

            if ( $numOfDays <= 30 ) {?>

            <small class="d-inline-block mt-3 mb-2 px-2 py-1 fw-semibold fs-6 lh-1 text-success bg-success bg-opacity-10 border border-success border-opacity-10 rounded-2">New</small>

        <?php } ?>

        <p class="degree mb-0 fs-6 lh-base"><?php 

        $degree_terms = get_the_terms( $post->ID, 'flex_degrees' );

        if ( is_array( $degree_terms )
        && count( $degree_terms ) >= 1 ) {
            
            echo $degree_terms[0]->name;
            
        }

        $course_info = trim( get_post_meta( $post->ID, 'course_info', true ) );

        if ( !empty( $course_info ) ) { 
            echo " | " . $course_info;
        }

        ?></p>

        <!-- post title -->
        <h1 class="mt-0"><?php the_title(); ?></h1>
        <!-- /post title -->

        <p class="classification mb-3"><strong><?php 

        $class_terms = get_the_terms( $post->ID, 'flex_classifications' );

        if ( is_array( $class_terms )
        && count( $class_terms ) >= 1 ) {
            
            echo $class_terms[0]->name;
            
        }

        ?></strong></p>

        <!-- instructor -->
        <?php
            
            $instructorStr = trim( get_post_meta( $post->ID, 'other_authors', true ) );
            
            if ( !empty( $instructorStr ) ) {
                
                echo '<p class="instructor mb-0"><strong>Instructor:</strong> ';
                
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
            
                $memberIds = explode( ',', $memberStr );

                $plural = count($memberIds) > 1 ? 's' : '';
                echo '<p class="members mb-3"><strong>Team Member' . $plural .':</strong> ';

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
        <div class="tag-pills mb-3">
            <?php 

        $use_case_terms = get_the_terms( $post->ID, 'flex_media_types' );
        
        if ( is_array( $use_case_terms ) ) {
            
            $tag_before = '<span class="badge text-bg-secondary">';
            $tag_separator = '';
            $tag_after = '</span> ';
            
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
        </div>
        <!-- /tags -->

        <!-- post content -->
        <?php the_content(); // Dynamic Content ?>
        <!-- /post content -->

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