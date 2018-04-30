<?php get_header(); ?>
    
<div class="container">
    
        <div class="row">    
    
	<main class="col-12" role="main">
		<!-- section -->
		<section id="projects-archive">

			<h1><?php _e( 'Archives', 'uwsmedia' ); ?></h1>
            
            <div class="row d-flex flex-row">
			<?php get_template_part('loop'); ?>
            </div> <!-- end grids -->
            
			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

    </div>
    
</div>

<?php get_footer(); ?>
