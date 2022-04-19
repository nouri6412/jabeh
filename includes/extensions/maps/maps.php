<?php

namespace MyListing\Ext\Maps;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Maps {
	use \MyListing\Src\Traits\Instantiatable;

	public
		$platform,
		$geocoder;

	private $platforms = [
		'google-maps' => 'Google_Maps',
		'mapbox' => 'Mapbox'
	];

	public function __construct() {

		// Initialize Maps.
		add_action( 'init', [ $this, 'initialize' ], 30 );
        add_filter( 'mylisting/localize-data', [ $this, 'localize_data' ], 20 );

		// Include marker HTML templates.
		add_action( 'mylisting/get-footer', [ $this, 'include_templates' ], 25 );
		add_action( 'admin_footer', [ $this, 'include_templates' ], 25 );
	}

	public function initialize() {
		$platform = mylisting()->get( 'maps.provider', 'google-maps' );

		if ( CASE27_ENV === 'dev' && ! empty( $_GET['maps:provider'] ) ) {
			$platform = $_GET['maps:provider'];
		}

		if ( ! in_array( $platform, array_keys( $this->platforms ) ) ) {
			return false;
		}

		$maps = sprintf( '\MyListing\Ext\Maps\Platforms\%s\%s::instance', $this->platforms[ $platform ], $this->platforms[ $platform ] );
		$geocoder = sprintf( '\MyListing\Ext\Maps\Platforms\%s\Geocoder::instance', $this->platforms[ $platform ] );

		$this->platform = call_user_func( $maps );
		$this->geocoder = call_user_func( $geocoder );

		mylisting()->register( 'mapservice', $this->platform );
		mylisting()->register( 'geocoder', $this->geocoder );
	}

	public function include_templates() {
    	c27()->get_partial( 'marker-templates' );
	}

	public function localize_data( $data ) {
		$data['MapConfig'] = [];

		/**
		 * Since v2.4.4, clusters can be completely disabled using
		 * `add_filter( 'mylisting/maps/cluster-size', '__return_zero' );`
		 */
		$data['MapConfig']['ClusterSize'] = apply_filters( 'mylisting/maps/cluster-size', 35 );
		return $data;
	}
}