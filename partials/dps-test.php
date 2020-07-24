<?php
/**
 * "Small" layout for Display Posts Shortcode
 *
 * @package      StudyFinds2018
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

echo '<article class="post-summary small">';
	echo '<a class="entry-image-link" href="' . get_permalink() . '">' . wp_get_attachment_image( ea_entry_image_id(), 'ea_archive' ) . '</a>';
	echo '<h2 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
echo '</article>';