<?php

/*
Plugin Name: Uber Post Formats
Plugin URI: http://demo.rgblab.net/uber-post-formats
Author: RGB Lab
Author URI: http://rgblab.net
Version: 1.0.0
Description: WordPress plugin
Text Domain: uber-post-formats
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! class_exists( 'uberPostFormats' ) ) {
	/**
	 * class uberPostFormats
	 */
	class uberPostFormats {
		private static $instance;

		/**
		 * get instance function
		 *
		 * get single instance of uberPostFormats class
		 *
		 * @return uberPostFormats
		 */
		public static function getInstance() {
			if ( ! ( self::$instance instanceof self ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * UberPostFormat constructor
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'initPlugin' ) );
		}

		/**
		 * init function
		 *
		 * hooked on 'plugins_loaded'
		 *
		 * @since 1.0.0
		 */
		public function initPlugin() {
			// include constants
			require_once 'define.php';

			// include libs
			require_once UPF_ABS_PATH . '/lib/load.php';

			// include components
			add_action( 'after_setup_theme', array( $this, 'includeComponents' ), 100 );

			// include scripts
			// include styles
			// include admin scripts
			// include admin styles

			// textdomain
			load_plugin_textdomain( 'upf', false, UPF_REL_PATH . '/languages' );
		}

		/**
		 * include components function
		 *
		 * hooked on 'after_setup_theme'
		 *
		 * @since 1.0.0
		 */
		public function includeComponents() {
			require_once UPF_ABS_PATH . '/components/load.php';
		}
	}
}

uberPostFormats::getInstance();