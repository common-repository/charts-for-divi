<?php
/**
 * Divi Line Chart Class
 *
 * @package Divi Line Chart
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
#[AllowDynamicProperties]
class DICH_Line_Chart extends ET_Builder_Module {

	public $slug       = 'dich_line_chart';
	public $vb_support = 'on';
	public $child_slug = 'dich_line_chart_item';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'Hridoy Mozumder',
		'author_uri' => '',
	);

	/**
	 * Initialize Divi Line Chart Module
	 */
	public function init() {
		$this->name = esc_html__( 'Divi Line Chart', 'dich-divi-charts' );

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'chart_settings'   => esc_html__( 'Chart Settings', 'dich-divi-charts' ),
					'toolbar_settings' => esc_html__( 'Toolbar Settings', 'dich-divi-charts' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'theme_settings' => esc_html__( 'Theme Settings', 'dich-divi-charts' ),
				),
			),
		);
	}

	/**
	 * Advanced Fields Configuration
	 */
	public function get_advanced_fields_config() {
		return array(
			'text'         => false,
			'link_options' => false,
			'fonts'        => false,
			'height'       => array(
				'css'     => array(
					'main' => '%%order_class%% .et_pb_module_inner .dich-charts-line',
				),
				'options' => array(
					'height' => array(
						'default' => '350px',
					),
				),
			),
			'min-height'   => array(
				'css'     => array(
					'main' => '%%order_class%% .et_pb_module_inner .dich-charts-line',
				),
				'options' => array(
					'height' => array(
						'default' => '350px',
					),
				),
			),
		);
	}

	/**
	 * Custom Fields Configuration
	 */
	public function get_fields() {
		$chart = array(
			'categories'           => array(
				'label'           => esc_html__( 'Categories', 'dich-divi-charts' ),
				'description'     => esc_html__( 'Define your data categories separate by commas. Ex. 1991,1992,1993 etc.', 'dich-divi-charts' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'chart_settings',
			),
			'chart_line_type'      => array(
				'label'           => esc_html__( 'Chart Line Type', 'dich-divi-charts' ),
				'description'     => esc_html__( "Choose your preferred line appearance. By default, it's a straight line.", 'dich-divi-charts' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'straight' => esc_html__( 'Straight', 'dich-divi-charts' ),
					'smooth'   => esc_html__( 'Smooth', 'dich-divi-charts' ),
					'stepline' => esc_html__( 'Stepline', 'dich-divi-charts' ),
				),
				'default'         => 'straight',
				'toggle_slug'     => 'chart_settings',
			),
			'show_data_labels'     => array(
				'label'            => esc_html__( 'Show Data Labels', 'dich-divi-charts' ),
				'type'             => 'yes_no_button',
				'description'      => esc_html__( "Please select 'Enable' to display the Data Labels or 'Disable' to hide it..", 'dich-divi-charts' ),
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'dich-divi-charts' ),
					'off' => esc_html__( 'No', 'dich-divi-charts' ),
				),
				'default'          => 'off',
				'default_on_front' => 'off',
				'toggle_slug'      => 'chart_settings',
			),
			'legend_position'      => array(
				'label'           => esc_html__( 'Legend Position', 'dich-divi-charts' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'top'    => esc_html__( 'Top', 'dich-divi-charts' ),
					'right'  => esc_html__( 'Right', 'dich-divi-charts' ),
					'bottom' => esc_html__( 'Bottom', 'dich-divi-charts' ),
					'left'   => esc_html__( 'Left', 'dich-divi-charts' ),
				),
				'default'         => 'top',
				'toggle_slug'     => 'chart_settings',
			),
			'show_vertical_labels' => array(
				'label'            => esc_html__( 'Show Each Vertical Data Labels', 'dich-divi-charts' ),
				'type'             => 'yes_no_button',
				'description'      => esc_html__( "Please select 'Enable' to display the Vertical Data Labels and Vertical Border for each individual data series or 'Disable' to hide it..", 'dich-divi-charts' ),
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'dich-divi-charts' ),
					'off' => esc_html__( 'No', 'dich-divi-charts' ),
				),
				'default'          => 'off',
				'default_on_front' => 'off',
				'toggle_slug'      => 'chart_settings',
			),
			'show_markers'         => array(
				'label'            => esc_html__( 'Show Markers', 'dich-divi-charts' ),
				'type'             => 'yes_no_button',
				'description'      => esc_html__( "Please select 'Enable' to display marker in the line or 'Disable' to hide it.", 'dich-divi-charts' ),
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'dich-divi-charts' ),
					'off' => esc_html__( 'No', 'dich-divi-charts' ),
				),
				'default'          => 'off',
				'default_on_front' => 'off',
				'toggle_slug'      => 'chart_settings',
			),
			'marker_size'          => array(
				'label'           => esc_html__( 'Marker Size', 'dich-divi-charts' ),
				'description'     => esc_html__( 'Define the size of the marker. Default is 10.', 'dich-divi-charts' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '10',
				'fixed_unit'      => '',
				'validate_unit'   => false,
				'toggle_slug'     => 'chart_settings',
				'show_if'         => array(
					'show_markers' => 'on',
				),
			),
		);

		$toolbar = array(
			'use_options' => array(
				'label'            => esc_html__( 'Use Options', 'dich-divi-charts' ),
				'description'      => esc_html__( 'Choose what tools to include in the Line Charts.', 'dich-divi-charts' ),
				'type'             => 'multiple_checkboxes',
				'option_category'  => 'configuration',
				'options'          => array(
					'download' => esc_html__( 'Download', 'dich-divi-charts' ),
					'zoom'     => esc_html__( 'Zoom', 'dich-divi-charts' ),
					'zoomin'   => esc_html__( 'Zoom In', 'dich-divi-charts' ),
					'zoomout'  => esc_html__( 'Zoom Out', 'dich-divi-charts' ),
					'pan'      => esc_html__( 'Pan', 'dich-divi-charts' ),
					'reset'    => esc_html__( 'Reset', 'dich-divi-charts' ),
				),
				'default'          => 'on|on|on|on|on|on',
				'default_on_front' => 'on|on|on|on|on|on',
				'toggle_slug'      => 'toolbar_settings',
			),
		);

		$color = array(
			'theme_warning'     => array(
				'label'           => '',
				'type'            => 'warning',
				'value'           => true,
				'display_if'      => true,
				'message'         => esc_html__( "The changes made in the 'Enable Theme,' 'Theme Mode,' and 'Color Palette' options might not be immediately visible in the visual builder, but they will take effect on the frontend page.", 'dich-divi-charts' ),
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'theme_settings',
				'bb_support'      => false,
			),
			'enable_theme'      => array(
				'label'            => esc_html__( 'Enable Theme', 'dich-divi-charts' ),
				'type'             => 'yes_no_button',
				'description'      => esc_html__( "Choose 'Enable' to unlock the theme color editing option, or 'Disable' it. Activating the theme color option will override colors set in child modules.", 'dich-divi-charts' ),
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'dich-divi-charts' ),
					'off' => esc_html__( 'No', 'dich-divi-charts' ),
				),
				'default'          => 'off',
				'default_on_front' => 'off',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'theme_settings',
			),
			'theme_mode'        => array(
				'label'           => esc_html__( 'Theme Mode', 'dich-divi-charts' ),
				'description'     => esc_html__( "Choose your preferred theme mode. By default, it's light mode. Changing the theme mode will also update the text and background colors of the chart.", 'dich-divi-charts' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'light' => esc_html__( 'Light', 'dich-divi-charts' ),
					'dark'  => esc_html__( 'Dark', 'dich-divi-charts' ),
				),
				'default'         => 'light',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'theme_settings',
				'depends_on'      => array( 'enable_theme' ),
				'depends_show_if' => 'on',
			),
			'color_palette'     => array(
				'label'           => esc_html__( 'Color Palette', 'dich-divi-charts' ),
				'description'     => esc_html__( "Choose your preferred theme color palette. By default, 'Palette 1' selected.Note that, Changing the theme color palette's option will override colors set in child modules.", 'html' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'none'      => esc_html__( 'None', 'dich-divi-charts' ),
					'palette1'  => esc_html__( 'Palette 1', 'dich-divi-charts' ),
					'palette2'  => esc_html__( 'Palette 2', 'dich-divi-charts' ),
					'palette3'  => esc_html__( 'Palette 3', 'dich-divi-charts' ),
					'palette4'  => esc_html__( 'Palette 4', 'dich-divi-charts' ),
					'palette5'  => esc_html__( 'Palette 5', 'dich-divi-charts' ),
					'palette6'  => esc_html__( 'Palette 6', 'dich-divi-charts' ),
					'palette7'  => esc_html__( 'Palette 7', 'dich-divi-charts' ),
					'palette8'  => esc_html__( 'Palette 8', 'dich-divi-charts' ),
					'palette9'  => esc_html__( 'Palette 9', 'dich-divi-charts' ),
					'palette10' => esc_html__( 'Palette 10', 'dich-divi-charts' ),
				),
				'default'         => 'none',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'theme_settings',
				'depends_on'      => array( 'enable_theme' ),
				'depends_show_if' => 'on',
				'show_if'         => array(
					'enable_theme'      => 'on',
					'enable_monochrome' => 'off',
				),
			),
			'enable_monochrome' => array(
				'label'            => esc_html__( 'Enable Mono Color', 'dich-divi-charts' ),
				'type'             => 'yes_no_button',
				'description'      => esc_html__( "Single color is used as a base and shades are generated from that color. It will override the selected color palette's", 'dich-divi-charts' ),
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'dich-divi-charts' ),
					'off' => esc_html__( 'No', 'dich-divi-charts' ),
				),
				'default'          => 'off',
				'default_on_front' => 'off',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'theme_settings',
				'depends_on'       => array( 'enable_theme' ),
				'depends_show_if'  => 'on',
			),
			'monochrome_color'  => array(
				'label'           => esc_html__( 'Select Color', 'dich-divi-charts' ),
				'description'     => esc_html__( 'A hex color which will be used as the base color for generating shades Ex. #255aee', 'dich-divi-charts' ),
				'type'            => 'color-alpha',
				'custom_color'    => true,
				'default'         => '#255aee',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'theme_settings',
				'depends_on'      => array( 'enable_monochrome' ),
				'depends_show_if' => 'on',
			),
			'shade_to'          => array(
				'label'           => esc_html__( 'Shade To', 'dich-divi-charts' ),
				'description'     => esc_html__( 'Accepts either light or dark.', 'dich-divi-charts' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'light' => esc_html__( 'Light', 'dich-divi-charts' ),
					'dark'  => esc_html__( 'Dark', 'dich-divi-charts' ),
				),
				'default'         => 'light',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'theme_settings',
				'depends_on'      => array( 'enable_monochrome' ),
				'depends_show_if' => 'on',
			),
			'shade_intensity'   => array(
				'label'           => esc_html__( 'Shade Intensity', 'dich-divi-charts' ),
				'description'     => esc_html__( "Define  What should be the intensity while generating shades Accepts from 0 to 1, By default it's 0.5", 'dich-divi-charts' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'range_settings'  => array(
					'step' => 0.01,
					'min'  => 0,
					'max'  => 1,
				),
				'default'         => '0.5',
				'fixed_unit'      => '',
				'validate_unit'   => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'theme_settings',
				'depends_on'      => array( 'enable_monochrome' ),
				'depends_show_if' => 'on',
			),
		);

		return array_merge( $chart, $toolbar, $color );
	}

	/**
	 * Sanitize the props value.
	 *
	 * @param string $value The value to sanitize.
	 * @param string $default_value The default value.
	 *
	 * @return string The sanitized value.
	 */
	private static function get_sanitized_value( $value, $default_value ) {
		return ( ! empty( $value ) ? sanitize_text_field( $value ) : $default_value );
	}

	/**
	 * Sanitize the props value.
	 *
	 * @param array  $attrs Attributes.
	 * @param array  $content Content.
	 * @param string $render_slug Render Slug.
	 *
	 * @return string
	 */
	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_script( 'dich_charts' );
		wp_enqueue_script( 'dich_line_chart' );

		$props      = $this->props;
		$categories = ( ! empty( $props['categories'] ) ? esc_attr( $props['categories'] ) : '' );

		$child_props = $this->get_child_props();
		$child_props = "data-series={$child_props}";

		$min_height = (int) self::get_sanitized_value( $props['min_height'], '350' );
		$min_height = ! empty( $min_height ) ? $min_height : 350;

		$datas = array(
			'chart_line_type'      => self::get_sanitized_value( $props['chart_line_type'], 'straight' ),
			'show_data_labels'     => self::get_sanitized_value( $props['show_data_labels'], 'off' ),
			'legend_position'      => self::get_sanitized_value( $props['legend_position'], 'top' ),
			'show_vertical_labels' => self::get_sanitized_value( $props['show_vertical_labels'], 'off' ),
			// theme mode toggles.
			'enable_theme'         => self::get_sanitized_value( $props['enable_theme'], 'off' ),
			'theme_mode'           => self::get_sanitized_value( $props['theme_mode'], 'light' ),
			'color_palette'        => self::get_sanitized_value( $props['color_palette'], 'palette1' ),
			'enable_monochrome'    => self::get_sanitized_value( $props['enable_monochrome'], 'off' ),
			'monochrome_color'     => self::get_sanitized_value( $props['monochrome_color'], '#255aee' ),
			'shade_to'             => self::get_sanitized_value( $props['shade_to'], 'light' ),
			'shade_intensity'      => self::get_sanitized_value( $props['shade_intensity'], '0.5' ),
			// Markers.
			'show_markers'         => self::get_sanitized_value( $props['show_markers'], 'off' ),
			'marker_size'          => self::get_sanitized_value( $props['marker_size'], '5' ),
			// toolbar.
			'use_options'          => self::get_sanitized_value( $props['use_options'], 'on|on|on|on|on|on' ),
			'min_height'           => $min_height,
			'height'               => (int) self::get_sanitized_value( $props['height'], '350' ),
		);
		$datas = 'data-datas=' . wp_json_encode( $datas ) . '';

		return sprintf(
			'<div class="dich-charts-line" data-categories="%1$s" %2$s %3$s></div>',
			esc_attr( $categories ),
			esc_attr( $child_props ),
			esc_attr( $datas ),
		);
	}

	/**
	 * Performs task before rendering the chart
	 */
	public function before_render() {
		global $dich_line_chart;
		$dich_line_chart = array();
	}

	/**
	 * Get child module props
	 */
	private function get_child_props() {
		global $dich_line_chart;
		return wp_json_encode( $dich_line_chart );
	}
}

new DICH_Line_Chart();
