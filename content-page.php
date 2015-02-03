<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package UWEX-Media
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( !is_front_page() ) { ?>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
	<?php } ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'uwex-media' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( '<span class="glyphicon glyphicon-pencil"></span> Edit', 'uwex-media' ), '<div class="entry-meta"><p class="text-right">', '</p></div>' ); ?>
	<p class="modified-note"><?php
    	echo 'Created on ' . get_the_date( 'F d, Y' ) . ' at ' . get_the_date( 'g:i:s a T' ) . '. ';
    	echo 'Last modified on ' . get_the_modified_time( 'F d, Y' ) . ' at ' . get_the_modified_time( 'g:i:s a T' ) . '.';
    	?></p>

</article><!-- #post-## -->
