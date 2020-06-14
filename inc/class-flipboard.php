<?php
/**
 * Flipboard
 *
 * Display a Flipboard magazine widget.
 *
 * @package Flipboard Magazine Widget
 */

namespace taupecat;

/**
 * Display a Flipbard widget.
 */
class Flipboard {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	private $version = '2.0.0';

	/**
	 * Plugin URL.
	 *
	 * @var string
	 */
	private $plugin_url;

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {

		$this->plugin_url = plugin_dir_url( __DIR__ );
	}

	/**
	 * Initialize the widget.
	 *
	 * @return void
	 */
	public function init() {

		$this->call_flipboard_magazine_widget();

		// Load the widget's JavaScript from the Flipboard CDN.
		add_action( 'wp_enqueue_scripts', array( $this, 'flipboard_js' ) );

		// Action to initialize the new widget.
		add_action( 'widgets_init', array( $this, 'widget_init' ) );
	}

	/**
	 * Load the Flipboard Magazine Widget.
	 *
	 * @return void
	 */
	private function call_flipboard_magazine_widget() {

		require_once __DIR__ . '/class-flipboard-magazine-widget.php';
	}

	/**
	 * Enqueue the Flipboard Magazine Widget JavaScript from Flipboard's CDN.
	 *
	 * @return void
	 */
	public function flipboard_js() {

		wp_register_script(
			'fmw-flipboard-widget-js',
			esc_url( $this->plugin_url . 'js/flbuttons.min.js' ),
			array(),
			$this->version,
			true
		);

		wp_enqueue_script( 'fmw-flipboard-widget-js' );
	}

	/**
	 * Initialize the widget.
	 *
	 * @return void
	 */
	public function widget_init() {

		register_widget( __NAMESPACE__ . '\\Flipboard_Magazine_Widget' );
	}
}
