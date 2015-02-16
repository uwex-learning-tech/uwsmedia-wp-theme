<?php

    add_action( 'init', 'uwex_media_shortcodes' );

    function uwex_media_shortcodes() {

    	add_shortcode( 'media-login-form', 'login_form_shortcode' );

    }

    function login_form_shortcode() {

    	if ( is_user_logged_in() )
    		return 'You are already logged in!';

    	return wp_login_form( array( 'echo' => false ) );
    }

?>