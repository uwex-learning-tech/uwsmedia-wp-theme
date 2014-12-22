<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package UWEX-Media
 */

get_header(); ?>

	<div id="primary" class="full-width content-area col-md-12">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Oops! This is awkward.', 'uwex-media' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p><?php _e( 'You are looking for something that does not actually exist...', 'uwex-media' ); ?></p>

				</div><!-- .entry-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php /* get_sidebar('footer'); */ ?>
<?php get_footer(); ?>