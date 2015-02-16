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
					<h1 class="entry-title"><?php _e( 'Error 404 - Page Not Found', 'uwex-media' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">

                    <p class="lead"><?php _e( 'The requested page is not found or not available at the moment. Please double check the URL and try again.', 'uwex-media' ); ?></p>

                    <div class="alert alert-info">
                        <?php _e( 'For assistance related to course materials or contents, please contact Technical Support at <a href="mailto:techsupport@uwex.edu">techsupport@uwex.edu</a> or 1-877-724-7883.', 'uwex-media' ); ?>
                    </div>

				</div><!-- .entry-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php /* get_sidebar('footer'); */ ?>
<?php /* get_footer(); */ ?>