<?php

/*
Plugin Name: Better Post Formats
Author: RGB Lab
Author URI: http://rgblab.net
Version: 1.0.1
Description: Use proper "featured content" instead of "featured images" for audio, video, gallery, link and quote post formats. Just like in any premium WordPress theme.
Text Domain: bpf
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! class_exists( 'betterPostFormats' ) ) {
	/**
	 * class betterPostFormats
	 */
	class betterPostFormats {
		// instance var
		private static $instance;

		/**
		 * get instance function
		 *
		 * get single instance of betterPostFormats class
		 *
		 * @return object betterPostFormats
		 */
		public static function getInstance() {
			if ( ! ( self::$instance instanceof self ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * betterPostFormats constructor
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
			require_once BPF_ABS_PATH . '/lib/helper.php';

			if ( is_admin() ) {
				// include backend logic
				require_once BPF_ABS_PATH . '/lib/meta.php';

				// show additional links in dashboard on 'plugin_row_meta' hook
				add_filter( 'plugin_row_meta', array( $this, 'dashboardLinks' ), 10, 2 );

				// include backend assets on 'admin_enqueue_scripts' hook
				// priority 5 to ensure loading before gutenberg
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueueBackendAssets' ), 5 );
			} else {
				// include frontend logic
				require_once BPF_ABS_PATH . '/lib/frontend.php';

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
			load_plugin_textdomain( 'bpf', false, BPF_REL_PATH . '/languages' );
		}

		/**
		 * dashboard links function
		 *
		 * @param array  $links - plugin links from plugin meta
		 * @param string $file  - name of main plugin file
		 *
		 * hooked on 'plugin_row_meta' filter
		 *
		 * @return array
		 * @since 1.0.0
		 */
		public function dashboardLinks( $links, $file ) {
			if ( plugin_basename( dirname( __FILE__ ) . '/better-post-formats.php' ) === $file ) {
				$links[] = '<a href="http://demo.rgblab.net/better-post-formats" target="_blank">' . esc_html__( 'Docs & Demo', 'bpf' ) . '</a>';
				$links[] = '<a href="https://wordpress.org/support/plugin/better-post-formats/reviews/#new-post" target="_blank">Please rate with ★★★★★</a>';
				$links[] = '<a href="https://www.paypal.me/rgblab" target="_blank">' . esc_html__( 'Donate', 'bpf' ) . '</a>';
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
				$backend_labels = array(
					'uploaderTitle'      => esc_html__( 'Replace image', 'bpf' ),
					'uploaderButtonText' => esc_html__( 'Replace image', 'bpf' ),
				);

				wp_register_script( 'bpf-backend', BPF_URL_PATH . 'assets/backend.min.js', array( 'jquery' ), false, true );
				wp_localize_script( 'bpf-backend', 'backendLabels', $backend_labels );
				wp_enqueue_script( 'bpf-backend' );
			}
			if ( 'edit.php' === $hook || 'post.php' == $hook || 'post-new.php' == $hook ) {
				wp_enqueue_style( 'bpf-backend', BPF_URL_PATH . 'assets/backend.min.css' );
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
			wp_enqueue_script( 'bpf-frontend', BPF_URL_PATH . 'assets/frontend.min.js', array( 'jquery' ), false, true );
			wp_enqueue_style( 'bpf-frontend', BPF_URL_PATH . 'assets/frontend.min.css' );

			betterPostFormatsHelper::generateStyles();
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
			require_once BPF_ABS_PATH . '/lib/option.php';
		}

		/**
		 * include components function
		 *
		 * hooked on 'after_setup_theme' action
		 *
		 * @since 1.0.0
		 */
		public function includeComponents() {
			require_once BPF_ABS_PATH . '/components/load.php';
		}
	}
}

betterPostFormats::getInstance();
