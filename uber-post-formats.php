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

				// include admin scripts
				// include admin styles
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
	}
}

uberPostFormats::getInstance();

// TODO properly enqueue scripts
// TODO set scripts for translation
// @see https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/

function gallery_metabox_enqueue( $hook ) {
	if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
		wp_enqueue_script( 'upf-gallery-metabox', UPF_URL_PATH . '/components/gallery/assets/gallery-metabox.js', array(), false, true );
		wp_enqueue_script( 'upf-common', UPF_URL_PATH . '/components/common/assets/common.js', array(), false, true );

		wp_enqueue_style( 'upf-gallery-metabox', UPF_URL_PATH . '/components/gallery/assets/gallery-metabox.css' );
	}
}

add_action( 'admin_enqueue_scripts', 'gallery_metabox_enqueue', 5 );