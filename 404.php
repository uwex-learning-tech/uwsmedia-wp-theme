<?php get_header(); ?>
<div class="container">
    <div class="row">
    	<main class="col-lg-8 offset-lg-2" role="main">
    		<!-- section -->
    		<section>
    
    			<!-- article -->
    			<article id="post-404">
                    <div class="icon" aria-hidden="true">🤔</div>
                    <h1 class="text-center">Page Not Found</h1>
                    <p class="text-center">The requested page is not found or not available at the moment.</p>
                    <div class="alert alert-light" role="alert">
                        <p>For assistance related to course materials or contents, please submit the form on the Technical Support website at <a href="https://ce.uwex.edu/technical-support" target="_blank">ce.uwex.edu/technical-support</a>, or call <a href="tel:1-877-724-7883">1-877-724-7883</a>.</p>
                        <hr>
                        <p class="mb-0 text-center"><?php
                    if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
                        echo '<a class="btn btn-link" href="' . $_SERVER['HTTP_REFERER'] .'">Go Back?</a>';
                    }
                     ?> <a class="btn btn-link" href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'uwsmedia' ); ?></a></p>
                    </div>
                
    			</article>
    			<!-- /article -->
    
    		</section>
    		<!-- /section -->
    	</main>
    </div>
</div>
<?php wp_footer(); ?>