<?php
/**
 * Inkness functions and definitions
 *
 * @package UWEX-Media
 */

/**
 * Initialize Options Panel
 */
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once get_template_directory() . '/inc/options-framework.php';
}

if ( ! function_exists( 'uwex_media_setup' ) ) :

function uwex_media_setup() {

	load_theme_textdomain( 'uwex-media', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_image_size('homepage-banner',750,450,true);

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'uwex-media' ),
		'secondary' => __( 'Secondary Menu', 'uwex-media' ),
	) );

	add_theme_support( 'custom-background', apply_filters( 'uwex_media_custom_background_args', array(
		'default-color' => 'f7f7f7',
		'default-image' => '',
	) ) );

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	 global $content_width;
	 if ( ! isset( $content_width ) )
		$content_width = 640; /* pixels */

	add_editor_style();
}

endif; // uwex_media_setup

add_action( 'after_setup_theme', 'uwex_media_setup' );

function uwex_media_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'uwex-media' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Left', 'uwex-media' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Center', 'uwex-media' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Right', 'uwex-media' ),
		'id'            => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'uwex_media_widgets_init' );

add_action('optionsframework_custom_scripts', 'uwex_media_custom_scripts');

function uwex_media_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});

	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}

});
</script>

<?php
}

function uwex_media_scripts() {
	wp_enqueue_style( 'uwex-media-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,700,600' );
	wp_enqueue_style( 'uwex-media-basic-style', get_stylesheet_uri() );
	if ( (function_exists( 'of_get_option' )) && (of_get_option('sidebar-layout', true) != 1) ) {
		if (of_get_option('sidebar-layout', true) ==  'right') {
			wp_enqueue_style( 'uwex-media-layout', get_template_directory_uri()."/css/layouts/content-sidebar.css" );
		}
		else {
			wp_enqueue_style( 'uwex-media-layout', get_template_directory_uri()."/css/layouts/sidebar-content.css" );
		}
	}
	else {
		wp_enqueue_style( 'uwex-media-layout', get_template_directory_uri()."/css/layouts/content-sidebar.css" );
	}

	wp_enqueue_style( 'uwex-media-bootstrap-style', get_template_directory_uri()."/css/bootstrap/bootstrap.min.css", array('uwex-media-layout') );

	wp_enqueue_style( 'uwex-media-main-style', get_template_directory_uri()."/css/skins/main.css", array('uwex-media-layout','uwex-media-bootstrap-style') );

	wp_enqueue_script( 'uwex-media-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'uwex-media-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'uwex-media-superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery','hoverIntent') );

	wp_enqueue_script( 'uwex-media-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery') );

	wp_enqueue_script( 'uwex-media-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery') );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'uwex-media-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'uwex_media_scripts' );
function uwex_media_custom_head_codes() {
 if ( (function_exists( 'of_get_option' )) && (of_get_option('style2', true) != 1) ) {
	echo "<style>".of_get_option('style2', true)."</style>";
 }
}
add_action('wp_head', 'uwex_media_custom_head_codes');

function uwex_media_nav_menu_args( $args = '' )
{
    $args['container'] = false;
    return $args;
} // function
add_filter( 'wp_page_menu_args', 'uwex_media_nav_menu_args' );

function uwex_media_pagination() {
	global $wp_query;
	$big = 12345678;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $wp_query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
	            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
	            echo '<div class="pagination"><div><ul>';
	            echo '<li><span>'. $paged . ' of ' . $wp_query->max_num_pages .'</span></li>';
	            foreach ( $page_format as $page ) {
	                    echo "<li>$page</li>";
	            }
	           echo '</ul></div></div>';
	 }
}

/**
 * Include breadcrumb
 */
 include_once 'breadcrumb.php';

/**
 * Custom private page
 */
 function title_format( $content ) {
     return ' <span class="glyphicon glyphicon-lock"></span> ' . '%s';
 }
add_filter('private_title_format', 'title_format');
add_filter('protected_title_format', 'title_format');

/**
 * Custom read more link
 */
function new_excerpt_more( $more ) {
	return '... <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('continue reading »', 'uwex-media') . '</a>';
}

add_filter( 'excerpt_more', 'new_excerpt_more' );

function new_excerpt_length( $length ) {
	return 26;
}
add_filter( 'excerpt_length', 'new_excerpt_length', 998 );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates. Import Widgets
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load shortcode
 */
 require get_template_directory() . '/shortcodes.php';

