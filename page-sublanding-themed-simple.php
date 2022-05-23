<?php
/**
 * Template Name: Simple Themed Sub Landing
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage UWS Media
 * @since 1.0.0
 */
 
 get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="header-banner simple-themed">
    <div class="container">
        <h1 class="banner-title"><?php the_title(); ?></h1>
        <div class="banner-content">
            <?php echo html_entity_decode( get_post_meta( get_the_ID(), 'banner_content' , true ) ); ?></div>

        <div class="banner-search">
            <input type="hidden" name="postGroupId"
                value="<?php echo get_post_meta( get_the_ID(), 'post_group_id' , true ) ?>" />
            <input type="hidden" name="bloginfo" value="<?php echo get_bloginfo( 'url' ); ?>" />
            <form class="row d-flex justify-content-center" role="search" method="get"
                action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="col-12 col-sm-12 col-md-6 autocomplete-search-wrapper">
                <div class="input-group">
                <input type="text" name="s" id="autoComplete" class="form-control autocomplete-search"
                        placeholder="Search" autocomplete="off">
                    <!-- <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2"> -->
                    <!-- <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button> -->
                    <button type="submit" class="search-btn"><span class="fa fa-search" aria-hidden="true"></span><span
                            class="screen-reader-text">What can we help with?</span></button>
                </div>
                </div>
                <!-- <div class="col-12 col-sm-12 col-md-6 autocomplete-search-wrapper">

            
                    <input type="text" name="s" id="autoComplete" class="form-control autocomplete-search w-100"
                        placeholder="Search" autocomplete="off">

                    <button type="submit" class="search-btn"><span class="fa fa-search" aria-hidden="true"></span><span
                            class="screen-reader-text">Search</span></button>
                </div> -->
            </form>

        </div>

    </div>

    <?php if ( has_post_thumbnail() ) : ?>
    <div class="banner-image"><img src="<?php the_post_thumbnail_url(); ?>" alt="" /></div>
    <?php else: ?>
    <div class="banner-buffer"></div>
    <?php endif; ?>
    <div class="banner-border"></div>
</div>
</div>

<main class="container" role="main">

    <section>
        <div class="entry-content-page">
            <?php the_content(); ?>
        </div>
        <p class="published-date">Published on
            <?php echo get_the_date( 'F d, Y' ) . ' at ' . get_the_date( 'g:i:s a T' ); ?>. Last modified on
            <?php echo get_the_modified_time( 'F d, Y' ) . ' at ' . get_the_modified_time( 'g:i:s a T' ); ?></p>
    </section>

    <?php
    endwhile;
    wp_reset_query();
?>

</main>

<?php get_footer(); ?>