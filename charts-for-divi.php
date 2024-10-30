<?php
/**
 * Plugin Name: Charts for Divi
 * Plugin URI:  https://wordpress.org/plugins/dich-divi-charts/
 * Description: Elevate your website with Charts for Divi plugin, featuring custom creative modules for stunning chart creation.
 * Version:     1.0.0
 * Author:      Hridoy Mozumder
 * Author URI:  https://vsportfolio.vercel.app/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: charts-for-divi
 * Domain Path: /languages
 *
 * @package     Charts for Divi
 * @author      Hridoy Mozumder
 * @license     GPL-2.0+
 *
 * Charts for Divi is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Charts for Divi is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Charts for Divi. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'You are not allowed here.' );
}

if ( ! class_exists( 'DICH_Divi_Chart' ) ) {
	final class DICH_Divi_Chart {
		const DICH_VERSION = '1.0.0';

		public function __construct() {
			$this->define_constants();
			register_activation_hook( __FILE__, array( $this, 'activate' ) );
			add_action( 'divi_extensions_init', array( $this, 'init_plugin' ) );
			add_action( 'admin_init', array( $this, 'init_admin' ) );
		}

		/**
		 * Initializes a singleton instance
		 *
		 * @return \DICH_Divi_Chart
		 */
		public static function instance() {
			static $instance = false;
			if ( ! $instance ) {
				$instance = new self();
			}
			return $instance;
		}

		/**
		 * Defining constants
		 */
		private function define_constants() {
			define( 'DICH_VERSION', self::DICH_VERSION );
			define( 'DICH_ASSETS_URI', plugin_dir_url( __FILE__ ) . 'assets' );
		}

		/**
		 * Creates the extension's main class instance.
		 *
		 * @since 1.0.0
		 */
		public function init_plugin() {
			require_once plugin_dir_path( __FILE__ ) . 'includes/Asset.php';
			require_once plugin_dir_path( __FILE__ ) . 'includes/DiviCharts.php';
			$this->load_textdomain();
		}

		public function init_admin() {
			if ( is_admin() ) {
				require_once plugin_dir_path( __FILE__ ) . 'includes/Admin.php';
			}
		}

		/**
		 * Loads the translation file
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'dich-divi-charts', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Fires when activated the plugin
		 */
		public function activate() {
			$installed = get_option( 'dich_divi_chart_installed' );
			if ( ! $installed ) {
				update_option( 'dich_divi_chart_installed', time() );
			}
			update_option( 'dich_divi_chart_version', self::DICH_VERSION );
		}
	}
}

if ( ! function_exists( 'dich_divi_chart_start' ) ) {
	function dich_divi_chart_start() {
		return \DICH_Divi_Chart::instance();
	}
}
dich_divi_chart_start();
