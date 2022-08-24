<!-- sidebar -->
<aside class="col-12 col-sm-12 col-md-4 sidebar order-1 order-md-2" role="complementary">
    
    <?php
        
        $permission = get_post_meta( get_the_ID(), '_members_access_role' );
        
        if ( empty( $permission ) ) : ?>
        
	<div class="sidebar-widget sticky-top">
    	
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('uwsmedia-sidebar')) ?>
	</div>
	
	<?php else:
    	
    	    if ( is_user_logged_in() ) : ?>
	
	<div class="sidebar-widget sticky-top">
    	
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('uwsmedia-sidebar')) ?>
	</div>
	
	<?php 
            endif;
    	    
    	endif;
    ?>

</aside>
<!-- /sidebar -->
