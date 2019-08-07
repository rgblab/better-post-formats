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
		 * @return object uberPostFormats
		 */
		public static function getInstance() {
			if ( ! ( self::$instance instanceof self ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * uberPostFormats constructor
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'initPlugin' ) );
		}

		/**
		 * init function
		 *
		 * hooked on 'plugins_loaded' action
		 *
		 * @since 1.0.0
		 */
		public function initPlugin() {
			// include constants
			require_once 'define.php';

			// include helper
			require_once UPF_ABS_PATH . '/lib/helper.php';

			if ( is_admin() ) {
				// include backend
				require_once UPF_ABS_PATH . '/lib/option.php';
				require_once UPF_ABS_PATH . '/lib/meta.php';

				// include backend assets
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueueBackendAssets' ), 5 );
			} else {
				// include frontend
				require_once UPF_ABS_PATH . '/lib/frontend.php';
				// include scripts
				// include styles
			}

			// include components
			add_action( 'after_setup_theme', array( $this, 'includeComponents' ), 100 );

			// textdomain
			load_plugin_textdomain( 'upf', false, UPF_REL_PATH . '/languages' );
		}

		/**
		 * include components function
		 *
		 * hooked on 'after_setup_theme' action
		 *
		 * @since 1.0.0
		 */
		public function includeComponents() {
			require_once UPF_ABS_PATH . '/components/load.php';
		}

		public function enqueueBackendAssets( $hook ) {
			if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
				wp_enqueue_script( 'upf-backend', UPF_URL_PATH . '/assets/backend.js', array(), false, true );
				wp_enqueue_style( 'upf-backend', UPF_URL_PATH . '/assets/backend.css' );
			}
		}
	}
}

uberPostFormats::getInstance();

// TODO properly enqueue scripts
// TODO set scripts for translation
// @see https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/