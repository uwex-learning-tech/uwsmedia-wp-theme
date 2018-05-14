<?php get_header(); ?>
<!-- body content container -->
<div class="container">
    
    <div class="row">
    
	<main class="col-12 col-sm-12 col-md-8" role="main">
		<!-- section -->
		<section>
            
            <!-- post thumbnail -->
    		<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
    		<div class="page-featured-image">
    			<?php the_post_thumbnail(); ?>
            </div>
    		<?php endif; ?>
    		<!-- /post thumbnail -->
            
			<h1><?php the_title(); ?></h1>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
				<?php the_content(); ?>

				<?php
                	if ( !is_front_page() ) {
            
                	    echo '<p class="published-date">';
                    	echo 'Published on ' . get_the_date( 'F d, Y' ) . ' at ' . get_the_date( 'g:i:s a T' ) . '. ';
                    	echo 'Last modified on ' . get_the_modified_time( 'F d, Y' ) . ' at ' . get_the_modified_time( 'g:i:s a T' ) . '.';
                    	echo '</p>';
            
                	}
                ?>

			</article>
			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'uwsmedia' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

		</section>
		<!-- /section -->
	</main>

<?php if ( !is_front_page() ) { ?>

    <?php get_sidebar(); ?>
    </div>
</div>
<!-- /body content container -->

<?php } ?>

<?php get_footer(); ?>
