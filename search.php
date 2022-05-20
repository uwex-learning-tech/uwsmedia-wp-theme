<?php get_header(); ?>
    
<main class="container" role="main">
    
    <?php
        
        if ( $_GET['post_type'] == 'uws-projects' || $_GET['post_type'] == 'uws-flex-projects' ) :
        
            get_template_part('loop-showcase-results');

        else:
        
            get_template_part('loop');
        
        endif;
        
    ?>
    
</main>

<?php get_footer(); ?>
