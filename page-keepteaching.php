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
	<title>UWEX - <?php wp_title(''); ?><?php if(wp_title('', false)) { echo ''; } ?></title>

    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php wp_head(); ?>

</head>
<body style="margin-bottom: 0 !important" class="keep-teaching" data-spy="scroll">
    
    <header>
        
        <div class="navbar navbar-dark" style="background-color: #990033;">
            <div class="container">
                <a class="navbar-brand" href="https://media.uwex.edu/keepteaching/"><img src="https://media.uwex.edu/app/tools/uwex-branding-utilities/images/uwex_logo_v2.png" width="auto" height="30px" class="d-inline-block align-top mr-3" alt="University of Wisconsin Extended Campus"></a>
            </div>
        </div>
        
        <div class="banner-container d-flex justify-content-center">
             <!-- post thumbnail -->
                <?php if ( has_post_thumbnail() ) : // Check if Thumbnail exists ?>
                <div class="page-featured-image">
                <?php the_post_thumbnail(); ?>
                </div>
                
                <div class="container page-title-container d-flex flex-row align-items-center">
                     <h1 class="display-4 page-title"><?php the_title(); ?>
                     <span class="subline">COVID-19 RESOURCE</span></h1>
                     
                 </div>
    		<!-- /post thumbnail -->
    		<?php endif; ?>
    		
        </div>
        
        <?php if ( has_post_thumbnail() ) : ?>
        <nav class="navbar navbar-expand-lg navbar-dark primary-nav zindex-fix" style="background-color: #444444;">
            <div class="container">
                <button class="navbar-toggler ml-auto collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse mr-auto" id="navbarSupportedContent">
                    <?php
                    keepteaching_nav();
                    ?>
                </div>
            </div>
        </nav>
        <?php endif; ?>
		
		
    </header>
    
    <div class="container mt-3 kt-main-body">
    
        <div class="row flex-md-row flex-column-reverse">
            
            <main class="col-12 col-sm-12 col-md-8 mt-3" role="main">
        		
        		<section>
                    
                    <?php if ( !has_post_thumbnail() ) : ?>
                     <h1 class="display-4 pt-0"><?php the_title(); ?></h1>
                    <?php endif; ?>
                    
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
        <div class="container">
            <p class="text-muted"><small>&copy; 2020 Board of Regents and University of Wisconsin System. All rights reserved.</small></p>
        </div>
    </footer>
    
</body>
</html>
