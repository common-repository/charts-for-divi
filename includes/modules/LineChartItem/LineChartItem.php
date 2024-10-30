<?php
/**
 * Divi Line Chart Item
 *
 * @package Divi Line Chart
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
#[AllowDynamicProperties]
class DICH_Line_Chart_Item extends ET_Builder_Module {

	public $slug                     = 'dich_line_chart_item';
	public $vb_support               = 'on';
	public $type                     = 'child';
	public $child_title_var          = 'title';
	public $child_title_fallback_var = 'title';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'Hridoy Mozumder',
		'author_uri' => '',
	);

	/**
	 * Initializes Divi Line Chart Child Module
	 */
	public function init() {
		$this->name = esc_html__( 'Divi Line Chart Item', 'dich-divi-charts' );

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'data_table'    => esc_html__( 'Data Table', 'dich-divi-charts' ),
					'data_settings' => esc_html__( 'Settings', 'dich-divi-charts' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'colors' => esc_html__( 'Colors', 'dich-divi-charts' ),
				),
			),
		);
	}

	/**
	 * Advanced Fields Configuration
	 */
	public function get_advanced_fields_config() {
		return array();
	}

	/**
	 * Custom Fields Configuration
	 */
	public function get_fields() {
		$general = array(
			'title'                => array(
				'label'           => esc_html__( 'Series Name', 'dich-divi-charts' ),
				'description'     => esc_html__( 'Define your data series name here. Ex. Sales', 'dich-divi-charts' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'data_table',
			),
			'data_series'          => array(
				'label'           => esc_html__( 'Data Series', 'dich-divi-charts' ),
				'description'     => esc_html__( 'Define your data series separate by commas. Ex. 30, 40, 35, 50 etc.', 'dich-divi-charts' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'data_table',
			),
			'line_width'           => array(
				'label'           => esc_html__( 'Line Width', 'dich-divi-charts' ),
				'description'     => esc_html__( 'Define the thickness of data series line. Default is 4.', 'dich-divi-charts' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '4',
				'fixed_unit'      => '',
				'validate_unit'   => false,
				'toggle_slug'     => 'data_settings',
			),
			'show_label'           => array(
				'label'            => esc_html__( 'Show Label', 'dich-divi-charts' ),
				'type'             => 'yes_no_button',
				'description'      => esc_html__( "Please select 'Enable' to display the label or 'Disable' to hide it..If the 'Show Vertical Label' toggle is disable in the parent, then this toggle won't work.", 'dich-divi-charts' ),
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'dich-divi-charts' ),
					'off' => esc_html__( 'No', 'dich-divi-charts' ),
				),
				'default'          => 'on',
				'default_on_front' => 'on',
				'toggle_slug'      => 'data_settings',
			),
			'show_vertical_border' => array(
				'label'            => esc_html__( 'Show Vertical Border', 'dich-divi-charts' ),
				'type'             => 'yes_no_button',
				'description'      => esc_html__( "Please select 'Enable' to display the vertical border or 'Disable' to hide it..If the 'Show Vertical Label' toggle is disable in the parent, then this toggle won't work.", 'dich-divi-charts' ),
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'dich-divi-charts' ),
					'off' => esc_html__( 'No', 'dich-divi-charts' ),
				),
				'default'          => 'on',
				'default_on_front' => 'on',
				'toggle_slug'      => 'data_settings',
			),
		);

		$advanced = array(
			'line_color'            => array(
				'label'        => esc_html__( 'Line Color', 'dich-divi-charts' ),
				'description'  => esc_html__( 'Select color for data series line. it only support hex color. Ex. #000', 'dich-divi-charts' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#000',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'colors',
			),
			'label_color'           => array(
				'label'        => esc_html__( 'Label Color', 'dich-divi-charts' ),
				'description'  => esc_html__( 'Select color for data series label. Ex. #000 or black.', 'dich-divi-charts' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#000',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'colors',
			),
			'vertical_border_color' => array(
				'label'        => esc_html__( 'Vertical Border Color', 'dich-divi-charts' ),
				'description'  => esc_html__( 'Select color for data series vertical border color. Ex. #000 or black.', 'dich-divi-charts' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#000',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'colors',
			),
		);

		return array_merge( $general, $advanced );
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
	 * Processecing child module props to use in the parent module
	 *
	 * @param string $render_slug Render Slug.
	 *
	 * @return array Array of child module props.
	 */
	private function process_props( $render_slug ) {
		global $dich_line_chart;
		$module_order_class = self::get_module_order_class( $render_slug );

		$title = self::get_sanitized_value( $this->props['title'], '' );
		$title = str_replace( ' ', '', $title );
		$data  = self::get_sanitized_value( $this->props['data_series'], '' );
		$data  = str_replace( ' ', '', $data );

		$dich_line_chart[ $module_order_class ] = array(
			'name'                  => $title,
			'data'                  => $data,
			'line_width'            => self::get_sanitized_value( $this->props['line_width'], '4' ),
			'show_label'            => self::get_sanitized_value( $this->props['show_label'], 'on' ),
			'show_vertical_border'  => self::get_sanitized_value( $this->props['show_vertical_border'], 'on' ),
			'line_color'            => self::get_sanitized_value( $this->props['line_color'], '#000' ),
			'label_color'           => self::get_sanitized_value( $this->props['label_color'], '#000' ),
			'vertical_border_color' => self::get_sanitized_value( $this->props['vertical_border_color'], '#000' ),
		);
		return $dich_line_chart;
	}

	/**
	 * Sanitize the props value.
	 *
	 * @param array  $attrs Attributes.
	 * @param array  $content Content.
	 * @param string $render_slug Render Slug.
	 *
	 * @return null
	 */
	public function render( $attrs, $content, $render_slug ) {
		$this->process_props( $render_slug );
		return null;
	}
}

new DICH_Line_Chart_Item();
