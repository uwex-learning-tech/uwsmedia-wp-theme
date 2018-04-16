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
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        </script>

	</head>
	<body <?php strpos(get_page(get_post_ancestors($post)[0])->post_name, 'faculty') !== false ? body_class('faculty') : body_class(); ?>>

		<!-- wrapper -->
		<div class="wrapper">
            
            <!-- header -->
            <header class="header" role="banner">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light" role="navigation">
                        
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
                        
                    </nav>
                </div>
            </header>
            
            <?php if ( !is_front_page() ) { ?>
            
            <div class="breadcrumb-nav">
                <div class="container">
                <?php breadcrumb_nav(); ?>
                </div>
            </div> <!-- /header -->
            
            <!-- body content container -->
			<div class="container">
                <div class="row">
            
            <?php } ?>
			
			
			
