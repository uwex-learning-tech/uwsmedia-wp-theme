<?php
/*
 * Template Name: Keep Teaching
 * Template Post Type: post
 */
 ?>
 <!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php echo is_404() ? ' error404' : '';?>" style="margin-top: 0 !important;">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' - Keep Teaching'; } ?></title>

    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
    <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php wp_head(); ?>

</head>
<body style="margin-bottom: 0 !important">
    
    <header>
        <nav class="navbar navbar-dark" style="background-color: #990033;">
            <div class="container">
                <a class="navbar-brand" href="."><img src="https://media.uwex.edu/app/tools/uwex-branding-utilities/images/uwex_logo_v2.png" width="auto" height="30px" class="d-inline-block align-top mr-3" alt="University of Wisconsin Extended Campus">
                    <strong>Keep Teaching</strong></a>
            </div>
        </nav>
    </header>
    
    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <!-- post thumbnail -->
	<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
	<div class="post-featured-image">
		<?php the_post_thumbnail(); ?>
    </div>
	<?php endif; ?>
	<!-- /post thumbnail -->
	
    <div class="container">
        
        <div class="row">
            
            <main class="col-12" role="main">
                
                <!-- section -->
                <section>

                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <!-- post title -->
                        <h1><?php the_title(); ?></h1>
                        <!-- /post title -->
        
                        <p class="date text-muted mb-0"><small>
                        <?php
                            
                            the_time('F j, Y');

                            if ( strcmp( get_the_time( 'F j, Y' ), get_the_modified_date( 'F j, Y' ) ) !== 0 ) {
                                
                                echo ' | Updated on ' . get_the_modified_date( 'F j, Y' );
                                
                            }
                            
                        ?></small></p>
                        
                        <?php the_content(); // Dynamic Content ?>
                        
                        <?php edit_post_link( __( 'Edit', 'uwsmedia' ), '<p>', '</p>', null ); ?>
                    
                    </article>
                    <!-- /article -->
                    
                    <?php endwhile; ?>
                    
                    <?php else: ?>
                    
                    <!-- article -->
                    <article>
                    
                    <h1><?php _e( 'Sorry, nothing to display.', 'uwsmedia' ); ?></h1>
                    
                    </article>
                    <!-- /article -->
                    
                    <?php endif; ?>
                
                </section>
                <!-- /section -->
            </main>
			    
        </div>
        
	</div>
	<!-- /body content container -->
	
	<footer class="mt-3">
        <p class="text-muted text-center"><small>&copy; 2020 Board of Regents and University of Wisconsin System. All rights reserved.</small></p>
    </footer>
    
</body>
</html>

