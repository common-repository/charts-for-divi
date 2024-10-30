<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DICH_Assets {
	/**
	 * Constructor function
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'plugin_scripts' ) );
	}

	/**
	 * Register/Enqueue stylesheet/scripts
	 */
	public function plugin_scripts() {
		wp_register_script( 'dich_charts', DICH_ASSETS_URI . '/js/dich-charts.min.js', array( 'jquery' ), DICH_VERSION, false );
		wp_register_script( 'dich_line_chart', DICH_ASSETS_URI . '/js/dich-line-chart.js', array( 'jquery' ), DICH_VERSION, true );
	}
}

new DICH_Assets();
