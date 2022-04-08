<?php

/**
 * Template Name: Homepage
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage UWS Media
 * @since 2.0.0
 */

 get_header(); ?>
<main role="main">

    

    <section>

        <?php if (have_posts()): while (have_posts()) : the_post(); ?>

        <!-- article -->
        <article id="post-<?php the_ID(); ?>" <?php post_class("container"); ?>>

            <?php the_content(); ?>

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

    <?php get_template_part( 'carousel' ); ?>

</main>

<?php get_footer(); ?>