<?php
/**
 * Template Name: Sub Landing
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage UWS Media
 * @since 2.0.0
 */
 
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<div class="header-banner">

    <div class="container">

        <h1 class="banner-title"><?php the_title(); ?></h1>

        <div class="banner-content">
            <?php
            echo html_entity_decode( get_post_meta( get_the_ID(), 'banner_content' , true ) );
            ?>
        </div>

    </div>

</div>

<main class="container p-4" role="main">

    <section>

        <?php if ( has_post_thumbnail() ) : ?>
        <img src="<?php the_post_thumbnail_url(); ?>" alt="" />
        <?php endif; ?>

        <div class="entry-content-page">
            <?php the_content(); ?>
        </div>

    </section>

</main>
<?php
    endwhile;
    wp_reset_query();
?>

<?php get_footer(); ?>