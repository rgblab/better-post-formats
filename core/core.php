<?php

if ( ! class_exists( 'UberPostFormat' ) ) {
	/**
	 * Class UberPostFormat
	 */
	class UberPostFormat {
		private static $instance;

		/**
		 * @return UberPostFormat
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
			add_action( 'plugins_loaded', array( $this, 'init' ) );
		}

		/**
		 *
		 */
		public function init() {
			// include constants
			include_once realpath( __DIR__ . '/..' ) . '/define.php';

			// include framework and components
			$this->load();

			// include scripts
			// include styles
			// include admin scripts
			// include admin styles
			// textdomain
			$this->textdomain();
		}

		public function load() {
			require_once UPF_ABS_PATH . '/core/helper.php';
			require_once UPF_ABS_PATH . '/framework/framework.php';
			require_once UPF_ABS_PATH . '/components/components.php';
		}

		public function textdomain() {
			load_plugin_textdomain( 'upf', false, UPF_REL_PATH . '/languages' );
		}
	}
}