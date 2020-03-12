<?php
/**
 * Single Event Meta (Organizer) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/organizer.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */

$organizer_ids = tribe_get_organizer_ids();
$multiple = count( $organizer_ids ) > 1;
$label = $multiple ? 'Presenters' : 'Presenter';
?>

<div class="tribe-events-meta-group tribe-events-meta-group-organizer">
	<h2 class="tribe-events-single-section-title"><?php echo $label ?></h2>
		<?php
		do_action( 'tribe_events_single_meta_organizer_section_start' );

		foreach ( $organizer_ids as $organizer ) {
			if ( ! $organizer ) {
				continue;
			}

			?>
			<h3 class="tribe-organizer"><?php echo tribe_get_organizer_link( $organizer ); ?></h3>
			
			<div class="organizer-description">
                <?php
                    $content = apply_filters('the_content', get_post_field('post_content', $organizer));
        		    echo $content;	
                ?>
			</div>
			<div class="organizer-contacts tribe-clearfix">
    			<p>
    			<?php
        			$phone = tribe_get_event_meta( tribe_get_organizer_id( $organizer ), '_OrganizerPhone', true );
        			if ( ! empty( $phone ) ) {
            			echo 'Phone: ' . esc_html( $phone ); 
        			}
                ?>
                <?php
                    $email = tribe_get_event_meta( tribe_get_organizer_id( $organizer ), '_OrganizerEmail', true );
        			if ( ! empty( $email ) ) {
            			echo '<br>Email: ' . esc_html( $email ); 
        			}
                ?>
                <?php
                    $website = tribe_get_organizer_website_link($organizer);
        			if ( ! empty( $website ) ) {
            			echo '<br>Website: ' . $website; 
        			}
                ?>
    			</p>
			</div>
    			
			<?php
		}

		do_action( 'tribe_events_single_meta_organizer_section_end' );
		?>

</div>
