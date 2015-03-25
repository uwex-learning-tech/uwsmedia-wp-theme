<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package UWEX-Media
 */

get_header(); ?>

	<div id="primary" class="content-area col-md-8">
		<main id="main" class="site-main" role="main">

            <?php

                if ( !is_front_page() ) {

                    if ( function_exists(simple_breadcrumb) ) {

                        simple_breadcrumb();

                    }

                }


            ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

    /* Get the current user object. */
	$current_user = wp_get_current_user();

	/* Get the roles selected by the user. */
    $roles = get_post_meta( get_the_ID(), '_members_access_role', false );

    // if the roles are not empty,
    // loop through each permitted role and see if user can view
    if ( !empty( $roles ) ) {

        foreach ( $roles as $role ) {

    		if ( user_can( $current_user->ID, $role ) )
    			$can_view = true;

    	}

    }

    if ( empty( $role ) ) {

        $can_view = true;

    }

    // if user can view, get the side bar
    if ( $can_view ) {

        get_sidebar();

    }

?>
<?php get_footer(); ?>
