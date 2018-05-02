<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
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
            <header class="header" role="banner">
                
                    <nav class="navbar navbar-expand-lg navbar-light" role="navigation">
                        <div class="container">
                        <!-- logo -->
                        <a class="navbar-brand" href="<?php echo home_url(); ?>">
            				<img class="logo-img" src="<?php echo get_option('site_logo_option'); ?>" alt="<?php bloginfo('name'); ?>" />
                        </a>
                        
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#primaryHeaderNav" aria-controls="primaryHeaderNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
            			
                        <div id="primaryHeaderNav" class="collapse navbar-collapse">
            			<?php uwsmedia_nav(); ?>
                        </div>
                        </div>
                    </nav>
                    
                    <?php if ( is_front_page() ) : ?>
                    
                    <!-- section -->
                	<section class="project-carousel-wrapper">
                    	
                    	<div id="project-carousel" class="carousel slide carousel-fade" data-ride="carousel">
                    	<?php
                        	
                        	$query_args = array(
                                'post_type' => 'uws-projects',
                                'post_status' => 'publish',
                                'meta_query'  => array(
                                    array(
                                        'key' => 'feature_on_home',
                                        'value' => 1
                                    )
                                )
                            );
                            
                            $carousel = new WP_Query( $query_args );
                            
                            if ( $carousel->have_posts() ) {
                                
                                $count = 0;
                        ?>
                            
                                <ol class="carousel-indicators">
                                    
                                    <?php
                                        
                                    for( $idx = 0; $idx < (Int) $carousel->found_posts; $idx++ ) {
                                        
                                        $active = '';
                                        
                                        if ( $idx == 0 ) {
                                            $active = ' class="active"';
                                        }
                                        
                                        echo '<li data-target="#project-carousel" data-slide-to="' . $idx . '"' . $active . '></li>';
                                        
                                    }    
                                    ?>
                                
                                </ol>
                            
                                <div class="carousel-inner h-100">
                                
                                <?php
                                    while( $carousel->have_posts() ) {
                                        
                                        $carousel->the_post();
                                    
                                ?>
                                    <div class="carousel-item<?php  echo $count == 0 ? ' active' : ''; ?>">
                                        <img class="d-block w-100" src="<?php the_post_thumbnail_url( 'full' ); ?>" alt="<?php the_title(); ?>">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5><?php the_title(); ?></h5>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                            <a href="<?php the_permalink(); ?>" class="btn">VIEW</a>
                                        </div>
                                    </div>
                                    
                                <?php        
                                        
                                        $count++;
                                        
                                    } // end while
                                    wp_reset_postdata();
                                ?>
                                    
                                </div>
                                
                                <a class="carousel-control-prev" href="#project-carousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span></a>
                                
                                <a class="carousel-control-next" href="#project-carousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span></a>
                                
                                <?php } // end if  ?>
                    	</div>
                        
                    </section>
                	<!-- /section -->
                
                    <?php endif; ?> <!-- /end is front page -->

            </header>
            
            <?php if ( !is_front_page() ) : ?>
            
            <div class="breadcrumb-nav">
                <div class="container">
                <?php breadcrumb_nav(); ?>
                </div>
            </div> <!-- /header -->

            <?php endif; ?>
			