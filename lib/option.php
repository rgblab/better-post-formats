<?php

if ( ! class_exists( 'uberPostsFormatOptionsPanel' ) ) {
	/**
	 * class uberPostFormatsOptionsPanel
	 */
	class uberPostFormatsOptionsPanel {
		// instance var
		private static $instance;

		/**
		 * get instance function
		 *
		 * get single instance of uberPostFormatsOptionsPanel class
		 *
		 * @return object uberPostFormatsOptionsPanel
		 */
		public static function getInstance() {
			if ( ! ( self::$instance instanceof self ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * uberPostFormatsOptionsPanel constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			// init customizer panel on 'customize_register' hook
			// priority 2 to ensure loading before sections w/ settings and after init
			add_action( 'customize_register', array( $this, 'initPanel' ), 2 );
		}

		/**
		 * init panel function
		 *
		 * @param object $wp_customize - global wp var containing customizer object
		 *
		 * @hooked on 'customize_register' action
		 * @since 1.0.0
		 */
		public function initPanel( $wp_customize ) {
			$wp_customize->add_panel( UPF_OPTIONS_PANEL, array(
				'capability' => 'edit_theme_options',
				'priority'   => 200,
				'title'      => esc_html__( 'Uber Post Formats Panel', 'upf' ),
			) );
		}
	}
}

uberPostFormatsOptionsPanel::getInstance();

if ( ! class_exists( 'uberPostFormatsOptions' ) ) {
	class uberPostFormatsOptions {
		// base var
		private $section;

		/**
		 * uberPostFormatsOptions constructor
		 *
		 * @param string $section
		 *
		 * @since 1.0.0
		 */
		public function __construct( $section ) {
			// set base var
			$this->section = UPF_PREFIX . '_section_' . $section;

			// init customizer section on 'customize_register' hook
			switch ( $this->section ) {
				case UPF_PREFIX . '_section_common':
					add_action( 'customize_register', array( $this, 'initCommon' ) );
					break;
				case UPF_PREFIX . '_section_gallery':
					add_action( 'customize_register', array( $this, 'initGallery' ) );
					break;
			}
		}

		/**
		 * init customizer common section function
		 *
		 * @param object $wp_customize - global wp var containing customizer object
		 *
		 * hooked on 'customize_register' action
		 *
		 * @since 1.0.0
		 */
		public function initCommon( $wp_customize ) {
			// common section
			$wp_customize->add_section( $this->section, array(
				'capability' => 'edit_theme_options',
				'panel'      => UPF_OPTIONS_PANEL,
				'priority'   => 10,
				'title'      => esc_html__( 'Common', 'upf' ),
			) );

			// content width on lists setting
			$wp_customize->add_setting( UPF_OPTIONS . '[content_width_list]', array(
				'capability' => 'edit_theme_options',
				'default'    => '100%',
				'type'       => 'option',
			) );

			// content width on lists control
			$wp_customize->add_control( UPF_PREFIX . '_content_width_list', array(
				'label'    => esc_html__( 'Content Width on List', 'upf' ),
				'section'  => $this->section,
				'settings' => UPF_OPTIONS . '[content_width_list]',
			) );

			// content width on single setting
			$wp_customize->add_setting( UPF_OPTIONS . '[content_width_single]', array(
				'capability' => 'edit_theme_options',
				'default'    => '1200px',
				'type'       => 'option',
			) );

			// content width on single control
			$wp_customize->add_control( UPF_PREFIX . '_content_width_single', array(
				'label'    => esc_html__( 'Content Width on Single', 'upf' ),
				'section'  => $this->section,
				'settings' => UPF_OPTIONS . '[content_width_single]',
			) );

			// skin setting
			$wp_customize->add_setting( UPF_OPTIONS . '[skin]', array(
				'capability' => 'edit_theme_options',
				'default'    => 'none',
				'type'       => 'option',
			) );

			// skin control
			$wp_customize->add_control( UPF_PREFIX . '_skin', array(
				'label'    => esc_html__( 'Skin:', 'upf' ),
				'section'  => $this->section,
				'settings' => UPF_OPTIONS . '[skin]',
				'type'     => 'select',
				'choices'  => array(
					'none'  => esc_html__( 'None', 'upf' ),
					'light' => esc_html__( 'Light', 'upf' ),
					'dark'  => esc_html__( 'Dark', 'upf' ),
				),
			) );
		}

		/**
		 * init customizer common section function
		 *
		 * @param object $wp_customize - global wp var containing customizer object
		 *
		 * hooked on 'customize_register' action
		 *
		 * @since 1.0.0
		 */
		public function initGallery( $wp_customize ) {
			// gallery section
			$wp_customize->add_section( $this->section, array(
				'capability' => 'edit_theme_options',
				'panel'      => UPF_OPTIONS_PANEL,
				'priority'   => 10,
				'title'      => esc_html__( 'Gallery', 'upf' ),
			) );

			// slider animation setting
			$wp_customize->add_setting( UPF_OPTIONS . '[slider_animation]', array(
				'default'    => 'fade',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );

			// slider animation control
			$wp_customize->add_control( UPF_PREFIX . '_slider_animation', array(
				'label'    => esc_html__( 'Slider Animation Type', 'upf' ),
				'section'  => $this->section,
				'settings' => UPF_OPTIONS . '[slider_animation]',
				'type'     => 'select',
				'choices'  => array(
					'fade'  => esc_html__( 'Fade', 'upf' ),
					'slide' => esc_html__( 'Slide', 'upf' ),
				),
			) );
		}
	}
}


////////////////////////////////////////////////////////////////////
// FIXME move this to main class
// add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'my_plugin_action_links' );
//
// function my_plugin_action_links( $links ) {
// 	$links[] = '<a href="' . esc_url( get_admin_url( null, 'options-general.php?page=gpaisr' ) ) . '">Settings</a>';
// 	$links[] = '<a href="http://wp-buddy.com" target="_blank">More plugins by WP-Buddy</a>';
//
// 	return $links;
// }