<!doctype html>
<html <?php language_attributes(); ?> class="no-js<?php echo is_404() ? ' error404' : '';?>">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>

	</head>
	
	<body <?php !is_front_page() ? body_class( get_post( get_post_meta($post->ID, 'post_group_id', true ) )->post_name . '-group' ) : body_class(); ?>>
        
		<!-- wrapper -->
		<div class="wrapper">
            
            <!-- header -->
            <header class="header">
                
                    <nav class="navbar navbar-expand-lg navbar-light" role="navigation">
                        <div class="container">
                            
                            <!-- logo -->
                            <a class="navbar-brand" href="<?php echo home_url(); ?>">
                				<img class="logo-img" src="<?php echo get_option('site_logo_option'); ?>" alt="<?php bloginfo('name'); ?>" />
                            </a>
                            
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryHeaderNav" aria-controls="primaryHeaderNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                			
                            <div id="primaryHeaderNav" class="collapse navbar-collapse mt-3 mt-lg-0">
                			<?php uwsmedia_nav(); ?>
                            </div>
                        </div>
                    </nav>

                    <?php if ( is_front_page() ) : ?>
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
                    <?php endif; ?>
            </header>
            
            <?php if ( !is_front_page() ) : ?>
            <?php if ( !is_404() ) : ?>
            
            <div class="breadcrumb-nav d-flex align-items-center">
                <div class="container">
                <?php breadcrumb_nav(); ?>
                </div>
            </div> <!-- /header -->
            
            <?php endif; ?>
            <?php endif; ?>
			