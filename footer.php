<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package UWEX-Media
 */
?>
	</div>
	</div><!-- #content -->

    <?php get_sidebar('footer'); ?>


	<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="container">
    	<div class="row">
		<div id="footertext" class="col-xs-12">
        	<?php
			if ( (function_exists( 'of_get_option' )
			 && (of_get_option('footertext2', true) != 1) ) ) {

			 	echo of_get_option('footertext2', true);

            }
            
            if ( !is_user_logged_in() ) {

                echo ' <a href="' . wp_login_url() . '">Login</a>';

            } else {
                
                
                echo ' <a href="' . wp_logout_url() . '">Logout</a>';
            }

            ?>

        </div>
    	</div>
	</div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>