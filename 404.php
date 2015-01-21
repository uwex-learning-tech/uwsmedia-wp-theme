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
					<h1 class="entry-title"><?php _e( '404 - Page Not Found.', 'uwex-media' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">

                    <p class="lead"><?php _e( 'The page is not found or not available at the moment. Please double check the URL and try again.', 'uwex-media' ); ?></p>

					<div class="panel panel-danger">
    					<div class="panel-heading"><?php _e( 'Server Maintenance In Progress!', 'uwex-media' ); ?></div>
    					<div class="panel-body">
    					    <p><?php _e( 'As of January 2nd, 2015, the server is under live maintenance. If you are getting the "404 - page not found" error message, please double check the URL, change the URL to lowercase if applicable, or try again later. If you need immediate assistance, please contact Technical Support at <a href="mailto:techsupport@uwex.edu">techsupport@uwex.edu</a> or 1-877-724-7883.', 'uwex-media' ); ?></p>
    					    <p><?php _e( 'We apologize for any inconveniences. Thank you!', 'uwex-media' ); ?></p>
    					</div>
    				</div>

				</div><!-- .entry-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php /* get_sidebar('footer'); */ ?>
<?php /* get_footer(); */ ?>