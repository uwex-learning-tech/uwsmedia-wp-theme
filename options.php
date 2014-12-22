<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'uwex-media'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	$options = array();
	$imagepath =  get_template_directory_uri() . '/images/';

	//Basic Settings

	$options[] = array(
		'name' => __('Basic Settings', 'uwex-media'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Site Logo', 'uwex-media'),
		'desc' => __('Leave Blank to use text Heading.', 'uwex-media'),
		'id' => 'logo',
		'class' => '',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Copyright Text', 'uwex-media'),
		'desc' => __('Some Text regarding copyright of your site, you would like to display in the footer.', 'uwex-media'),
		'id' => 'footertext2',
		'std' => '',
		'type' => 'text');

	//Design Settings

	$options[] = array(
		'name' => __('Layout Settings', 'uwex-media'),
		'type' => 'heading');

	$options[] = array(
		'name' => "Sidebar Layout",
		'desc' => "Select Layout for Posts & Pages.",
		'id' => "sidebar-layout",
		'std' => "right",
		'type' => "images",
		'options' => array(
			'left' => $imagepath . '2cl.png',
			'right' => $imagepath . '2cr.png')
	);

	$options[] = array(
		'name' => __('Custom CSS', 'uwex-media'),
		'desc' => __('Some Custom Styling for your site. Place any css codes here instead of the style.css file.', 'uwex-media'),
		'id' => 'style2',
		'std' => '',
		'type' => 'textarea');

	//Social Settings

	$options[] = array(
	'name' => __('Social Settings', 'inkness'),
	'type' => 'heading');

	$options[] = array(
		'name' => __('Facebook', 'uwex-media'),
		'desc' => __('Facebook Profile or Page URL i.e. http://facebook.com/username/ ', 'uwex-media'),
		'id' => 'facebook',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Twitter', 'uwex-media'),
		'desc' => __('Twitter Username', 'uwex-media'),
		'id' => 'twitter',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Google Plus', 'uwex-media'),
		'desc' => __('Google Plus profile url, including "http://"', 'uwex-media'),
		'id' => 'google',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Feeburner', 'uwex-media'),
		'desc' => __('URL for your RSS Feeds', 'uwex-media'),
		'id' => 'feedburner',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Pinterest', 'uwex-media'),
		'desc' => __('Your Pinterest Profile URL', 'uwex-media'),
		'id' => 'pinterest',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Instagram', 'uwex-media'),
		'desc' => __('Your Instagram Profile URL', 'uwex-media'),
		'id' => 'instagram',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Linked In', 'uwex-media'),
		'desc' => __('Your Linked In Profile URL', 'uwex-media'),
		'id' => 'linkedin',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Youtube', 'uwex-media'),
		'desc' => __('Your Youtube Channel URL', 'uwex-media'),
		'id' => 'youtube',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Flickr', 'uwex-media'),
		'desc' => __('Your Flickr Profile URL', 'uwex-media'),
		'id' => 'flickr',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');

	return $options;
}