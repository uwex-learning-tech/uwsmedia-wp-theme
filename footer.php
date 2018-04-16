
			<?php if ( !is_front_page() ) { ?>
			    
			    </div>
			    <!-- /body content container row -->
			</div>
			<!-- /body content container -->
			
			<?php } ?>
			
			<!-- footer -->
			<footer class="footer d-flex align-content-center flex-wrap" role="contentinfo">
                
                <div class="container">
                    
                    <div class="row">
                        
                        <div class="col-1 d-flex align-content-center flex-wrap">
                            <img class="footer-logo" src="<?php echo get_template_directory_uri(); ?>/img/uws_logo.svg" alt="UWEX Media Services" />
                        </div>
                        
                        <div class="col-9 d-flex align-content-center flex-wrap">
                            
                            <!-- copyright -->
            				<p class="copyright">&copy; <?php echo date('Y'); ?>.  <?php bloginfo('name'); ?> and University of Wisconsin Systems Academic Affairs. All rights reserved. No part of this website may be reproduced and or redistributed through any means without written permission.</p>
            				<!-- /copyright -->
                            
                        </div>
                        
                        <div class="col-2 d-flex align-content-center flex-wrap">
                            
                            <?php if ( is_user_logged_in() ) {
                                
                                $currentUser = wp_get_current_user()->user_firstname;
                                
                                if ( empty( $currentUser ) ) {
                                    $currentUser = wp_get_current_user()->user_login;
                                }
                                
                            ?>
                                
                                <p class="user-info">Hi, <?php echo $currentUser; ?>!<br>
                                <?php echo '<a href="' . get_dashboard_url() . '">Dashboard</a>'; ?>
                                &bull; <?php echo '<a href="' . wp_logout_url( home_url() ) . '">Logout</a>'; ?></p>
                                
                            <?php } else { ?>
                                
                                <div class="login-btn">
                                    
                                    <?php echo '<a href="' . wp_login_url() . '">Login</a>'; ?>
                                    
                                </div>
                                
                            <?php } ?>
                            
                        </div>
                        
                    </div>
                    
                </div>

			</footer>
			<!-- /footer -->

		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

	</body>
</html>
