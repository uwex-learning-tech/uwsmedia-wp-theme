<?php get_header(); ?>
<main role="main">

    <section id="front-page-banner">

        <!-- featured image if any -->
        <?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
        <div class="featured-image">
            <?php the_post_thumbnail(); ?>
        </div>
        <div class="gradient-overlay"></div>
        <?php endif; ?>
        <!-- /featured image -->

    </section>

    <section class="container">

        <?php if (have_posts()): while (have_posts()) : the_post(); ?>

        <!-- article -->
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

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

</main>

<?php get_footer(); ?>