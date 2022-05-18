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
    		'menu_class'      => 'navbar-nav ms-auto',
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
        
        // Bootstrap
        wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/lib/bootstrap.min.js', array( 'jquery' ), '5.1.3' ); 
        wp_enqueue_script( 'bootstrap' );
        
        // UWS Media scripts
        wp_register_script( 'uwsmediascripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '1.0.0' );
        wp_enqueue_script( 'uwsmediascripts' );
        
    }
    
}

// Load uwsmedia styles
function uwsmedia_styles() {
    
    // Bootstrap
    wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '5.1.3', 'all' );
    wp_enqueue_style( 'bootstrap' );
    
    // Font Awesome
    wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.7.0' ); 
    wp_enqueue_style( 'font-awesome' );
    
    // PRISMJS
    wp_register_style( 'prism', get_template_directory_uri() . '/css/prism.css', array(), '1.17.1', 'all' );
    wp_enqueue_style( 'prism' );

    wp_register_script(
        'prismjs',
        get_template_directory_uri() . '/js/lib/prism.js',
        array(),
        '1.17.1',
        true
    );
    wp_enqueue_script( 'prismjs' );

    // UWS Media CSS
    wp_register_style( 'uwsmedia', get_template_directory_uri() . '/style.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'uwsmedia' );
    
    // autocomplete search
    global $post;

    $currentPage = get_post_meta( $post->ID, '_wp_page_template', true );
    
    if ( 'page-sublanding.php' == $currentPage ) {
        
        wp_register_style(
            'tarekraafat-autocomplete',
            get_template_directory_uri() . '/css/autocomplete.css',
            array(),
            '4.2.1'
        );
        
        wp_enqueue_style( 'tarekraafat-autocomplete' );
        
        wp_register_script(
            'tarekraafat-autocomplete',
            get_template_directory_uri() . '/js/lib/autocomplete.js',
            array(),
            '4.2.1',
            true
        );
        
        wp_enqueue_script( 'tarekraafat-autocomplete' );
       
    }
    
}

// Load login style
function uws_login_stylesheet() {
    
    wp_register_style( 'uwsmedia-login', get_template_directory_uri() . '/css/login.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'uwsmedia-login' );
    
}

function uwsmedia_login_logo_url() {
    return home_url();
}

function uwsmedia_login_logo_url_title() {
    return get_bloginfo( 'name' );
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
    
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'uwsmedia' ),
        'description'   => __( 'For page templates that have a side bar.', 'uwsmedia' ),
        'id'            => 'uwsmedia-sidebar',
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
        'total'   => $wp_query->max_num_pages,
        'prev_text'    => __('<span class="fa fa-chevron-left"></span> <span class="screen-reader-text">previous</span>'),
        'next_text'    => __('<span class="fa fa-chevron-right"></span> <span class="screen-reader-text">next</span>'),
        'show_all' => true,
        'type' => 'list'
    ) );
    
}

// Custom Excerpts
function uwsmediawp_index($length) // Create 23 Word Callback for Index page Excerpts, call using uwsmediawp_excerpt('uwsmediawp_index');
{
    return 23;
}

// Create 40 Word Callback for Custom Post Excerpts, call using uwsmediawp_excerpt('uwsmediawp_custom_post');
function uwsmediawp_custom_post($length)
{
    return 40;
}

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
    $output = $output;
    
    echo $output;
    
}

// Custom View Article link to Post
function uwsmedia_view_article($more) {
    
    global $post;
    
    if ( is_front_page() ) {
        return ' ...';
    }
    
    return ' ... <a class="view-article" href="' . get_permalink( $post->ID ) . '">' . __( 'Read More', 'uwsmedia' ) . '</a>';
    
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

function general_section_description() {
    echo '<p>General settings that will be applied to all pages.</p>';
}

function site_logo_options_callback() {
    
    $logo = get_option( 'site_logo_option' );
    $imgPreview = '<div class="image-preview-wrapper"><img class="image-preview" id="site-logo-preview" src="' . $logo . '" /></div>';
    $imgTxtField = '<input name="site_logo_option" id="site_logo_option" type="url" class="regular-text code" value="' . $logo . '" />';
    $imgUploadBtn = '<input id="upload_site_logo_button" data-rel="site_logo_option" data-preview="site-logo-preview" type="button" class="button" value="Select" />';
    
    echo $imgPreview . $imgTxtField . $imgUploadBtn;
    
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

function uwsmedia_theme_settings() {
    
    // Site
    
    add_option( 'site_logo_option', get_template_directory_uri() . '/img/uwex-media-logo.svg');
    add_option( 'footer_logo_option', get_template_directory_uri() . '/img/uws_logo.svg');
    add_option( 'copyright_option', 'Learning Technology and Media Services and University of Wisconsin Extended Campus. All rights reserved. No part of this website may be reproduced and or redistributed through any means without written permission.' );
    
    add_settings_section( 'general_section', 'General', 'general_section_description', 'uwsmedia_theme_settings' );
    add_settings_field( 'site_logo_option', 'Website Logo', 'site_logo_options_callback', 'uwsmedia_theme_settings', 'general_section' );
    add_settings_field( 'footer_logo_option', 'Footer Logo', 'footer_logo_options_callback', 'uwsmedia_theme_settings', 'general_section' );
    add_settings_field( 'copyright_option', 'Copyright', 'copyright_options_callback', 'uwsmedia_theme_settings', 'general_section' );

    // Register all settings
    register_setting( 'uwsmedia-theme-options-grp', 'site_logo_option' );
    register_setting( 'uwsmedia-theme-options-grp', 'footer_logo_option' );
    register_setting( 'uwsmedia-theme-options-grp', 'copyright_option' );
    
}

function uwsmedia_admin_scripts() {
    
    wp_register_script( 'uwsmedia_admin_script', get_template_directory_uri() . '/js/admin.js', array('jquery'), '1.0.0' );
    wp_enqueue_script('uwsmedia_admin_script');
    
    wp_register_style( 'uwsmedia_admin_css', get_template_directory_uri() . '/css/admin.css', array(), '1.0.0', 'all' );
    wp_enqueue_style( 'uwsmedia_admin_css' );
    
    // Font Awesome
    wp_register_style( 'font-awesome-admin', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.7.0' ); 
    wp_enqueue_style( 'font-awesome-admin' );
    
    global $pagenow;
    
    if ($pagenow != 'themes.php') {
        return;
    }
    
    wp_enqueue_media();

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
         'edit.php?post_type=uws-projects', // Media Showcase Projects
         'edit.php?post_type=uws-flex-projects', // Flex Showcase Projects
         'edit.php?post_type=uws-team-members', // Team Members 
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
add_action( 'init', 'create_team_members_post' );
add_action( 'init', 'create_post_groups' );
add_action( 'init', 'create_media_projects_post' );
add_action( 'init', 'create_flex_projects_post' );
add_action( 'init', 'create_programs_taxonomy' );
add_action( 'init', 'create_classifications_taxonomy' );
add_action( 'init', 'create_media_type_taxonomy' );
add_action( 'manage_posts_custom_column', 'add_project_custom_columns_value', 10, 2 );
add_action( 'manage_posts_custom_column', 'add_flex_project_custom_columns_value', 10, 2 );
add_action( 'manage_pages_custom_column', 'add_pages_group_column_value', 10, 2 );
add_action( 'manage_posts_custom_column', 'add_team_members_custom_columns_value', 10, 2 );
add_action( 'admin_menu', 'remove_projects_pageparentdiv_metabox' );
add_action( 'add_meta_boxes', 'add_groups_metabox' );

// add job title meta box to team members post type
add_action( 'add_meta_boxes', 'add_team_members_metabox' );

// add meta boxes to uws-project post
add_action( 'add_meta_boxes', 'add_project_metabox' );

// add sub landing meta box to page with sub landing page template
add_action( 'add_meta_boxes', 'add_homepage_banner_metabox' );

// save sublanding metadata on page save post
add_action( 'save_post', 'save_homepage_meta', 10, 2 );

// add sub landing meta box to page with sub landing page template
add_action( 'add_meta_boxes', 'add_sublanding_header_metabox' );
 
// save sublanding metadata on page save post
add_action( 'save_post', 'save_sublanding_meta', 10, 2 );

// save group metadata on save post
add_action( 'save_post', 'save_post_group_meta', 10, 2 );

// save team members metadata on save post
add_action( 'save_post', 'save_team_member_meta', 10, 2 );

// save metadata on project save post
add_action( 'save_post', 'save_project_meta', 10, 2 );

/* Hide unused page from Dashboard Admin Menu */
add_action( 'admin_menu', 'hide_menu_page');

// Remove Admin +New items
add_action( 'admin_bar_menu', 'remove_new_items', 999 );

/* Flush rewrite rules for custom post types. */
add_action( 'after_switch_theme', 'flush_rewrite_rules' );

// Add dropdown filter for Groups Custom Post
add_action( 'restrict_manage_posts', 'add_groups_filter_dropdown' );

// add custom sytle to login page
add_action( 'login_enqueue_scripts', 'uws_login_stylesheet' );

// Register REST route to for autocomplete and query
add_action( 'rest_api_init', 'rest_search_query' );

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

// Remove surrounding <div> from WP Navigation
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

// Remove invalid rel attribute
add_filter( 'the_category', 'remove_category_rel_from_category_list' );

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
add_filter( 'manage_uws-projects_posts_columns', 'add_projects_custom_columns' );
add_filter( 'manage_uws-flex-projects_posts_columns', 'add_flex_projects_custom_columns' );
add_filter( 'manage_page_posts_columns', 'add_group_column' );
//add_filter( 'manage_edit-uws-projects_sortable_columns', 'sortable_group_column' );
add_filter( 'manage_edit-page_sortable_columns', 'sortable_group_column' );
add_filter( 'parse_query', 'filter_group_query' , 10);

add_filter( 'manage_uws-team-members_posts_columns', 'add_team_members_custom_columns' );

// custom search query
add_filter( 'pre_get_posts', 'custom_search_query');

// change title place holder for team member post
add_filter( 'enter_title_here', 'team_members_change_title_placeholder' );

// change logo link and text on login page
add_filter( 'login_headertitle', 'uwsmedia_login_logo_url_title' );
add_filter( 'login_headerurl', 'uwsmedia_login_logo_url' );

// remove language switcher on login page
add_filter( 'login_display_language_dropdown' , '__return_false' ); 

// disable redirect_canonical
add_filter( 'redirect_canonical', function( $redirect_url ) {
	$url = 'http'.((isset($_SERVER['HTTPS']) && $_SERVER['HTTP'] !== 'off') ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if ( $redirect_url !== $url ) {
		global $wp_query;
		$wp_query->set_404();
		status_header(404);
		nocache_headers();
	}
	return false;
} );

add_filter( 'nav_menu_css_class', 'change_page_menu_classes', 10,2 );

function change_page_menu_classes($menu)
{
    global $post;
    if (get_post_type($post) == 'uws-team-members')
    {
        $menu = str_replace( 'active', '', $menu ); // remove all current_page_parent classes
        $menu = str_replace( 'menu-item-13063', 'menu-item-13063 active', $menu ); // add the current_page_parent class to the page you want
    }
    return $menu;
}

/*------------------------------------*\
	REMOVE Filters
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
        'menu_icon' => 'dashicons-nametag',
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
    unset( $post_types['uws-team-members'] );
    unset( $post_types['uws-groups'] );
    
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
            
            $groupInstruction = '<p>Select a group.</p>';
            $groupHowTo = '<p class="howto">Group is used to target the audience.</p>';
            
            
            $featureOnHomepageCB = '';
            // $promoteToPortfolioCB = '';
            
            if ( $post->post_type == 'uws-projects' || $post->post_type == 'uws-flex-projects' ) {
                
                $featuredValue = get_post_meta( $post->ID, 'feature_on_home' , true );
                // $toPortfolioValue = get_post_meta( $post->ID, 'promote_to_porfolio' , true );
                
                $featureOnHomepageCB = '<hr /><label for="feature_on_home"><input type="checkbox" id="feature_on_home" name="feature_on_home" value="1" '. checked( $featuredValue, true, false ) .' /> Feature on Homepage</label>';
                
                // $promoteToPortfolioCB = '<br /><label id="toPortfolio" for="promote_to_porfolio"><input type="checkbox" id="promote_to_porfolio" name="promote_to_porfolio" value="1" '. checked( $toPortfolioValue, true, false ) .' /> Show in Portfolio</label>';
                
            }
            
            //echo  $groupInstruction . $pages . $groupHowTo . $featureOnHomepageCB . $promoteToPortfolioCB;
            echo  $groupInstruction . $pages . $groupHowTo . $featureOnHomepageCB;
            
        }
        
        register_meta( $post->post_type, 'post_group_id', array(
            
            'type' => 'string',
            'description' => 'The audience group id.',
            'show_in_rest' => true
            
        ) );
        
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
    
    if ( $post->post_type == 'uws-projects' ) {
        
        if ( isset( $_POST['feature_on_home'] ) ) {
            
            update_post_meta( $post_id, 'feature_on_home', sanitize_text_field( $_POST['feature_on_home'] ) );
            
        } else {
            
            delete_post_meta( $post_id, 'feature_on_home' );
            
        }
        
        if ( isset( $_POST['promote_to_porfolio'] ) ) {
            
            update_post_meta( $post_id, 'promote_to_porfolio', sanitize_text_field( $_POST['promote_to_porfolio'] ) );
            
        } else {
            
            delete_post_meta( $post_id, 'promote_to_porfolio' );
            
        }
        
    }

}

function add_group_column( $columns ) {
    
    $columns = array(
        'cb' => $columns['cb'],
        'title' => __( 'Title' ),
        'group' => __( 'Group', 'uwsmedia' ),
        'date' => __( 'Date' )
    );
    
    return $columns;
    
}

function sortable_group_column( $columns ) {
    
    $columns['group'] = 'group';
    
    return $columns;
    
}

function add_projects_custom_columns( $columns ) {
    
    $columns = array(
        'cb' => $columns['cb'],
        'featured' => __( '<span class="screen-reader-text">Featured on Home Page</span>', 'uwsmedia' ),
        'title' => __( 'Title' ),
        'program' => __( 'Program', 'uwsmedia' ),
        'classification' => __( 'Classification', 'uwsmedia' ),
        'media_type' => __( 'Media Type', 'uwsmedia' ),
        'date' => __( 'Date' )
    );
    
    return $columns;
    
}

function add_project_custom_columns_value( $column, $post_id ) {
    
    switch ( $column ) {
        case 'featured':
            
            $feature = get_post_meta( $post_id, 'feature_on_home', true );

            if ( $feature == '1' ) {
                echo '<span class="dashicons dashicons-star-filled"></span> <span class="screen-reader-text">Featured on Home Page</span>';
            }
    
    	break;

    	break;
    	case 'media_type':
            
            $media_type_terms = get_the_terms( $post->ID, 'media_types' );
            
            if ( !is_array( $media_type_terms ) || count( $media_type_terms ) <= 0 ) {
                echo '<span aria-hidden="true">&mdash;</span>';
            } else {
                echo strip_tags( get_the_term_list( $post->ID, 'media_types', '', ', ', '' ) );
            }
    	    
    	break;
    	case 'classification':
    	    
    	    $classification_terms = get_the_terms( $post->ID, 'classifications' );
            
            if ( !is_array( $classification_terms ) || count( $classification_terms ) <= 0 ) {
                echo '<span aria-hidden="true">&mdash;</span>';
            } else {
                echo $classification_terms[0]->name;
            }
    	    
    	break;
    	case 'program':
    	
    	    $program_terms = get_the_terms( $post->ID, 'programs' );
            
            if ( !is_array( $program_terms ) || count( $program_terms ) <= 0 ) {
                echo '<span aria-hidden="true">&mdash;</span>';
            } else {
                echo $program_terms[0]->name;
            }
    	    
    	break;
	}
    
}

function add_flex_projects_custom_columns( $columns ) {
    
    $columns = array(
        'cb' => $columns['cb'],
        'featured' => __( '<span class="screen-reader-text">Featured on Home Page</span>', 'uwsmedia' ),
        'title' => __( 'Title' ),
        'flex_classification' => __( 'Classification', 'uwsmedia' ),
        'flex_media_type' => __( 'Media Type', 'uwsmedia' ),
        'date' => __( 'Date' )
    );
    
    return $columns;
    
}

function add_flex_project_custom_columns_value( $column, $post_id ) {
    
    switch ( $column ) {
        case 'featured':
            
            $feature = get_post_meta( $post_id, 'feature_on_home', true );

            if ( $feature == '1' ) {
                echo '<span class="dashicons dashicons-star-filled"></span> <span class="screen-reader-text">Featured on Home Page</span>';
            }
    
    	break;

    	break;
    	case 'flex_media_type':
            
            $media_type_terms = get_the_terms( $post->ID, 'flex_media_types' );
            
            if ( !is_array( $media_type_terms ) || count( $media_type_terms ) <= 0 ) {
                echo '<span aria-hidden="true">&mdash;</span>';
            } else {
                echo strip_tags( get_the_term_list( $post->ID, 'flex_media_types', '', ', ', '' ) );
            }
    	    
    	break;
    	case 'flex_classification':
    	    
    	    $classification_terms = get_the_terms( $post->ID, 'flex_classifications' );
            
            if ( !is_array( $classification_terms ) || count( $classification_terms ) <= 0 ) {
                echo '<span aria-hidden="true">&mdash;</span>';
            } else {
                echo $classification_terms[0]->name;
            }
    	    
    	break;
	}
    
}

function add_pages_group_column_value( $column, $post_id ) {
    
    switch ( $column ) {
        
        case 'group':
        
            $groupId = get_post_meta( $post_id, 'post_group_id', true );
            $portfolioToo = get_post_meta( $post_id, 'promote_to_porfolio', true );
            
            if ( $portfolioToo == '1' ) {
                
                echo getGroupTitle( $groupId ) . ' <span class="dashicons dashicons-awards"></span> <span class="screen-reader-text">Promoted to Portfolio</span>';
                
            } else {
                
                echo getGroupTitle( $groupId );
                
            }
            
    	break;
    	
	}
	
}

function getGroupTitle( $groupId ) {
    
    if ( $groupId == '-1' ) {
        return '<span aria-hidden="true">&mdash;</span>';
    }
    
    $groupPost = get_post( $groupId );
    
    return $groupPost->post_title;
    
}

function add_groups_filter_dropdown( $post_type ) {

    /** Ensure this is the correct Post Type*/
    if ( $post_type == 'uws-projects' || $post_type == 'page' ) {

        global $wpdb;
        
        $request_attr = 'post_group_id';
        
        $selected = null;
        
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

// Media Showcase
function create_media_projects_post() {
    
    // Register Custom Post Type
    register_post_type( 'uws-projects', 
        array(
        'label' => 'Media Showcase',
        'menu_icon' => 'dashicons-portfolio',
        'labels' => array(
            'name' => __( 'Media Showcase', 'uwsmedia' ),
            'singular_name' => __( 'Project', 'uwsmedia' ),
            'all_items' => __( 'All Projects', 'uwsmedia' ),
            'menu_name' => __( 'Media Showcase', 'uwsmedia' ),
            'name_admin_bar' => __('Media Showcase Item', 'uwsmedia' ),
            'add_new' => __( 'Add New', 'uwsmedia' ),
            'add_new_item' => __( 'Add New Project', 'uwsmedia' ),
            'edit' => __( 'Edit', 'uwsmedia' ),
            'edit_item' => __( 'Edit Project', 'uwsmedia' ),
            'new_item' => __( 'New Project', 'uwsmedia' ),
            'view' => __( 'View Project', 'uwsmedia' ),
            'view_item' => __( 'View Project', 'uwsmedia' ),
            'view_items' => __( 'View Media Showcase', 'uwsmedia' ),
            'search_items' => __( 'Search projects', 'uwsmedia' ),
            'not_found' => __( 'No projects found.', 'uwsmedia' ),
            'not_found_in_trash' => __( 'No projects found in Trash', 'uwsmedia' )
        ),
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
        'taxonomies' => array(),
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
        'query_var' => true,
        'capability_type' => 'page',
        'delete_with_user' => false,
        'rewrite' => array('slug' => 'media-showcases', 'with_front' => true),
        'show_in_rest' => true,
        'rest_base' => 'media-showcases',
        'rest_controller_class' => 'WP_REST_Posts_Controller'
    ) );
    
}

// Flex Showcase
function create_flex_projects_post() {
    
    // Register Custom Post Type
    register_post_type( 'uws-flex-projects', 
        array(
        'label' => 'Flex Showcase',
        'menu_icon' => 'dashicons-portfolio',
        'labels' => array(
            'name' => __( 'Flex Showcase', 'uwsmedia' ),
            'singular_name' => __( 'Project', 'uwsmedia' ),
            'all_items' => __( 'All Projects', 'uwsmedia' ),
            'menu_name' => __( 'Flex Showcase', 'uwsmedia' ),
            'name_admin_bar' => __('Flex Showcase Item', 'uwsmedia' ),
            'add_new' => __( 'Add New', 'uwsmedia' ),
            'add_new_item' => __( 'Add New Project', 'uwsmedia' ),
            'edit' => __( 'Edit', 'uwsmedia' ),
            'edit_item' => __( 'Edit Project', 'uwsmedia' ),
            'new_item' => __( 'New Project', 'uwsmedia' ),
            'view' => __( 'View Project', 'uwsmedia' ),
            'view_item' => __( 'View Project', 'uwsmedia' ),
            'view_items' => __( 'View Flex Showcase', 'uwsmedia' ),
            'search_items' => __( 'Search projects', 'uwsmedia' ),
            'not_found' => __( 'No projects found.', 'uwsmedia' ),
            'not_found_in_trash' => __( 'No projects found in Trash', 'uwsmedia' )
        ),
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
        'taxonomies' => array(),
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
        'query_var' => true,
        'capability_type' => 'page',
        'delete_with_user' => false,
        'rewrite' => array('slug' => 'flex-showcases', 'with_front' => true),
        'show_in_rest' => true,
        'rest_base' => 'flex-showcases',
        'rest_controller_class' => 'WP_REST_Posts_Controller'
    ) );
    
}

function add_project_metabox() {

    //media
    add_meta_box( 'project-author', 'Members', 'project_authors_meta_box', 'uws-projects', 'normal', 'high' );
    add_meta_box( 'project-media-embed', 'Media Embed', 'project_media_ebmed_meta_box', 'uws-projects', 'normal', 'default' );

    //flex
    add_meta_box( 'project-author', 'Members', 'project_authors_meta_box', 'uws-flex-projects', 'normal', 'high' );
    add_meta_box( 'project-media-embed', 'Media Embed', 'project_media_ebmed_meta_box', 'uws-flex-projects', 'normal', 'default' );
    
}

function project_authors_meta_box( $post ) {
    
    echo '<p>Select the team members who worked on this project</p>';
    
    $query_args = array(
        'post_type' => 'uws-team-members',
        'post_status' => 'publish',
        'order' => 'ASC',
        'orderby' => 'title'
    );
    
    $authors = new WP_Query( $query_args );
    
    if ( $authors->have_posts() ) {
        
        echo '<p><select multiple="multiple" name="project_authors_select">';
        
        while( $authors->have_posts() ) {
            
            $authors->the_post();
            
            echo '<option value="' . get_the_ID() . '">' . get_the_title() . '</option>';
            
        }
        
        echo '</select></p>';
        echo '<input type="hidden" name="project_authors" value="' . get_post_meta( $post->ID, 'project_authors', true ) . '" />';
        echo '<p class="howto">Hold down shift key to select multiple authors.</p>';
        
        wp_reset_postdata();
    
    }
    
    echo '<p><strong>Instructors(s)</strong></p>';
    wp_nonce_field( 'add_other_project_authors', 'other_project_authors_nonce' );
    echo '<input type="text" value="' . get_post_meta( $post->ID, 'other_authors', true ) . '" name="other_authors" />';
    echo '<p class="howto">Separate instructors with commas if any</p>';
    
}

function project_media_ebmed_meta_box( $post ) {
    
    echo '<p>Enter media to embed and show on the page right after the title but before the content.</p>';
    wp_nonce_field( 'add_media_embed', 'media_embed_nonce' );
    
    echo '<textarea class="code" name="media_embed_code">' . get_post_meta( $post->ID, 'media_embed_code', true ) . '</textarea>';
    
    $responsive = get_post_meta( $post->ID, 'responsive_choice' )[0];
    
    echo '<p>iFrame Embed Responsiveness:<br>';
    echo '<label for="21b9"><input id="21b9" type="radio" name="responsive_choice" value="21by9" ' . checked( $responsive, '21by9', false ) . '/>21:9</label>&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<label for="16b9"><input id="16b9" type="radio" name="responsive_choice" value="16by9" ' . checked( $responsive, '16by9', false ) . '/>16:9</label>&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<label for="4b3"><input id="4b3" type="radio" name="responsive_choice" value="4by3"   ' . checked( $responsive, '4by3', false ) . '/>4:3</label>&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<label for="1b1"><input id="1b1" type="radio" name="responsive_choice" value="1by1"   ' . checked( $responsive, '1by1', false ) . '/>1:1</label>&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<label for="sb"><input id="sb" type="radio" name="responsive_choice" value="sb" ' . checked( $responsive, 'sb', false ) . ' />Storybook+ 3</label>&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<label for="none"><input id="none" type="radio" name="responsive_choice" value="-1"  ' . checked( $responsive, '-1', false ) . '/>None</label></p>';
    
    $hideThumb = get_post_meta( $post->ID, 'hide_thumbnail' )[0];
    
    echo '<hr /><p><label><input value="1" name="hide_thumbnail" type="checkbox" ' . checked( $hideThumb, 1, false ) . ' /> Hide Featured Image</label></p>';
    
}

function save_project_meta( $post_id, $post ) {
    
    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );
    
    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
        return $post_id;
    }
    
    if ( isset( $_POST['project_authors'] ) ) {
        
        update_post_meta( $post_id, 'project_authors', sanitize_text_field( $_POST['project_authors'] ) );
        
    }
    
    if ( wp_verify_nonce( $_POST['other_project_authors_nonce'], 'add_other_project_authors' ) ) {
        
        update_post_meta( $post_id, 'other_authors', sanitize_text_field( $_POST['other_authors'] ) );
        
    }
    
    if ( wp_verify_nonce( $_POST['media_embed_nonce'], 'add_media_embed' ) ) {
        
        update_post_meta( $post_id, 'media_embed_code', $_POST['media_embed_code'] );
        
    }
    
    if ( isset( $_POST['responsive_choice'] ) ) {
        
        update_post_meta( $post_id, 'responsive_choice', $_POST['responsive_choice'] );
        
        if ( $_POST['responsive_choice'] == '-1' ) {
            delete_post_meta( $post_id, 'responsive_choice', $_POST['responsive_choice'] );
        }
        
    }
    
    if ( isset( $_POST['hide_thumbnail'] ) ) {
        
        update_post_meta( $post_id, 'hide_thumbnail', sanitize_text_field( $_POST['hide_thumbnail'] ) );
        
    } else {
        
        delete_post_meta( $post_id, 'hide_thumbnail', sanitize_text_field( $_POST['hide_thumbnail'] ) );
        
    }

}

function create_programs_taxonomy() {
    
    $labels = array(
        'name' => __( 'Programs', 'uwsmedia' ),
        'singular_name' => __( 'Program', 'uwsmedia' ),
        'all_items' => __( 'All Programs', 'uwsmedia' ),
        'edit_item' => __( 'Edit Program', 'uwsmedia' ),
        'view_item' => __( 'View Program', 'uwsmedia' ),
        'update_item' => __( 'Update Program', 'uwsmedia' ),
        'new_item_name' => __( 'New Program Name', 'uwsmedia' ),
        'add_new_item' => __( 'Add New Program', 'uwsmedia' ),
        'search_items' => __( 'Search Programs', 'uwsmedia' ),
        'popular_items' => __( 'Popular Programs', 'uwsmedia' ),
        'add_or_remove_items' => __( 'Add or remove programs', 'uwsmedia' ),
        'choose_from_most_used' => __( 'Choose from most used programs', 'uwsmedia' ),
        'separate_items_with_commas' => __( 'Separate programs with commas', 'uwsmedia' ),
        'parent_item' => null,
		'parent_item_colon'  => null,
		'not_found' => __( 'No programs found.', 'uwsmedia' ),
		'menu_name' => __( 'Programs', 'uwsmedia' ),
    );
    
    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'meta_box_cb' => 'uws_projects_programs',
        'rewrite' => array( 'slug' => 'program' )
    );
    
    register_taxonomy( 'programs', 'uws-projects', $args );
    
}

function create_classifications_taxonomy() {
    
    $labels = array(
        'name' => __( 'Classifications', 'uwsmedia' ),
        'singular_name' => __( 'Classification', 'uwsmedia' ),
        'all_items' => __( 'All Classification', 'uwsmedia' ),
        'edit_item' => __( 'Edit Classification', 'uwsmedia' ),
        'view_item' => __( 'View Classification', 'uwsmedia' ),
        'update_item' => __( 'Update Classification', 'uwsmedia' ),
        'new_item_name' => __( 'New Classification Name', 'uwsmedia' ),
        'add_new_item' => __( 'Add New Classification', 'uwsmedia' ),
        'search_items' => __( 'Search Classifications', 'uwsmedia' ),
        'popular_items' => __( 'Popular Classifications', 'uwsmedia' ),
        'add_or_remove_items' => __( 'Add or remove classifications', 'uwsmedia' ),
        'choose_from_most_used' => __( 'Choose from most used classifications', 'uwsmedia' ),
        'separate_items_with_commas' => __( 'Separate classifications with commas', 'uwsmedia' ),
        'parent_item' => null,
		'parent_item_colon'  => null,
		'not_found' => __( 'No classifications found.', 'uwsmedia' ),
		'menu_name' => __( 'Classifications', 'uwsmedia' ),
    );
    
    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'meta_box_cb' => 'uws_projects_classifications',
        'rewrite' => array( 'slug' => 'classification' )
    );
    
    register_taxonomy( 'classifications', 'uws-projects', $args );
    register_taxonomy( 'flex_classifications', 'uws-flex-projects', $args );
    
}

function create_media_type_taxonomy() {
    
    $labels = array(
        'name' => __( 'Media Types', 'uwsmedia' ),
        'singular_name' => __( 'Type', 'uwsmedia' ),
        'all_items' => __( 'All Media Types', 'uwsmedia' ),
        'edit_item' => __( 'Edit Media Type', 'uwsmedia' ),
        'view_item' => __( 'View Media Type', 'uwsmedia' ),
        'update_item' => __( 'Update Media Type', 'uwsmedia' ),
        'new_item_name' => __( 'New Media Type Name', 'uwsmedia' ),
        'add_new_item' => __( 'Add New Media Type', 'uwsmedia' ),
        'search_items' => __( 'Search Media Types', 'uwsmedia' ),
        'popular_items' => __( 'Popular Media Types', 'uwsmedia' ),
        'add_or_remove_items' => __( 'Add or remove media types', 'uwsmedia' ),
        'choose_from_most_used' => __( 'Choose from most used media types', 'uwsmedia' ),
        'separate_items_with_commas' => __( 'Separate media types with commas', 'uwsmedia' ),
        'parent_item' => null,
		'parent_item_colon'  => null,
		'not_found' => __( 'No media types found.', 'uwsmedia' ),
		'menu_name' => __( 'Media Types', 'uwsmedia' ),
    );
    
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'types' )
    );
    
    register_taxonomy( 'media_types', 'uws-projects', $args );
    register_taxonomy( 'flex_media_types', 'uws-flex-projects', $args );
    
}

function uws_projects_classifications( $post, $box ) {
    
    $defaults = array( 'taxonomy' => 'category' );
    
    if ( !isset( $box['args'] ) || !is_array( $box['args'] ) ) {
        
        $args = array();
        
    } else {
        
        $args = $box['args'];
        
    }
    
    extract( wp_parse_args( $args, $defaults ), EXTR_SKIP );
    
    $tax = get_taxonomy( $taxonomy );
    ?>
    <div id="taxonomy-<?php echo $taxonomy; ?>" class="acf-taxonomy-field categorydiv">
        <?php
            $name = ( $taxonomy == 'category' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
        echo "<input type='hidden' name='{$name}[]' value='0' />";
        
        ?>
        
        <?php
            $term_obj = wp_get_object_terms( $post->ID, $taxonomy );
            wp_dropdown_categories( array(
                'taxonomy' => $taxonomy,
                'hide_empty' => 0,
                'name' => "{$name}[]",
                'selected' => $term_obj[0]->slug,
                'orderby' => 'name',
                'hierarchical' => 0,
                'show_option_none' => '&mdash;',
                'option_none_value'  => '0',
                'value_field' => 'slug',
                )
            );
        ?>
        
    </div>
    <?php
    
}

function uws_projects_programs( $post, $box ) {
    
    $defaults = array( 'taxonomy' => 'category' );
    
    if ( !isset( $box['args'] ) || !is_array( $box['args'] ) ) {
        
        $args = array();
        
    } else {
        
        $args = $box['args'];
        
    }
    
    extract( wp_parse_args( $args, $defaults ), EXTR_SKIP );
    
    $tax = get_taxonomy( $taxonomy );
    ?>
    <div id="taxonomy-<?php echo $taxonomy; ?>" class="acf-taxonomy-field categorydiv">
        <?php
            $name = ( $taxonomy == 'category' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
        echo "<input type='hidden' name='{$name}[]' value='0' />";
        
        ?>
        
        <?php
            $term_obj = wp_get_object_terms( $post->ID, $taxonomy );
            wp_dropdown_categories( array(
                'taxonomy' => $taxonomy,
                'hide_empty' => 0,
                'name' => "{$name}[]",
                'selected' => $term_obj[0]->slug,
                'orderby' => 'name',
                'hierarchical' => 0,
                'show_option_none' => '&mdash;',
                'option_none_value'  => '0',
                'value_field' => 'slug',
                )
            );
        ?>
        
    </div>
    <?php
    
}

function remove_projects_pageparentdiv_metabox() {
    
    remove_meta_box('pageparentdiv', 'uws-projects', 'normal');
    remove_meta_box('pageparentdiv', 'uws-flex-projects', 'normal');
    
}

/*------------------------------------*\
	CUSTOM POST TYPE: TEAM MEMBERS
\*------------------------------------*/

function create_team_members_post() {
    
    // Register Custom Post Type
    register_post_type( 'uws-team-members', 
        array(
        'label' => 'Team Members',
        'menu_icon' => 'dashicons-groups',
        'labels' => array(
            'name' => __( 'Team Members', 'uwsmedia' ),
            'singular_name' => __( 'Team Member', 'uwsmedia' ),
            'all_items' => __( 'All Members', 'uwsmedia' ),
            'menu_name' => __( 'Team Members', 'uwsmedia' ),
            'name_admin_bar' => __('Member', 'uwsmedia' ),
            'add_new' => __( 'Add Member', 'uwsmedia' ),
            'add_new_item' => __( 'Add New Member', 'uwsmedia' ),
            'edit' => __( 'Edit', 'uwsmedia' ),
            'edit_item' => __( 'Edit Member', 'uwsmedia' ),
            'new_item' => __( 'New Member', 'uwsmedia' ),
            'view' => __( 'View Member', 'uwsmedia' ),
            'view_item' => __( 'View Member', 'uwsmedia' ),
            'view_items' => __( 'View Members', 'uwsmedia' ),
            'search_items' => __( 'Search members', 'uwsmedia' ),
            'not_found' => __( 'No members found.', 'uwsmedia' ),
            'not_found_in_trash' => __( 'No members found in Trash', 'uwsmedia' )
        ),
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => false,		
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'query_var' => true,
        'capability_type' => 'page',
        'delete_with_user' => false,
        'rewrite' => array('slug' => 'team', 'with_front' => false )
    ) );
}

function add_team_members_metabox() {
    
    add_meta_box( 'job_title', 'Job Title', 'job_title_meta_box', 'uws-team-members', 'side', 'high' );
    add_meta_box( 'pronouns', 'Pronouns', 'pronouns_meta_box', 'uws-team-members', 'side', 'high' );
    add_meta_box( 'interests', 'Interests', 'interest_meta_box', 'uws-team-members', 'side', 'default' );
    add_meta_box( 'social_networks', 'Social Networks', 'social_networks_meta_box', 'uws-team-members', 'normal', 'default' );
    
}

function job_title_meta_box( $post ) {
    
    wp_nonce_field( 'add_job_title', 'job_title_nonce' );
    
    echo '<p><input type="text" name="job_title" value="' . get_post_meta( $post->ID, 'job_title', true ) . '" placeholder="Enter Job Title" /></p>';
    
    $atTop = get_post_meta( $post->ID, 'show_first', true );
    
    echo '<hr><p><label for="showFirstCb"><input id="showFirstCb" name="show_first" type="checkbox" value="1" '. checked( $atTop, true, false ) .' /> Place profile at the beginning</label></p>';
    
}

function pronouns_meta_box( $post ) {
    
    wp_nonce_field( 'add_pronouns', 'pronouns_nonce' );
    
    echo '<p><input type="text" name="pronouns" value="' . get_post_meta( $post->ID, 'pronouns', true ) . '" placeholder="She/Her/Hers, He/Him/His, They/Them/Theirs, Ze/Hir/His" /></p>';
    
}

function interest_meta_box( $post ) {
    
    wp_nonce_field( 'add_interests', 'interests_nonce' );
    
    echo '<input type="text" name="member_interests" value="' . get_post_meta( $post->ID, 'member_interests', true ) . '" /><p class="howto">Separate interests with commas</p>';
    
}

function social_networks_meta_box( $post ) {
    
    echo '<p class="howto">Enter social network usernames that you are comfortable sharing.</p>';
    
    wp_nonce_field( 'add_linkedin_network', 'linkedin_network_nonce' );

    echo '<p><span class="fa fa-linkedin-square"></span> <strong>LinkedIn</strong><br>https://www.linkedin.com/in/<input class="edit-post-social-input" type="text" name="linkedin_username" value="' . get_post_meta( $post->ID, 'linkedin_username', true ) . '" placeholder="username" /></p>';
    
    wp_nonce_field( 'add_twitter_network', 'twitter_network_nonce' );

    echo '<p><span class="fa fa-twitter"></span> <strong>Twitter</strong><br>https://twitter.com/<input class="edit-post-social-input" type="text" name="twitter_username" value="' . get_post_meta( $post->ID, 'twitter_username', true ) . '" placeholder="username" /></p>';
    
    wp_nonce_field( 'add_facebook_network', 'facebook_network_nonce' );

    echo '<p><span class="fa fa-facebook-official"></span> <strong>Facebook</strong><br>https://www.facebook.com/<input class="edit-post-social-input" type="text" name="facebook_username" value="' . get_post_meta( $post->ID, 'facebook_username', true ) . '" placeholder="username" /></p>';
    
    wp_nonce_field( 'add_youtube_network', 'youtube_network_nonce' );

    echo '<p><span class="fa fa-youtube-play"></span> <strong>YouTube</strong><br>https://www.youtube.com/user/<input class="edit-post-social-input" type="text" name="youtube_username" value="' . get_post_meta( $post->ID, 'youtube_username', true ) . '" placeholder="username" /></p>';
    
    wp_nonce_field( 'add_behance_network', 'behance_network_nonce' );

    echo '<p><span class="fa fa-behance-square"></span> <strong>Béhance</strong><br>https://www.behance.net/<input class="edit-post-social-input" type="text" name="behance_username" value="' . get_post_meta( $post->ID, 'behance_username', true ) . '" placeholder="username" /></p>';
    
    wp_nonce_field( 'add_github_network', 'github_network_nonce' );

    echo '<p><span class="fa fa-github-square"></span> <strong>GitHub</strong><br>https://github.com/<input class="edit-post-social-input" type="text" name="github_username" value="' . get_post_meta( $post->ID, 'github_username', true ) . '" placeholder="username" /></p>';
    
}

function save_team_member_meta( $post_id, $post ) {
    
    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );
    
    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
        return $post_id;
    }
    
    if ( wp_verify_nonce( $_POST['job_title_nonce'], 'add_job_title' ) ) {
        
        update_post_meta( $post_id, 'job_title', sanitize_text_field( $_POST['job_title'] ) );
        
    }
    
    if ( isset( $_POST['show_first'] ) ) {
        
        update_post_meta( $post_id, 'show_first', sanitize_text_field( $_POST['show_first'] ) );
        
    } else {
        
        update_post_meta( $post_id, 'show_first', sanitize_text_field( 0 ) );
        
    }

    if ( wp_verify_nonce( $_POST['pronouns_nonce'], 'add_pronouns' ) ) {
        
        update_post_meta( $post_id, 'pronouns', sanitize_text_field( $_POST['pronouns'] ) );
        
    }
    
    if ( wp_verify_nonce( $_POST['interests_nonce'], 'add_interests' ) ) {
        
        update_post_meta( $post_id, 'member_interests', sanitize_text_field( $_POST['member_interests'] ) );
        
    }
    
    if ( wp_verify_nonce( $_POST['linkedin_network_nonce'], 'add_linkedin_network' ) ) {
        
        update_post_meta( $post_id, 'linkedin_username', sanitize_text_field( $_POST['linkedin_username'] ) );
        
    }
    
    if ( wp_verify_nonce( $_POST['twitter_network_nonce'], 'add_twitter_network' ) ) {
        
        update_post_meta( $post_id, 'twitter_username', sanitize_text_field( $_POST['twitter_username'] ) );
        
    }
    
    if ( wp_verify_nonce( $_POST['facebook_network_nonce'], 'add_facebook_network' ) ) {
        
        update_post_meta( $post_id, 'facebook_username', sanitize_text_field( $_POST['facebook_username'] ) );
        
    }
    
    if ( wp_verify_nonce( $_POST['youtube_network_nonce'], 'add_youtube_network' ) ) {
        
        update_post_meta( $post_id, 'youtube_username', sanitize_text_field( $_POST['youtube_username'] ) );
        
    }
    
    if ( wp_verify_nonce( $_POST['behance_network_nonce'], 'add_behance_network' ) ) {
        
        update_post_meta( $post_id, 'behance_username', sanitize_text_field( $_POST['behance_username'] ) );
        
    }
    
    if ( wp_verify_nonce( $_POST['github_network_nonce'], 'add_github_network' ) ) {
        
        update_post_meta( $post_id, 'github_username', sanitize_text_field( $_POST['github_username'] ) );
        
    }

}

function team_members_change_title_placeholder( $title ){
    
     $screen = get_current_screen();
  
     if  ( 'uws-team-members' == $screen->post_type ) {
          $title = 'Enter full name here';
     }
  
     return $title;
}

function add_team_members_custom_columns( $columns ) {
    
    $columns = array(
        'cb' => $columns['cb'],
        'avatar' => '',
        'title' => __( 'Title' ),
        'date' => __( 'Date' )
    );
    
    return $columns;
    
}

function add_team_members_custom_columns_value( $column, $post_id ) {
    
    switch ( $column ) {
        case 'avatar':

            if ( has_post_thumbnail() ) {
                echo '<img class="avatar-img" src="' . get_the_post_thumbnail_url() .'" />';
            }
    
    	break;
	}
    
}

/*------------------------------------*\
	HOMEPAGE META BOX
\*------------------------------------*/

function add_homepage_banner_metabox( ) {

    global $post;

    $currentTemplate = get_post_meta( $post->ID, '_wp_page_template', true );
    
    if ( 'page-home.php' == $currentTemplate ) {
        
       add_meta_box( 'homepage-header', 'Homepage Banner', 'homepage_banner_meta_box', 'page', 'normal', 'high' );
       
    }

}

function homepage_banner_meta_box( $post ) {
    
    wp_nonce_field( 'add_homepage_banner_title', 'homepage_banner_title_nonce' );
    echo '<p>Enter a headline to display over the homepage banner.</p>';
    echo '<input type="text" name="homepage_banner_title" value="' . get_post_meta( $post->ID, 'homepage_banner_title', true ) .'" />';
    
    wp_nonce_field( 'add_homepage_banner_content', 'homepage_banner_content_nonce' );
    echo '<p>Enter a short content to be displayed on the banner.</p>';

    wp_editor( get_post_meta( $post->ID, 'homepage_banner_content', true ), 'metaboxeditor', array( 'textarea_name' => 'homepage_banner_content', 'media_buttons' => false, 'quicktags' => false  ) );
    
}

function save_homepage_meta( $post_id, $post ) {
    
    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );
    
    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
        return $post_id;
    }
    
    if ( wp_verify_nonce( $_POST['homepage_banner_title_nonce'], 'add_homepage_banner_title' ) && isset( $_POST['homepage_banner_title'] ) ) {
        
        update_post_meta( $post_id, 'homepage_banner_title', sanitize_text_field( $_POST['homepage_banner_title'] ) );
        
    }
    
    if ( wp_verify_nonce( $_POST['homepage_banner_content_nonce'], 'add_homepage_banner_content' ) && isset( $_POST['homepage_banner_content'] ) ) {
        
        update_post_meta( $post_id, 'homepage_banner_content', $_POST['homepage_banner_content'] );
        
    }
    
}

/*------------------------------------*\
	SUB-LANDING HEADER META BOX
\*------------------------------------*/
function add_sublanding_header_metabox() {
    
    global $post;

    $currentTemplate = get_post_meta( $post->ID, '_wp_page_template', true );
    
    if ( 'page-members.php' == $currentTemplate 
    || 'page-sublanding.php' == $currentTemplate ) {
        
       add_meta_box( 'sublanding-header', 'Head Banner', 'sublanding_header_meta_box', 'page', 'normal', 'high' );
       
    }
    
}

function sublanding_header_meta_box( $post ) {

    wp_nonce_field( 'add_head_banner_content', 'head_banner_content_nonce' );
    echo '<p>Enter a short content to be displayed on the banner.</p>';

    wp_editor( get_post_meta( $post->ID, 'banner_content', true ), 'metaboxeditor', array( 'textarea_name' => 'banner_content', 'media_buttons' => false, 'quicktags' => false, 'tinymce' => array( 'toolbar1' => 'bold, italic', 'toolbar2' => '', 'toolbar3' => '' ) ) );
    
}

function save_sublanding_meta( $post_id, $post ) {
    
    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );
    
    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
        return $post_id;
    }
    
    if ( wp_verify_nonce( $_POST['head_banner_content_nonce'], 'add_head_banner_content' ) && isset( $_POST['banner_content'] ) ) {
        
        update_post_meta( $post_id, 'banner_content', $_POST['banner_content'] );
        
    }
    
}

/*------------------------------------*\
	LOAD SEARCH RESULTS
\*------------------------------------*/

function custom_search_query( $query ) {
    
    $groupId = get_post_meta( $_REQUEST['post_id'], 'post_group_id', true );
    
    if ( $groupId == false ) {
        
        $groupId = $_GET['post_group_id'];
        
    }
    
    if ( $query->is_search ) {
        
        $meta_query_args = array(
            array(
            'key' => 'post_group_id',
            'value' => $groupId,
            'compare' => 'LIKE',
            ),
        );
        
        $query->set( 'meta_query', $meta_query_args );
        
    };
    
}

/*------------------------------------*\
	REST SEARCH QUERY REGISTER
\*------------------------------------*/

function rest_search_query() {
    
    register_rest_route( 'uwsmedia/v2', '/autocomplete/', array(
        'methods' => 'POST',
        'callback' => 'autocomplete_query'
    ) );
    
    register_rest_route( 'uwsmedia/v2', '/member_projects/', array(
        'methods' => 'POST',
        'callback' => 'member_projects_query'
    ) );
    
    register_rest_route( 'uwsmedia/v2', '/media-showcases/', array(
        'methods' => 'POST',
        'callback' => 'media_showcase_projects_query'
    ) );

    register_rest_route( 'uwsmedia/v2', '/flex-showcases/', array(
        'methods' => 'POST',
        'callback' => 'flex_showcase_projects_query'
    ) );
    
}

function media_showcase_projects_query() {
    
    $postGroupId = get_post_meta( $_REQUEST['post_id'], 'post_group_id', true );
    $args = array(
        
        'post_type' => 'uws-projects',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        's' => '',
        'meta_query' => array(
            array(
                'key' => 'post_group_id',
                'value' => $postGroupId
            )
        ),
        'tax_query' => array()
        
    );
    
    if ( isset( $_POST['query'] ) ) {
        
        $args['s'] = $_POST['query'];
        
    }
    
    if ( isset( $_POST['programTags'] ) ) {
        
        array_push( $args['tax_query'], array(
            'taxonomy' => 'programs',
            'field' => 'slug',
            'terms' => explode( ',', $_POST['programTags'] )
        ) );
        
    }
    
    if ( isset( $_POST['classTags'] ) ) {
        
        array_push( $args['tax_query'], array(
            'taxonomy' => 'classifications',
            'field' => 'slug',
            'terms' => explode( ',', $_POST['classTags'] )
        ) );
        
    }
    
    if ( isset( $_POST['mediaTags'] ) ) {
        
        array_push( $args['tax_query'], array(
            'taxonomy' => 'media_types',
            'field' => 'slug',
            'terms' => explode( ',', $_POST['mediaTags'] )
        ) );
        
    }
    
    $search = new WP_Query( $args );
    
    ob_start();
    
    if ( $search->have_posts() ) :
        
        $keyword = '';
        
        if ( isset( $_POST['query'] ) ) {
    
            $keyword = urlencode( $_POST['query'] );
            
        }
        
    ?>

            <div class="sharings">
                
                <a class="btn btn-link btn-sm" href="<?php the_permalink(); ?>" role="button"><span class="fa fa-times-circle"></span> Clear Search</a>
                <button id="shareSearchLink" class="btn btn-secondary btn-sm"><span class="fa fa-link"></span> <span class="txt">Copy Search Link</span><input type="text" id="hiddenSearchLink" name="searchLink" value="<?php echo get_site_url() . '?s=' . $keyword . '&post_type=uws-projects&post_group_id=' . get_post_meta( $_REQUEST['post_id'], 'post_group_id', true ); ?>&programs=<?php echo $_POST['programTags']; ?>&classifications=<?php echo $_POST['classTags']; ?>&media_types=<?php echo $_POST['mediaTags']; ?>" /></button>
            </div>
            
            <div class="row d-flex flex-row">

		<?php while ( $search->have_posts() ) : $search->the_post(); ?>
				
				<div class="col-12 col-sm-12 col-md-6 col-lg-4 project">
                    <a href="<?php the_permalink(); ?>">
                        
                        <div class="project-bg">
                        <?php the_post_thumbnail(); ?>
                        </div>
                        
                        <div class="project-info">
                        <p class="categories"><?php 

                                $classification_terms = get_the_terms( $post->ID, 'classifications' );
            
                                if ( !is_array( $classification_terms ) || count( $classification_terms ) <= 0 ) {
                                    echo '<span aria-hidden="true">&nbsp;</span>';
                                } else {
                                    echo $classification_terms[0]->name;
                                }
                                
                            ?></p>
                        <h2 class="d-flex align-items-center justify-content-center"><?php the_title(); ?></h2>
                        <p class="categories"><?php 

                $media_type_terms = get_the_terms( $post->ID, 'media_types' );

                if ( !is_array( $media_type_terms ) || count( $media_type_terms ) <= 0 ) {
                    echo '<span aria-hidden="true">&mdash;</span>';
                } else {
                    echo strip_tags( get_the_term_list( $post->ID, 'media_types', '', ', ', '' ) );
                }
                
            ?></p>                        </div>
                        
                    </a>
                </div>
				
		<?php endwhile; ?>
		    </div>
<?php	else : ?>
            
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">No Search Results Found!</h4>
            <p>We couldn't find results with the following keyword or filters applied.</p>
            
            <?php
                    
                if ( isset( $_POST['query'] ) ) {
    
                    echo '<p>Keyword: <strong>' . $_POST['query'] . '</strong></p>';
                    
                }

                $filters = null;
                
                if ( isset( $_POST['programTags'] ) ) {
                    
                    $filters = is_array( $filters ) ? array_merge( $filters, explode( ',', $_POST['programTags'] ) ) : explode( ',', $_POST['programTags'] );
                    
                }
                
                if ( isset( $_POST['classTags'] ) ) {
                
                    $filters = is_array( $filters ) ? array_merge( $filters, explode( ',', $_POST['classTags'] ) ) : explode( ',', $_POST['classTags'] );
                    
                }
                
                if ( isset( $_POST['mediaTags'] ) ) {
        
                    $filters = is_array( $filters ) ? array_merge( $filters, explode( ',', $_POST['mediaTags'] ) ) : explode( ',', $_POST['mediaTags'] );
                    
                }
                
                if ( is_array( $filters ) && count( $filters ) >= 1 ) {
                    
                    echo '<p>Try removing some these filters:<br>';
                    
                    foreach ( $filters as $filter ) {
                    
                        echo '<span class="badge badge-light">' . $filter . '</span> ';
                        
                    }
                    
                    echo '</p>';
                    
                }
                
                unset( $filters );
                
            ?>
            
            <hr>
            <p class="mb-0 text-center"><a class="btn btn-link" href="<?php the_permalink(); ?>"><span class="fa fa-times"></span> Clear Search</a></p>
        </div>
		
	<?php endif;
	
	$content = ob_get_clean();
	
	echo json_encode( $content );
	die();
			
}

function flex_showcase_projects_query() {
    
    $postGroupId = get_post_meta( $_REQUEST['post_id'], 'post_group_id', true );
    $args = array(
        
        'post_type' => 'uws-flex-projects',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        's' => '',
        'meta_query' => array(
            array(
                'key' => 'post_group_id',
                'value' => $postGroupId
            )
        ),
        'tax_query' => array()
        
    );
    
    if ( isset( $_POST['query'] ) ) {
        
        $args['s'] = $_POST['query'];
        
    }
    
    
    if ( isset( $_POST['classTags'] ) ) {
        
        array_push( $args['tax_query'], array(
            'taxonomy' => 'flex_classifications',
            'field' => 'slug',
            'terms' => explode( ',', $_POST['classTags'] )
        ) );
        
    }
    
    if ( isset( $_POST['mediaTags'] ) ) {
        
        array_push( $args['tax_query'], array(
            'taxonomy' => 'flex_media_types',
            'field' => 'slug',
            'terms' => explode( ',', $_POST['mediaTags'] )
        ) );
        
    }
    
    $search = new WP_Query( $args );
    
    ob_start();
    
    if ( $search->have_posts() ) :
        
        $keyword = '';
        
        if ( isset( $_POST['query'] ) ) {
    
            $keyword = urlencode( $_POST['query'] );
            
        }
        
    ?>

            <div class="sharings">
                
                <a class="btn btn-link btn-sm" href="<?php the_permalink(); ?>" role="button"><span class="fa fa-times-circle"></span> Clear Search</a>
                <button id="shareSearchLink" class="btn btn-secondary btn-sm"><span class="fa fa-link"></span> <span class="txt">Copy Search Link</span><input type="text" id="hiddenSearchLink" name="searchLink" value="<?php echo get_site_url() . '?s=' . $keyword . '&post_type=uws-flex-projects'?>&flex_classifications=<?php echo $_POST['classTags']; ?>&flex_media_types=<?php echo $_POST['mediaTags']; ?>" /></button>
            </div>
            
            <div class="row d-flex flex-row">

		<?php while ( $search->have_posts() ) : $search->the_post(); ?>
				
				<div class="col-12 col-sm-12 col-md-6 col-lg-4 project">
                    <a href="<?php the_permalink(); ?>">
                        
                        <div class="project-bg">
                        <?php the_post_thumbnail(); ?>
                        </div>
                        
                        <div class="project-info">
                        <p class="categories"><?php 

                                $classification_terms = get_the_terms( $post->ID, 'flex_classifications' );
            
                                if ( !is_array( $classification_terms ) || count( $classification_terms ) <= 0 ) {
                                    echo '<span aria-hidden="true">&nbsp;</span>';
                                } else {
                                    echo $classification_terms[0]->name;
                                }
                                
                            ?></p>
                        <h2 class="d-flex align-items-center justify-content-center"><?php the_title(); ?></h2>
                        <p class="categories"><?php 

                $media_type_terms = get_the_terms( $post->ID, 'flex_media_types' );

                if ( !is_array( $media_type_terms ) || count( $media_type_terms ) <= 0 ) {
                    echo '<span aria-hidden="true">&mdash;</span>';
                } else {
                    echo strip_tags( get_the_term_list( $post->ID, 'flex_media_types', '', ', ', '' ) );
                }
                
            ?></p>                        </div>
                        
                    </a>
                </div>
				
		<?php endwhile; ?>
		    </div>
<?php	else : ?>
            
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">No Search Results Found!</h4>
            <p>We couldn't find results with the following keyword or filters applied.</p>
            
            <?php
                    
                if ( isset( $_POST['query'] ) ) {
    
                    echo '<p>Keyword: <strong>' . $_POST['query'] . '</strong></p>';
                    
                }

                $filters = null;
                
                if ( isset( $_POST['classTags'] ) ) {
                
                    $filters = is_array( $filters ) ? array_merge( $filters, explode( ',', $_POST['classTags'] ) ) : explode( ',', $_POST['classTags'] );
                    
                }
                
                if ( isset( $_POST['mediaTags'] ) ) {
        
                    $filters = is_array( $filters ) ? array_merge( $filters, explode( ',', $_POST['mediaTags'] ) ) : explode( ',', $_POST['mediaTags'] );
                    
                }
                
                if ( is_array( $filters ) && count( $filters ) >= 1 ) {
                    
                    echo '<p>Try removing some these filters:<br>';
                    
                    foreach ( $filters as $filter ) {
                    
                        echo '<span class="badge badge-light">' . $filter . '</span> ';
                        
                    }
                    
                    echo '</p>';
                    
                }
                
                unset( $filters );
                
            ?>
            
            <hr>
            <p class="mb-0 text-center"><a class="btn btn-link" href="<?php the_permalink(); ?>"><span class="fa fa-times"></span> Clear Search</a></p>
        </div>
		
	<?php endif;
	
	$content = ob_get_clean();
	
	echo json_encode( $content );
	die();
			
}

/*------------------------------------*\
	AUTOCOMPLETE SEARCH (VIA REST)
\*------------------------------------*/

function autocomplete_query() {
    
    $args = array(
        
        'post_type' => 'page',
        'post_status' => 'publish',
        'nopaging' => true,
        'posts_per_page' => 50,
        's' => '',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'post_group_id',
                'value' => get_post_meta( $_POST['post_id'], 'post_group_id', true ),
                'compare' => '='
            )
        )
        
    );
    
    if ( isset( $_POST['keyword']  ) ) {
        $args['s'] = stripslashes( $_POST['keyword'] );
    }
    
    ob_start();
    
    $query = new WP_Query( $args );
    $data = array();
    
    if ( $query->have_posts() ) {

        while ( $query->have_posts() ) {
            
            $query->the_post();
            $post = new AutoCompleteTerm();
    		$post->title = get_the_title();
    		$post->link = get_the_permalink();
    		
    		$data[] =  $post;
            
        }

    }
    
    wp_send_json_success( $data );
    wp_reset_postdata();
    ob_get_clean();
    die();
    
}

class AutoCompleteTerm implements JsonSerializable {
    
    public $title = '';
    public $link = '';
    
    public function jsonSerialize () {
        return array(
            'title'=>$this->title,
            'link'=>$this->link
        );
    }
}

/*------------------------------------*\
	LOAD MEMBER PROJECTS
\*------------------------------------*/
function member_projects_query() {
    
    $memberId = $_REQUEST['post_id'];
    $paged = ( $_REQUEST['page_num'] ) ? $_REQUEST['page_num'] : 1;
    $query_args = array(
        'post_type' => 'uws-projects',
        'post_status' => 'publish',
        'posts_per_page' => 8,
        'paged' => $paged,
        'meta_query' => array(
            
            array(
                'key' => 'project_authors',
                'value' => $memberId,
                'compare' => 'LIKE'
            )
            
        )
    );
    
    $projects = new WP_Query( $query_args );
    
    ob_start();
    
    if ( $projects->have_posts() ) : ?>
                
        <div id="projects-archive">
            
            <h5 class="archive-title"><span aria-hidden="true">&mdash; </span>Projects<span aria-hidden="true"> &mdash;</span></h5>
            
            <div class="row d-flex flex-row">
                
            <?php while( $projects->have_posts() ) : $projects ->the_post(); ?>
            
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 project">
                
                <a href="<?php the_permalink(); ?>">
                    
                    <div class="project-bg">
                    <?php the_post_thumbnail(); ?>
                    </div>
                    <div class="project-info">
                        
                    <?php
                    
                    $class = '<span aria-hidden="true">&nbsp;</span>';
                    $class_terms = get_the_terms( $post->ID, 'classifications' );

                    if ( is_array( $class_terms ) 
                    && count( $class_terms ) >= 1 ) {
                        $class = $class_terms[0]->name;
                        
                    }
                        
                    ?>
                    
                    <p class="categories"><?php echo $class; ?></p>
                    
                    <?php
                        
                        $title = get_the_title();
                        $maxPos = 70;
                    
                        if ( strlen( $title ) > $maxPos ) {
                        
                            $lastPos = ( $maxPos - 3 ) - strlen( $title );
                            $title = substr( $title, 0, strrpos( $title, ' ', $lastPos ) ) . '...';
                        
                        }
                        
                    ?>
                    
                    <h2 class="d-flex align-items-center justify-content-center"><?php echo $title ?></h2>
                    
                    <?php
                        
                        $terms = '<span aria-hidden="true">&nbsp;</span>';
                        $media_terms = get_the_terms( $post->ID, 'media_types' );
    
                        if ( is_array( $media_terms ) 
                        && count( $media_terms ) >= 1 ) {
                            
                            $terms = strip_tags( get_the_term_list( $post->ID, 'media_types', '', ', ', '' ) );
                            
                        }
                        
                    ?>
                    
                    <p class="categories"><?php echo $terms; ?></p>
                    
                    </div>
                    
                </a>
                
            </div>
            
            <?php endwhile; ?>
                
            </div> <!-- end row -->
            
            <div class="projects-pagnigation">
            <?php
                
                $total_pages = $projects->max_num_pages;
                $current_page = max( 1, $paged );

                echo paginate_links( array(
                    'base' => '%_%',
                    'format' => '?page=%#%',
                    'current' => $current_page,
                    'total' => $total_pages,
                    'prev_text'    => __('<span class="fa fa-chevron-left"></span> <span class="screen-reader-text">previous</span>'),
                    'next_text'    => __('<span class="fa fa-chevron-right"></span> <span class="screen-reader-text">next</span>'),
                    'show_all' => true,
                    'type' => 'list'
                ) );
            ?>
            </div>
            
        </div> <!-- end projects -->
                
        <?php 
                wp_reset_postdata();
            endif;
            
    $content = ob_get_clean();
	
	echo json_encode( $content );
	die();
    
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
        
        if ( in_array('current-menu-item', $classes) ) {
            $classes[] = 'active';
        } else if( in_array('current-menu-parent', $classes) ) {
            $classes[] = 'active';
        } else if( in_array('current-menu-ancestor', $classes) ) {
            $classes[] = 'active';
        }
        
        // echo 'test: '. get_post_meta( $item->object_id, 'post_group_id', true )->post_name;
        // if ( !empty( get_post_meta( $item->object_id, 'post_group_id', true ) ) ) {
        //     $classes[] = get_post( get_post_meta( $item->object_id, 'post_group_id', true ) )->post_name . '-group-item';
        // }
        
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
        
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
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
    
    // Livestream post type
    if ( defined( 'Tribe__Events__Main' ) ) {
        $livestreamPostType = 'tribe_events';
        $livestreamOptions = get_option(Tribe__Events__Main::OPTIONNAME, array());
    }
    
    // Podcast post type
    $podcastPostType = 'podcast';

      
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
            
            if ( $post->post_type == $livestreamPostType ) {
                
                echo '<li class="item-current item-archive">' . ucfirst($livestreamOptions['eventsSlug']) .'</li>';
                
            } else {
                echo '<li class="item-current item-archive">' . post_type_archive_title($prefix, false) . '</li>';
            }
              
        } else if ( is_archive() && is_tax() && is_search() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive">Search Results</li>';
              
        } else if ( is_single() ) {
            
            // if ( $post->post_type == 'uws-projects' ) {
                
            //     $group = get_post_meta( $post->ID, 'post_group_id', true );
            //     $title = get_the_title( $group );
                
            //     if ( strpos( strtolower( $title ), 'faculty' ) !== false ) {
                    
            //         $url = get_site_url() . '/faculty/faculty-showcase/';
            //         echo '<li class="item-current"><a class="bread-parent bread-parent-faculty-showcase" href="' . $url . '" title="Faculty Showcase">Faculty Showcase</a></li>';
            //         echo '<li class="separator">' . $separator . ' </li>';
                    
            //     }
                
            // }
            
            if ( $post->post_type == 'uws-team-members' ) {
                
                echo '<li class="item-current"><a class="bread-parent bread-parent-team" href="'.get_site_url().'/team/" title="The Team">The Team</a></li>';
                 echo '<li class="separator"> ' . $separator . ' </li>';
                
            }
            
            if ( $post->post_type == $livestreamPostType ) {
                
                $lsTitle = ucfirst($livestreamOptions['eventsSlug']);
                echo '<li class="item-current"><a class="bread-parent bread-parent-about" href="' . get_post_type_archive_link($post->post_type) . '" title="'.$lsTitle.'">' . $lsTitle .'</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                
            }
            
            if ( $post->post_type == $podcastPostType ) {
                
                $postType = get_post_type_object(get_post_type($post));
                $postTypeName = $postType->labels->name;
                
                echo '<li class="item-current"><a class="bread-parent bread-parent-about" href="' . get_post_type_archive_link($post->post_type) . '" title="'.$postTypeName.'">' . $postTypeName .'</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                
            }
            
            echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';
              
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ) {
                   
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
               
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '">Search results for: ' . get_search_query() . '</li>';
           
        } else if ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
       
}

?>
