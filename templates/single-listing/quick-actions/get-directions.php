<?php
/**
 * `Get Directions` quick action.
 *
 * @since 2.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
}

$link = \MyListing\get_directions_link( [
	'lat' => $listing->get_data('geolocation_lat'),
	'lng' => $listing->get_data('geolocation_long'),
	'address' => $listing->get_field('location'),
] );

if ( ! $link ) {
	return;
} ?>

<li id="<?php echo esc_attr( $action['id'] ) ?>" class="<?php echo esc_attr( $action['class'] ) ?>">
    <a href="<?php echo esc_url( $link ) ?>" target="_blank">
    	<?php echo c27()->get_icon_markup( $action['icon'] ) ?>
    	<span><?php echo $action['label'] ?></span>
    </a>
</li>