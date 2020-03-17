<?php
/**
 * Template Name: Keep Teaching
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage UWS Media
 * @since 1.0.0
 */
 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php echo is_404() ? ' error404' : '';?>" style="margin-top: 0 !important;">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ''; } ?></title>

    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php wp_head(); ?>

</head>
<body style="margin-bottom: 0 !important" class="keep-teaching">
    
    <header>
        <nav class="navbar navbar-dark" style="background-color: #990033;">
            <div class="container">
                <a class="navbar-brand" href="https://media.uwex.edu/keepteaching/"><img src="https://media.uwex.edu/app/tools/uwex-branding-utilities/images/uwex_logo_v2.png" width="auto" height="30px" class="d-inline-block align-top mr-3" alt="University of Wisconsin Extended Campus">
                    <strong>Keep Teaching</strong></a>
            </div>
        </nav>
    </header>
    
    <div class="container">
    
        <div class="row">
            
            <main class="col-12 col-sm-12 col-md-8" role="main">
        		
        		<section>
                    
                    <h1 class="display-4"><?php the_title(); ?></h1>
                    
                    <!-- post thumbnail -->
            		<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
            		<div class="page-featured-image">
            			<?php the_post_thumbnail(); ?>
                    </div>
            		<?php endif; ?>
            		<!-- /post thumbnail -->
        
                    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
        
        			<!-- article -->
        			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        
        				<?php the_content(); ?>
        				<?php edit_post_link( __( 'Edit', 'uwsmedia' ), '<p>', '</p>', null ); ?>
        
        				<?php
                        	if ( !is_front_page() ) {
                    
                        	    echo '<p class="published-date">';
                            	echo 'Published on ' . get_the_date( 'F d, Y' ) . ' at ' . get_the_date( 'g:i:s a T' ) . '. ';
                            	echo 'Last modified on ' . get_the_modified_time( 'F d, Y' ) . ' at ' . get_the_modified_time( 'g:i:s a T' ) . '.';
                            	echo '</p>';
                    
                        	}
                        ?>
        
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
        		
        	</main>
        	
        	<?php
        
                if ( !is_front_page() ) :
                    
                    get_sidebar();
                    
                endif;
                
            ?>
    
        </div>
        
    </div>
    
    <footer class="mt-3">
        <p class="text-muted text-center"><small>&copy; 2020 Board of Regents and University of Wisconsin System. All rights reserved.</small></p>
    </footer>
    
</body>
</html>
