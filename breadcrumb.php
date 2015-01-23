<?php
function simple_breadcrumb() {

    global $post;

    echo '<ol class="breadcrumb">';
	if ( !is_home() ) {

		echo '<li><a href="';
		echo get_option('home');
		echo '">';
		bloginfo('name');
		echo "</a></li>";

		if ( is_category() || is_single() ) {

            the_title('<li class="active">','</li>');

		} elseif ( is_page() && $post->post_parent ) {

			$home = get_page(get_option('page_on_front'));

			for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
				if (($home->ID) != ($post->ancestors[$i])) {
					echo '<li><a href="';
					echo get_permalink($post->ancestors[$i]);
					echo '">';
					echo get_the_title($post->ancestors[$i]);
					echo "</a></li>";
				}
			}

			echo the_title('<li class="active">','</li>');

		} elseif ( is_page() ) {

			echo the_title('<li class="active">','</li>');

		} elseif ( is_404() ) {

			echo '<li class="active">404</li>';

		}

	} else {

		echo "<li class='active'>". get_the_title( get_option( 'page_for_posts' ) ) ."</li>";

	}

	echo '</ol>';
}
?>