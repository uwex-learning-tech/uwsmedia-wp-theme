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

    <div id="front-page-banner">

        <!-- featured image if any -->
        <?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
        <div class="featured-image">
            <?php the_post_thumbnail(); ?>
        </div>
        <?php endif; ?>
        <!-- /featured image -->

        <div class="banner-content-box d-flex flex-column align-items-center justify-content-center">
            <div class="container">
                <h1 class="banner-title">
                    <?php $pageTitle = get_post_meta( get_the_ID(), 'homepage_banner_title' , true );
            
                if ( !empty( $pageTitle ) ) {
                    echo $pageTitle;
                }
                
                ?>
                </h1>
                <div class="banner-content">
                    <?php echo wpautop( get_post_meta( get_the_ID(), 'homepage_banner_content' , true ) ); ?>
                </div>
            </div>
        </div>


    </div>

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