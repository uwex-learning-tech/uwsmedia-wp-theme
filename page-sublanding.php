<?php
/**
 * Template Name: Sub Landing
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage UWS Media
 * @since 1.0.0
 */
 
 get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="header-banner">
    <div class="container">
        <h1 class="banner-title"><?php
            
            $pageTitle = get_post_meta( get_the_ID(), 'banner_title' , true );
            
            if ( empty( $pageTitle ) ) {
                the_title();
            } else {
                echo $pageTitle;
            }
            
            ?></h1>
        <div class="banner-content"><?php echo html_entity_decode( get_post_meta( get_the_ID(), 'banner_content' , true ) ); ?></div>
        <?php if ( has_post_thumbnail() ) : ?>
        <div class="banner-image"><img src="<?php the_post_thumbnail_url(); ?>" alt=""/></div>
        <?php else: ?>
        <div class="banner-buffer"></div>
        <?php endif; ?>
        <div class="banner-border"></div>
    </div>
</div>

<main class="container" role="main">
    
    <section>
        <h2><?php the_title(); ?></h2>
        <div class="entry-content-page">
            <?php the_content(); ?>
        </div>
        <p class="published-date">Published on <?php echo get_the_date( 'F d, Y' ) . ' at ' . get_the_date( 'g:i:s a T' ); ?>. Last modified on <?php echo get_the_modified_time( 'F d, Y' ) . ' at ' . get_the_modified_time( 'g:i:s a T' ); ?></p>
    </section>
    
<?php
    endwhile;
    wp_reset_query();
?>

</main>

 <?php get_footer(); ?>