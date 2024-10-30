<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DICH_Admin {
	public function __construct() {
		if ( ! class_exists( 'ET_Builder_Element' ) ) {
			add_action( 'admin_notices', array( $this, 'divi_theme_is_required' ) );
		}
	}

	public function divi_theme_is_required() {
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( "You don't have Divi Theme installed. Please install & activate Divi Theme to use Divi Charts.", 'dich-divi-charts' ); ?></p>
		</div>
		<?php
	}
}

new DICH_Admin();