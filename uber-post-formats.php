<?php

/*
Plugin Name: Uber Post Formats
Author: RGB Lab
Author URI: http://rgblab.net
Version: 1.0.0
Description: Use proper "featured content" instead of "featured images" for audio, video, gallery, link and quote post formats. Just Like in any premium WP theme.
Text Domain: uber-post-formats
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! class_exists( 'uberPostFormats' ) ) {
	/**
	 * class uberPostFormats
	 */
	class uberPostFormats {
		// instance var
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
		 *
		 * @since 1.0.0
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
				// include backend logic
				require_once UPF_ABS_PATH . '/lib/meta.php';

				// include additional links on dashboard on 'plugin_row_meta' hook
				add_filter( 'plugin_row_meta', array( $this, 'dashboardLinks' ), 10, 2 );

				// include backend assets on 'admin_enqueue_scripts' hook
				// priority 5 to ensure loading before gutenberg
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueueBackendAssets' ), 5 );
			} else {
				// include frontend logic
				require_once UPF_ABS_PATH . '/lib/frontend.php';

				// include frontend assets on 'wp_enqueue_scripts' hook
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueueFrontendAssets' ) );
			}

			// include options logic on 'customize_register' hook
			// priority 1 to ensure loading before section and settings w/ controls
			add_action( 'customize_register', array( $this, 'includeOptions' ), 1 );

			// include components on 'after_setup_theme' hook
			// priority 100 to ensure loading after theme
			add_action( 'after_setup_theme', array( $this, 'includeComponents' ), 100 );

			// textdomain
			load_plugin_textdomain( 'upf', false, UPF_REL_PATH . '/languages' );
		}

		/**
		 * dashboard links function
		 *
		 * @param array $links - plugin links from plugin meta
		 * @param string $file - name of main plugin file
		 *
		 * hooked on 'plugin_row_meta' filter
		 *
		 * @return array
		 * @since 1.0.0
		 */
		public function dashboardLinks( $links, $file ) {
			if ( plugin_basename( dirname( __FILE__ ) . '/uber-post-formats.php' ) === $file ) {
				$links[] = '<a href="http://demo.rgblab.net/uber-post-formats" target="_blank">' . esc_html__( 'Docs & Demo', 'upf' ) . '</a>';
				$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TZHDKYP4K759W&source=url" target="_blank">' . esc_html__( 'Donate', 'upf' ) . '</a>';
			}

			return $links;
		}

		/**
		 * enqueue backend assets
		 *
		 * @param string $hook
		 *
		 * hooked on 'admin_enqueue_scripts' action
		 *
		 * @since 1.0.0
		 */
		public function enqueueBackendAssets( $hook ) {
			if ( 'post.php' === $hook || 'post-new.php' == $hook ) {
				wp_enqueue_script( 'upf-backend', UPF_URL_PATH . 'assets/backend.min.js', array(), false, true );
			}
			if ( 'edit.php' === $hook || 'post.php' == $hook || 'post-new.php' == $hook ) {
				wp_enqueue_style( 'upf-backend', UPF_URL_PATH . 'assets/backend.min.css' );
			}
		}

		/**
		 * enqueue frontend assets
		 *
		 * hooked on 'wp_enqueue_scripts' action
		 *
		 * @since 1.0.0
		 */
		public function enqueueFrontendAssets() {
			wp_enqueue_style( 'dashicons' );
			wp_enqueue_script( 'upf-frontend', UPF_URL_PATH . 'assets/frontend.min.js', array(), false, true );
			wp_enqueue_style( 'upf-frontend', UPF_URL_PATH . 'assets/frontend.min.css' );

			uberPostFormatsHelper::generateStyles();
		}

		/**
		 * include options function
		 *
		 * hooked on 'customize_register' action
		 *
		 * @since 1.0.0
		 */
		public function includeOptions() {
			// include options
			require_once UPF_ABS_PATH . '/lib/option.php';
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

// FIXME set scripts for translation
// @see https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/

