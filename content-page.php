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
	<?php edit_post_link( __( '<span class="glyphicon glyphicon-pencil"></span> Edit', 'uwex-media' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
	<p><em><small><?php echo 'Last modified on ' . get_the_modified_time( 'F d, Y' ) . ' at ' . get_the_modified_time( 'g:i:s a T' ) . '.'; ?></small></em></p>

</article><!-- #post-## -->
