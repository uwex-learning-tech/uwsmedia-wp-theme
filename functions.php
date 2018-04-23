<?php
/*
 *  Author: Ethan Lin
 *  URL: media.uwex.edu
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if ( !isset( $content_width ) ) {
    
    $content_width = 900;
    
}

if ( function_exists( 'add_theme_support' ) ) {
    
    // Add Menu Support
    add_theme_support( 'menus' );

    // Add Thumbnail Theme Support
    add_theme_support( 'post-thumbnails');
    add_image_size( 'large', 700, '', true );
    add_image_size( 'medium', 250, '', true );
    add_image_size( 'small', 120, '', true );
    add_image_size( 'custom-size', 700, 200, true );

    // Enables post and comment RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Localisation Support
    load_theme_textdomain( 'uwsmedia', get_template_directory() . '/languages' );
    
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// uwsmedia navigation
function uwsmedia_nav() {
    
	wp_nav_menu(
    	array(
    		'theme_location'  => 'header-menu',
    		'menu'            => '',
    		'container'       => 'div',
    		'container_class' => 'menu-{menu slug}-container',
    		'container_id'    => '',
    		'menu_class'      => 'navbar-nav ml-auto',
    		'menu_id'         => '',
    		'echo'            => true,
    		'fallback_cb'     => 'wp_page_menu',
    		'before'          => '',
    		'after'           => '',
    		'link_before'     => '',
    		'link_after'      => '',
    		'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
    		'depth'           => 0,
    		'walker'          => new Bootstrap_Nav_Walker()
        )
	);
	
}

// Load uwsmedia scripts (header.php)
function uwsmedia_header_scripts() {
    
    if ( $GLOBALS['pagenow'] != 'wp-login.php' && !is_admin() ) {
        
        // Modernizr
        wp_register_script( 'modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1' ); 
        wp_enqueue_script( 'modernizr' );
        
        // Bootstrap
        wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/lib/bootstrap.min.js', array( 'jquery' ), '4.0.0' ); 
        wp_enqueue_script( 'bootstrap' );
        
        // UWS Media scripts
        wp_register_script( 'uwsmediascripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '1.0.0' ); 
        wp_enqueue_script( 'uwsmediascripts' );
        
    }
    
}

// Load uwsmedia styles
function uwsmedia_styles() {
    
    // Bootstrap
    wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.0.0', 'all' );
    wp_enqueue_style( 'bootstrap' );
    
    // Dashicons
    wp_enqueue_style( 'dashicons' );
    
    // UWS Media CSS
    wp_register_style( 'uwsmedia', get_template_directory_uri() . '/style.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'uwsmedia' );
    
}

// Register uwsmedia Navigation
function register_uwsmedia_menu() {
    
    // Using array to specify more menus if needed
    register_nav_menus( array( 
        'header-menu' => __( 'Header Menu', 'uwsmedia' ), // Main Navigation
    ) );
    
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args( $args = '' ) {
    
    $args['container'] = false;
    return $args;
    
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter( $var ) {
    
    return is_array( $var ) ? array() : '';
    
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list( $thelist ) {
    
    return str_replace( 'rel="category tag"', 'rel="tag"', $thelist );
    
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class( $classes ) {
    
    global $post;
    
    if ( is_home() ) {
        
        $key = array_search( 'blog', $classes );
        
        if ( $key > -1 ) {
            
            unset( $classes[$key] );
            
        }
        
    } elseif ( is_page() ) {
        
        $classes[] = sanitize_html_class( $post->post_name );
        
    } elseif ( is_singular() ) {
        
        $classes[] = sanitize_html_class( $post->post_name );
        
    }
    
    return $classes;
    
}

// If Dynamic Sidebar Exists
if ( function_exists( 'register_sidebar' ) ) {
    
    // Define Sidebar Widget Area 1
    register_sidebar( array(
        'name'          => __( 'Widget Area 1', 'uwsmedia' ),
        'description'   => __( 'Description for this widget-area...', 'uwsmedia' ),
        'id'            => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ) );
    
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style() {
    
    global $wp_widget_factory;
    
    remove_action( 'wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ) );
    
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function uwsmediawp_pagination() {
    
    global $wp_query;
    $big = 999999999;
    
    echo paginate_links(array(
        'base'    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
        'format'  => '?paged=%#%',
        'current' => max( 1, get_query_var( 'paged' ) ),
        'total'   => $wp_query->max_num_pages
    ) );
    
}

// Custom Excerpts - Create 20 Word Callback for Index page Excerpts, call using uwsmediawp_excerpt('uwsmediawp_index');
function uwsmediawp_index( $length )  {
    
    return 20;
    
}

// Create 40 Word Callback for Custom Post Excerpts, call using uwsmediawp_excerpt('uwsmediawp_custom_post');
function uwsmediawp_custom_post( $length ) {
    
    return 40;
    
}

// Create the Custom Excerpts callback
function uwsmediawp_excerpt( $length_callback = '', $more_callback = '' ) {
    
    global $post;
    
    if ( function_exists( $length_callback ) ) {
        
        add_filter( 'excerpt_length', $length_callback );
        
    }
    
    if ( function_exists( $more_callback ) ) {
        
        add_filter( 'excerpt_more', $more_callback );
        
    }
    
    $output = get_the_excerpt();
    $output = apply_filters( 'wptexturize', $output );
    $output = apply_filters( 'convert_chars', $output );
    $output = '<p>' . $output . '</p>';
    
    echo $output;
    
}

// Custom View Article link to Post
function uwsmedia_view_article($more) {
    
    global $post;
    return '... <a class="view-article" href="' . get_permalink( $post->ID ) . '">' . __( 'View Article', 'uwsmedia' ) . '</a>';
    
}

// Remove 'text/css' from our enqueued stylesheet
function uwsmedia_style_remove( $tag ) {
    
    return preg_replace( '~\s+type=["\'][^"\']++["\']~', '', $tag );
    
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html ) {
    
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
    
}

// Custom Gravatar in Settings > Discussion
function uwsmediagravatar ( $avatar_defaults ) {
    
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    
    return $avatar_defaults;
    
}

// Threaded Comments
function enable_threaded_comments() {
    
    if ( !is_admin() ) {
        
        if ( is_singular() AND comments_open()
        AND ( get_option( 'thread_comments' ) == 1 ) ) {
               
            wp_enqueue_script('comment-reply');
            
        }
        
    }
    
}

// Custom Comments Callback
function uwsmediacomments( $comment, $args, $depth ) {
    
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );

	if ( 'div' == $args['style'] ) {
    	
		$tag = 'div';
		$add_below = 'comment';
		
	} else {
    	
		$tag = 'li';
		$add_below = 'div-comment';
		
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ) ?>
	</div>
<?php if ( $comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __( '%1$s at %2$s' ), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link( __( '(Edit)' ),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	UWS Theme Settings Page
\*------------------------------------*/

function uwsmedia_admin_theme_settings() {
    
    add_theme_page( 'UWS Media Settings', 'UWS Media Settings', 'edit_theme_options', 'uwsmedia-theme-settings', 'uwsmedia_theme_settings_page' );
    
}

function uwsmedia_theme_settings_page() { ?>
<div class="wrap">
<h1>UWS Media Theme Settings</h1>
<form method="post" action="options.php">
<?php
    settings_fields( 'uwsmedia-theme-options-grp' );
    do_settings_sections( 'uwsmedia_theme_settings' );
    submit_button();
?>
</form>
</div>
<?php
}

function homepage_section_description() {
    
    echo '<p>Specify the sections on the homepage including its text, buttons, and background.</p>';
    
}

function Site_section_description() {

    echo '<p>General settings that will be applied to all pages.</p>';
    
}

function homepage_options_callback() {
    
    $sections = get_option( 'homepage_sections_option' );
    
    if ( empty( $sections ) ) {
        
         $sectionHtmls = '<div id="homepage-sections"><div class="section"><div class="image-preview-wrapper"><img class="image-preview" id="section-one-preview" src="" /></div><input type="url" id="section-one-url" class="regular-text code uwsimgurl" value="" /><input id="section-one-img" data-rel="section-one-url" data-preview="section-one-preview" type="button" class="button" value="Select" /><br /><input type="text" class="regular-text uwstitle" value="" placeholder="Title" /><textarea class="large-text uwstextarea" placeholder="Description..." rows="10"></textarea><input type="text" class="regular-text uwsbtn" value="" placeholder="Button 1 Name" /><input type="text" class="regular-text uwsbtnlink" value="" placeholder="Button 1 Link" /><input type="text" class="regular-text uwsbtn" value="" placeholder="Button 2 Name" /><input type="text" class="regular-text uwsbtnlink" value="" placeholder="Button 2 Link" /><br /><label><input name="section-one-accent" type="radio" checked="checked" value="light" />Light</label> <input name="section-one-accent" type="radio" checked="checked" value="gray" />Gray</label> <label><input name="section-one-accent" type="radio" value="dark" />Dark</label><p class="description">Choose a color accent for this section.</p></div><div class="section"><div class="image-preview-wrapper"><img class="image-preview" id="section-two-preview" src="" /></div><input type="url" id="section-two-url" class="regular-text code uwsimgurl" value="" /><input id="section-two-img" data-rel="section-two-url" data-preview="section-two-preview" type="button" class="button" value="Select" /><br /><input type="text" class="regular-text uwstitle" value="" placeholder="Title" /><textarea class="large-text uwstextarea" placeholder="Description..." rows="10"></textarea><input type="text" class="regular-text uwsbtn" value="" placeholder="Button 1 Name" /><input type="text" class="regular-text uwsbtnlink" value="" placeholder="Button 1 Link" /><input type="text" class="regular-text uwsbtn" value="" placeholder="Button 2 Name" /><input type="text" class="regular-text uwsbtnlink" value="" placeholder="Button 2 Link" /><br /><label><input name="section-two-accent" type="radio" checked="checked" value="light" />Light</label> <input name="section-two-accent" type="radio" checked="checked" value="gray" />Gray</label> <label><input name="section-two-accent" type="radio" value="dark" />Dark</label><p class="description">Choose a color accent for this section.</p></div><div class="section"><div class="image-preview-wrapper"><img class="image-preview" id="section-three-preview" src="" /></div><input type="url" id="section-three-url" class="regular-text code uwsimgurl" value="" /><input id="section-three-img" data-rel="section-three-url" data-preview="section-three-preview" type="button" class="button" value="Select" /><br /><input type="text" class="regular-text uwstitle" value="" placeholder="Title" /><textarea class="large-text uwstextarea" placeholder="Description..." rows="10"></textarea><input type="text" class="regular-text uwsbtn" value="" placeholder="Button 1 Name" /><input type="text" class="regular-text uwsbtnlink" value="" placeholder="Button 1 Link" /><input type="text" class="regular-text uwsbtn" value="" placeholder="Button 2 Name" /><input type="text" class="regular-text uwsbtnlink" value="" placeholder="Button 2 Link" /><br /><label><input name="section-three-accent" type="radio" checked="checked" value="light" />Light</label> <input name="section-three-accent" type="radio" checked="checked" value="gray" />Gray</label> <label><input name="section-three-accent" type="radio" value="dark" />Dark</label><p class="description">Choose a color accent for this section.</p></div><input class="button" id="save-section-button" type="button" value="Save Sections" /><p class="description">Do not forget to <strong>Save Sections</strong> first!</p></div>';
         
    } else {
        
        $sectionsArray = json_decode( $sections );
        $sectionsIds = ['section-one-url', 'section-two-url', 'section-three-url'];
        $sectionsPreviews = ['section-one-preview', 'section-two-preview', 'section-three-preview'];
        $sectionsAccest = ['section-one-accent', 'section-two-accent', 'section-three-accent'];
        $count = 0;
        $buttonCount = 0;
        
        $sectionHtmls = '<div id="homepage-sections">';
        
        foreach ( $sectionsArray as $value ) {
            
            $sectionHtmls .= '<div class="section">';
            
            $sectionHtmls .= '<div class="image-preview-wrapper"><img class="image-preview" id="'.$sectionsPreviews[$count].'" src="' . $value->{'img'} . '" /></div>';
            
            $sectionHtmls .= '<input type="url" id="' . $sectionsIds[$count] . '" class="regular-text code uwsimgurl" value="' . $value->{'img'} . '" /><input id="section-one-img" data-rel="' . $sectionsIds[$count] . '" data-preview="'.$sectionsPreviews[$count] . '" type="button" class="button" value="Select" /><br /><input type="text" class="regular-text uwstitle" value="' . $value->{'title'} . '" placeholder="Title" /><textarea class="large-text uwstextarea" placeholder="Section description..." rows="10">'. $value->{'text'} . '</textarea>';
            
            foreach ( $value->{'buttons'} as $button ) {
                
                $sectionHtmls .= '<input type="text" class="regular-text uwsbtn" value="'.$button->{'name'}.'" placeholder="Button Name" /><input type="text" class="regular-text uwsbtnlink" value="'.$button->{'link'}.'" placeholder="Button Link" />';
                
                if ( $buttonCount != count( $value ) ) {
                    
                    $sectionHtmls .= '<br />';
                    $buttonCount += 1;
                    
                } else {
                    
                    $buttonCount = 0;
                    
                }
                
            }

            $sectionHtmls .= '<br /><label><input name="' . $sectionsAccest[$count] . '" type="radio" ' . ( $value->{'accent'} == 'light' ? 'checked="checked"' : '' ) . ' value="light" />Light</label> <label><input name="'.$sectionsAccest[$count].'" type="radio" ' . ( $value->{'accent'} == 'gray' ? 'checked="checked"' : '' ) . ' value="gray" />Gray</label> <label><input name="' . $sectionsAccest[$count] . '" type="radio" ' . ( $value->{'accent'} == 'dark' ? 'checked="checked"' : '' ) . ' value="dark" />Dark</label><p class="description">Choose a color accent for this section.</p>';
            
            $sectionHtmls .= '</div>';
            
            $count += 1;
            
        }
        
        $sectionHtmls .= '<input class="button" id="save-section-button" type="button" value="Save Sections" /><p class="description">Do not forget to <strong>Save Sections</strong> first!</p></div>';

    }
    
    $hiddenInput = '<input name="homepage_sections_option" id="homepage_sections_option" type="hidden" value="" />';

    echo $sectionHtmls . $hiddenInput;
    
}

function copyright_options_callback() {
    
    $copyright = get_option( 'copyright_option' );
    
    echo '<textarea name="copyright_option" id="copyright_option" class="large-text">'.$copyright.'</textarea>';
    
}

function footer_logo_options_callback() {
    
    $logo = get_option( 'footer_logo_option' );
    
    $imgPreview = '<div class="image-preview-wrapper"><img class="image-preview" id="footer-logo-preview" src="' . $logo . '" /></div>';
    $imgTxtField = '<input name="footer_logo_option" id="footer_logo_option" type="url" class="regular-text code" value="' . $logo .'" />';
    $imgUploadBtn = '<input id="upload_footer_logo_button" data-rel="footer_logo_option" data-preview="footer-logo-preview" type="button" class="button" value="Select" />';
    
    echo $imgPreview . $imgTxtField . $imgUploadBtn;
    
}

function site_logo_options_callback() {
    
    $logo = get_option( 'site_logo_option' );
    
    $imgPreview = '<div class="image-preview-wrapper"><img class="image-preview" id="site-logo-preview" src="' . $logo . '" /></div>';
    $imgTxtField = '<input name="site_logo_option" id="site_logo_option" type="url" class="regular-text code" value="' . $logo . '" />';
    $imgUploadBtn = '<input id="upload_site_logo_button" data-rel="site_logo_option" data-preview="site-logo-preview" type="button" class="button" value="Select" />';
    
    echo $imgPreview . $imgTxtField . $imgUploadBtn;
    
}

function uwsmedia_theme_settings(){
    
    wp_enqueue_media();
    
    // Site
    
    add_option( 'site_logo_option', get_template_directory_uri() . '/img/uwex_logo.svg');
    add_option( 'footer_logo_option', get_template_directory_uri() . '/img/uws_logo.svg');
    add_option( 'copyright_option', 'UWEX and University of Wisconsin Systems Academic Affairs. All rights reserved. No part of this website may be reproduced and or redistributed through any means without written permission.' );
    
    add_settings_section( 'site_section', 'Site', 'site_section_description', 'uwsmedia_theme_settings' );
    add_settings_field( 'site_logo_option', 'Site Logo', 'site_logo_options_callback', 'uwsmedia_theme_settings', 'site_section' );
    add_settings_field( 'footer_logo_option', 'Footer Logo', 'footer_logo_options_callback', 'uwsmedia_theme_settings', 'site_section' );
    add_settings_field( 'copyright_option', 'Copyright', 'copyright_options_callback', 'uwsmedia_theme_settings', 'site_section' );
    
    // homepage
    
    add_option( 'homepage_sections_option', '' );
    
    add_settings_section( 'homepage_section', 'Home Page', 'homepage_section_description', 'uwsmedia_theme_settings' );
    add_settings_field( 'homepage_sections_option', 'Sections', 'homepage_options_callback', 'uwsmedia_theme_settings', 'homepage_section' );
    
    // Register all settings
    register_setting( 'uwsmedia-theme-options-grp', 'homepage_sections_option' );
    register_setting( 'uwsmedia-theme-options-grp', 'site_logo_option' );
    register_setting( 'uwsmedia-theme-options-grp', 'footer_logo_option' );
    register_setting( 'uwsmedia-theme-options-grp', 'copyright_option' );
    
}

function uwsmedia_admin_scripts() {
    
    wp_register_script( 'uwsmedia_admin_script', get_template_directory_uri() . '/js/admin.js', array('jquery'), '1.0.0' );
    wp_enqueue_script('uwsmedia_admin_script');
    
    wp_register_style( 'uwsmedia_admin_css', get_template_directory_uri() . '/css/admin.css', array(), '1.0.0', 'all' );
    wp_enqueue_style( 'uwsmedia_admin_css' );

}

/*------------------------------------*\
	UWS Theme SVG MIME SUPPORT
\*------------------------------------*/

function cc_mime_types( $mimes ) {
    
     $mimes['svg'] = 'image/svg+xml';
     return $mimes;
     
}

/*------------------------------------------*\
	REORDRING ADMIN MENU + ADMIN BAR MENU
\*------------------------------------------*/

function reorder_admin_menu( $__return_true ) {
    return array(
         'index.php', // Dashboard
         'edit.php?post_type=page', // Pages 
         'edit.php?post_type=uws-projects', // Showcase Projects
         'upload.php', // Media
         'edit.php?post_type=uws-groups', // Groups 
         'separator1', // --Space--
         'edit.php', // Posts
         'edit-comments.php', // Comments
         'themes.php', // Appearance
         'plugins.php', // Plugins
         'separator2', // --Space--
         'users.php', // Users
         'tools.php', // Tools
         'options-general.php', // Settings
   );
}

function remove_new_items() {
    
    global $wp_admin_bar;   
    $wp_admin_bar->remove_node( 'new-post' );
    $wp_admin_bar->remove_node( 'wp-logo' );
    $wp_admin_bar->remove_node( 'comments' );
    
}

function hide_menu_page()  {
    
    if ( !current_user_can( 'administrator' ) ) {
        
        remove_menu_page( 'edit-comments.php' ); //Comments
        remove_menu_page( 'edit.php' ); //Posts
        remove_menu_page( 'tools.php' ); //Tools
        
    }
    
}

/*------------------------------------*\
	ADD Actions
\*------------------------------------*/

// Add Custom Scripts to wp_head
add_action( 'init', 'uwsmedia_header_scripts' );

// Enable Threaded Comments
add_action( 'get_header', 'enable_threaded_comments' );

// Add Theme Stylesheet
add_action( 'wp_enqueue_scripts', 'uwsmedia_styles' );

// Add uwsmedia Menu
add_action( 'init', 'register_uwsmedia_menu' );

// Remove inline Recent Comment Styles from wp_head()
add_action( 'widgets_init', 'my_remove_recent_comments_style' );

// Add our uwsmedia Pagination
add_action( 'init', 'uwsmediawp_pagination' );

// Add uwsmedia theme settings
add_action( 'admin_menu', 'uwsmedia_admin_theme_settings' );
add_action( 'admin_enqueue_scripts', 'uwsmedia_admin_scripts' );
add_action( 'admin_init', 'uwsmedia_theme_settings' );

// Add UWS Media custom post (Groups and Projects/Showcases)
add_action( 'init', 'create_post_groups' );
add_action( 'init', 'create_projects_post' );
add_action( 'manage_posts_custom_column', 'add_project_group_column_value', 10, 2 );
add_action( 'manage_pages_custom_column', 'add_project_group_column_value', 10, 2 );
add_action( 'admin_menu', 'remove_projects_pageparentdiv_metabox' );
add_action( 'add_meta_boxes', 'add_groups_metabox' );

// save group metadata on save post
add_action( 'save_post', 'save_post_group_meta', 10, 2 );

/* Hide unused page from Dashboard Admin Menu */
add_action( 'admin_menu', 'hide_menu_page');

// Remove Admin +New items
add_action( 'admin_bar_menu', 'remove_new_items', 999 );

/* Flush rewrite rules for custom post types. */
add_action( 'after_switch_theme', 'flush_rewrite_rules' );

// Add dropdown filter for Groups Custom Post
add_action( 'restrict_manage_posts', 'add_groups_filter_dropdown' );

/*------------------------------------*\
	REMOVE Actions
\*------------------------------------*/

// Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links_extra', 3 );

// Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'feed_links', 2 );

// Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'rsd_link' );

// Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'wlwmanifest_link' );

// Index link
remove_action( 'wp_head', 'index_rel_link' );

// Prev link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

// Start link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

// Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );

// Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action( 'wp_head', 'wp_generator' ); 
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

/*------------------------------------*\
	ADD Filters
\*------------------------------------*/

// Custom Gravatar in Settings > Discussion
add_filter( 'avatar_defaults', 'uwsmediagravatar' );

// Add slug to body class (Starkers build)
add_filter( 'body_class', 'add_slug_to_body_class' );

// Allow shortcodes in Dynamic Sidebar
add_filter( 'widget_text', 'do_shortcode' );

// Remove <p> tags in Dynamic Sidebars (better!)
add_filter( 'widget_text', 'shortcode_unautop' );

// Remove surrounding <div> from WP Navigation
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

// Remove invalid rel attribute
add_filter( 'the_category', 'remove_category_rel_from_category_list' );

 // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter( 'the_excerpt', 'shortcode_unautop'  );

// Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter( 'the_excerpt', 'do_shortcode' );

// Add 'View Article' button instead of [...] for Excerpts
add_filter( 'excerpt_more', 'uwsmedia_view_article' );

// Remove 'text/css' from enqueued stylesheet
add_filter( 'style_loader_tag', 'uwsmedia_style_remove' );

// Remove width and height dynamic attributes to thumbnails
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );

// Remove width and height dynamic attributes to post images
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

// Allow SVG MIME uplaod to Media
add_filter( 'upload_mimes', 'cc_mime_types' ); 

// Reorder Admin Menu
add_filter( 'custom_menu_order', 'reorder_admin_menu' );
add_filter( 'menu_order', 'reorder_admin_menu' );

// Add Group column to UWS Project custom post type and Page
add_filter( 'manage_uws-projects_posts_columns', 'add_projects_group_column' );
add_filter( 'manage_page_posts_columns', 'add_group_column' );
add_filter( 'manage_edit-uws-projects_sortable_columns', 'sortable_group_column' );
add_filter( 'manage_edit-page_sortable_columns', 'sortable_group_column' );
add_filter( 'parse_query', 'filter_group_query' , 10);

/*------------------------------------*\
	ADD Filters
\*------------------------------------*/

// Remove <p> tags from Excerpt altogether
remove_filter( 'the_excerpt', 'wpautop' ); 

/*------------------------------------*\
	CUSTOM POST TYPE: GROUPS
\*------------------------------------*/

function create_post_groups() {
    
    // Register Custom Post Type: Groups
    register_post_type( 'uws-groups', 
        array(
        'label' => 'Groups',
        'menu_icon' => 'dashicons-groups',
        'labels' => array(
            'name' => __( 'Groups', 'uwsmedia' ),
            'singular_name' => __( 'Group', 'uwsmedia' ),
            'menu_name' => __( 'Groups', 'uwsmedia' ),
            'name_admin_bar' => __( 'Group', 'uwsmedia' ),
            'add_new' => __( 'Add New', 'uwsmedia' ),
            'add_new_item' => __( 'Add New Group', 'uwsmedia' ),
            'new_item' => __( 'New Group', 'uwsmedia' ),
            'view_item' => __( 'View Group', 'uwsmedia' ),
            'view_items' => __( 'View Groups', 'uwsmedia' ),
            'search_items' => __( 'Search Groups', 'uwsmedia' ),
            'not_found' => __( 'No group found.', 'uwsmedia' ),
            'not_found_in_trash' => __( 'No group found in Trash', 'uwsmedia' )
        ),
        'supports' => array(),
        'taxonomies' => array(),
        'hierarchical' => true,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => false,
        'show_in_nav_menus' => false,
        'can_export' => true,
        'has_archive' => false,	
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'capability_type' => 'page',
        'delete_with_user' => false
    ) );
    
}

function add_groups_metabox() {
    
    $post_types = get_post_types( array( 'public' => true , '_builtin' => false ) );
    array_push( $post_types, 'page' );
    
    foreach( $post_types as $type ) {
    
        add_meta_box( 'post-Group', 'Group', 'post_group_attributes_meta_box', $type, 'side', 'high' );
    
    }
    
}

function post_group_attributes_meta_box( $post ) {
    
    $post_type_object = get_post_type_object( 'uws-groups' );
    
    if ( $post_type_object->hierarchical ) {
        
        $pages = wp_dropdown_pages( array(
                'post_type'   => 'uws-groups', 
                'selected'    => get_post_meta( $post->ID, 'post_group_id', true ),
                'name'        => 'post_group_id',
                'sort_column' => 'menu_order, post_title',
                'show_option_none'      => __( 'Select group', 'uwsmedia' ),
                'option_none_value'     => '-1',
                'echo'        => 0
            )
        );
        
        if ( ! empty( $pages ) ) {
            
            $howTo = '<p class="howto">Select the group that for this post or page. Group are used to identify or categorize the context of the content.</p>';
            
            echo  $pages . $howTo;
            
        }
        
    }

}

function save_post_group_meta( $post_id, $post ) {
    
    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );
    
    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
        return $post_id;
    }
    
    if ( isset( $_POST['post_group_id'] ) ) {
        update_post_meta( $post_id, 'post_group_id', sanitize_text_field( $_POST['post_group_id'] ) );
    }

}

function add_projects_group_column( $columns ) {
    
    $columns = array(
        'cb' => $columns['cb'],
        'title' => __( 'Title' ),
        'group' => __( 'Group' ),
        'categories' => __( 'Categories' ),
        'tags' => __( 'Tags' ),
        'date' => __( 'Date' )
    );
    
    return $columns;
    
}

function add_group_column( $columns ) {
    
    $columns = array(
        'cb' => $columns['cb'],
        'title' => __( 'Title' ),
        'group' => __( 'Group' ),
        'date' => __( 'Date' )
    );
    
    return $columns;
    
}

function sortable_group_column( $columns ) {
    
    $columns['group'] = 'group';
    
    return $columns;
    
}

function add_project_group_column_value( $column, $post_id ) {
    
    switch ( $column ) {
        
        case 'group':
            $groupId = get_post_meta( $post_id, 'post_group_id', true );
    	    echo getGroupTitle( $groupId );
    	break;
    	
	}
	
}

function getGroupTitle( $groupId ) {
    
    if ( $groupId == '-1' ) {
        return '<span aria-hidden="true">—</span>';
    }
    
    $groupPost = get_post( $groupId );
    
    return $groupPost->post_title;
    
}

function add_groups_filter_dropdown( $post_type ) {

    /** Ensure this is the correct Post Type*/
    if ( $post_type == 'uws-projects' || $post_type == 'page' ) {

        global $wpdb;
        
        $request_attr = 'post_group_id';
        
        if ( isset($_REQUEST[$request_attr]) ) {
            $selected = $_REQUEST[$request_attr];
        }
        
        /** Grab the results from the DB */
        $query = $wpdb->prepare('
            SELECT DISTINCT pm.meta_value FROM %1$s pm
            LEFT JOIN %2$s p ON p.ID = pm.post_id
            WHERE pm.meta_key = "%3$s" 
            AND p.post_status = "%4$s"
            AND p.post_type = "%5$s"
            ORDER BY "%3$s"',
            $wpdb->postmeta,
            $wpdb->posts,
            'post_group_id', // Your meta key - change as required
            'publish',
            $post_type
        );
        $results = $wpdb->get_col($query);
        
        /** Ensure there are options to show */
        if ( empty( $results ) ) {
            
            return;
            
        }
        
        $options[] = sprintf( '<option value="0">%1$s</option>', __( 'All Groups', 'uwsmedia' ) );
        
        foreach( $results as $result ) {
            
            $select = ( $result == $selected ) ? ' selected="selected"' : '';
            
            if ( $result != '-1' ) {
                
                $options[] = sprintf('<option value="%1$s" ' . $select . '>%2$s</option>', esc_attr($result), getGroupTitle($result) );
                
            }
    
        }
    
        /** Output the dropdown menu */
        echo '<select class="" id="post_group_id" name="post_group_id">';
        echo join( "\n", $options );
        echo '</select>';
    }
    
    return;
    
}

function filter_group_query( $query ) {
    
    global $pagenow;
    $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
    
    if ( is_admin() && ( 'uws-projects' == $current_page || 'page' == $current_page ) && 'edit.php' == $pagenow  
    && isset( $_GET['post_group_id'] ) && $_GET['post_group_id'] != '' && $_GET['post_group_id'] != '0') {
    
        $group_id = $_GET['post_group_id'];
        $query->query_vars['meta_key'] = 'post_group_id';
        $query->query_vars['meta_value'] = $group_id;
        $query->query_vars['meta_compare'] = '=';
        
    }
    
}



/*------------------------------------*\
	CUSTOM POST TYPE: PROJECTS
\*------------------------------------*/

function create_projects_post() {
    
    // Register Taxonomies for Category
    register_taxonomy_for_object_type( 'category', 'uws-media' );
    register_taxonomy_for_object_type( 'post_tag', 'uws-media' );
    
    // Register Custom Post Type
    register_post_type( 'uws-projects', 
        array(
        'label' => 'Showcase projects',
        'menu_icon' => 'dashicons-portfolio',
        'labels' => array(
            'name' => __( 'Showcase Projects', 'uwsmedia' ),
            'singular_name' => __( 'Project', 'uwsmedia' ),
            'menu_name' => __( 'Showcases', 'uwsmedia' ),
            'name_admin_bar' => __('Project', 'uwsmedia' ),
            'add_new' => __( 'Add New', 'uwsmedia' ),
            'add_new_item' => __( 'Add New Project', 'uwsmedia' ),
            'edit' => __( 'Edit', 'uwsmedia' ),
            'edit_item' => __( 'Edit Project', 'uwsmedia' ),
            'new_item' => __( 'New Project', 'uwsmedia' ),
            'view' => __( 'View Project', 'uwsmedia' ),
            'view_item' => __( 'View Project', 'uwsmedia' ),
            'view_items' => __( 'View Projects', 'uwsmedia' ),
            'search_items' => __( 'Search projects', 'uwsmedia' ),
            'not_found' => __( 'No projects found.', 'uwsmedia' ),
            'not_found_in_trash' => __( 'No projects found in Trash', 'uwsmedia' )
        ),
        'supports' => array( 'title', 'editor', 'excerpt','thumbnail' ),
        'taxonomies' => array( 'category', 'post_tag' ),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,		
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
        'rewrite' => array('slug' => 'showcases'),
        'delete_with_user' => false
    ) );
}

function remove_projects_pageparentdiv_metabox() {
    
    remove_meta_box('pageparentdiv', 'uws-projects', 'normal');
    
}

/*------------------------------------*\
	Custom Menu Walker Class
\*------------------------------------*/

class Bootstrap_Nav_Walker extends Walker_Nav_Menu {

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';
 
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        $classes[] = 'menu-item-' . $item->ID;
        
        if( in_array('current-menu-item', $classes) ) {
            $classes[] = 'active';
        } else if( in_array('current-menu-parent', $classes) ) {
            $classes[] = 'active';
        } else if( in_array('current-menu-ancestor', $classes) ) {
            $classes[] = 'active';
        }

        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
 
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
 
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
 
        $output .= $indent . '<li' . $id . $class_names .'>';
 
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        $atts['class']  = 'nav-link';
 
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
 
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
 
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
        
        $appleIcon = "";
        if( in_array('faculty-link-btn', $classes) ) {
            $appleIcon =  '<img class="apple-icon" src="' .get_template_directory_uri() . '/img/apple_icon.svg" /> ';
        }
        
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $appleIcon . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
 
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    
}

/*------------------------------------*\
	Breadcrumb
\*------------------------------------*/
// Breadcrumbs
function breadcrumb_nav() {
       
    // Settings
    $separator          = '/';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Home';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    // $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive">' . post_type_archive_title($prefix, false) . '</li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive">' . $custom_tax_name . '</li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat">' . single_cat_title('', false) . '</li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '">' . $get_term_name . '</li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '">' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '">' . get_the_time('M') . ' Archives</li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '">' . 'Author: ' . $userdata->display_name . '</li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '">Search results for: ' . get_search_query() . '</li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
       
}

?>
