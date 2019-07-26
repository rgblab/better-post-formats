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

if ( ! class_exists( 'UberPostFormats' ) ) {
	/**
	 * class UberPostFormats
	 */
	class UberPostFormats {
		private static $instance;

		/**
		 * get instance function
		 *
		 * get single instance of UberPostFormats class
		 *
		 * @return UberPostFormats
		 */
		public static function getInstance() {
			if ( ! ( self::$instance instanceof self ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * UberPostFormat constructor.
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

			// include framework and components
			$this->loadFiles();

			// include scripts
			// include styles
			// include admin scripts
			// include admin styles
			// textdomain
			$this->setTextdomain();
		}

		/**
		 * load files function
		 *
		 * @since 1.0.0
		 */
		public function loadFiles() {
			require_once UPF_ABS_PATH . '/lib/load.php';
			// TODO must be loaded later, on 'after theme setup' hook, we need template tags available in plugin
			require_once UPF_ABS_PATH . '/components/load.php';
		}

		/**
		 * set textdomain function
		 *
		 * @since 1.0.0
		 */
		public function setTextdomain() {
			load_plugin_textdomain( 'upf', false, UPF_REL_PATH . '/languages' );
		}
	}
}

UberPostFormats::getInstance();