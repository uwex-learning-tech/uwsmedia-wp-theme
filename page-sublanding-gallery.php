<?php
/**
 * Template Name: Sublanding with Gallery
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

<!-- gallery -->
<div class="container gallery mt-4 mb-4">

<?php

    $galleryString =  get_post_meta( get_the_ID(), 'gallery_content' , true );

    if ( isset($galleryString) && !empty($galleryString) ) {

        $gallery = explode(",", $galleryString);
        $gallery = array_filter(array_map('trim', $gallery));

        if ( count($gallery) > 6 ) {
            $gallery = array_slice($gallery, count( $gallery ) - 6, 6);
        }

    }

?>

    <div class="row mb-4">
        <div class="col-12">
            <div class="current-gallery-item"><img src="<?php echo $gallery[0]; ?>" alt="" /></div>
        </div>
    </div>
    
    <div class="row">

        <?php
            $count = 0;
            foreach($gallery as $key => $value) {
                echo "<div class=\"col-4 col-lg-2 mb-4 mb-lg-0\"><div class=\"gallery-item" . ($count == 0 ? ' active' : '') . "\"><img src=\"" . $gallery[$key] . "\" alt=\"\" /></div></div>";
                $count = $count + 1;
            }
        ?>

    </div>


</div>

<!-- end gallery -->

<main class="container pb-2" role="main">

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