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
        
            <div class="banner-search">
                <input type="hidden" name="postId" value="<?php echo $post->ID; ?>" />
                <input type="hidden" name="bloginfo" value="<?php echo get_bloginfo( 'url' ); ?>" />
                <form class="row d-flex justify-content-center" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    
                    <div class="col-12 col-sm-12 col-md-6">
                    <input type="text" name="s" class="form-control autocomplete-search w-100" placeholder="Search">
                        
                    <button type="submit" class="search-btn"><span class="fa fa-search" aria-hidden="true"></span><span class="screen-reader-text">Search</span></button>
                </div>
                </form>
                
            </div>
        
        </div>
        
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