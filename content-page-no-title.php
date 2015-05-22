<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package UWEX-Media
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'uwex-media' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( '<span class="glyphicon glyphicon-pencil"></span> Edit', 'uwex-media' ), '<div class="entry-meta"><p class="text-right">', '</p></div>' );

    	if ( !is_front_page() && !is_home() ) {

    	    echo '<p class="modified-note">';
        	echo 'Created on ' . get_the_date( 'F d, Y' ) . ' at ' . get_the_date( 'g:i:s a T' ) . '. ';
        	echo 'Last modified on ' . get_the_modified_time( 'F d, Y' ) . ' at ' . get_the_modified_time( 'g:i:s a T' ) . '.';
        	echo '</p>';

    	}
    ?>

</article><!-- #post-## -->
