<?php

if ( ! class_exists( 'uberPostsFormatsCustomizerSection' ) ) {
	/**
	 * class uberPostsFormatsCustomizerSection
	 */
	class uberPostsFormatsCustomizerSection {
		// instance var
		private static $instance;

		/**
		 * get instance function
		 *
		 * get single instance of uberPostsFormatsCustomizerSection class
		 *
		 * @return object uberPostsFormatsCustomizerSection
		 */
		public static function getInstance() {
			if ( ! ( self::$instance instanceof self ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * uberPostsFormatsCustomizerSection constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			// init customizer section on 'customize_register' hook
			// priority 2 to ensure loading before settings w/ controls and after init
			add_action( 'customize_register', array( $this, 'initSection' ), 2 );
		}

		/**
		 * init section function
		 *
		 * @param object $wp_customize - global wp var containing customizer object
		 *
		 * @hooked on 'customize_register' action
		 * @since 1.0.0
		 */
		public function initSection( $wp_customize ) {
			$wp_customize->add_section( UPF_OPTIONS_SECTION, array(
				'capability' => 'edit_theme_options',
				'priority'   => 200,
				'title'      => esc_html__( 'Uber Post Formats', 'upf' ),
			) );
		}
	}
}

uberPostsFormatsCustomizerSection::getInstance();

if ( ! class_exists( 'uberPostFormatsCustomizerSettings' ) ) {
	class uberPostFormatsCustomizerSettings {
		/**
		 * uberPostFormatsCustomizerSettings constructor
		 *
		 * @param string $post_format
		 *
		 * @since 1.0.0
		 */
		public function __construct( $post_format ) {
			// init customizer settings on 'customize_register' hook
			switch ( $post_format ) {
				case 'common':
					if ( ! empty( uberPostFormatsHelper::getPostFormats() ) ) {
						add_action( 'customize_register', array( $this, 'initCommon' ) );
					}
					break;
				case 'gallery':
					add_action( 'customize_register', array( $this, 'initGallery' ) );
					break;
			}
		}

		/**
		 * init customizer common settings function
		 *
		 * @param object $wp_customize - global wp var containing customizer object
		 *
		 * hooked on 'customize_register' action
		 *
		 * @since 1.0.0
		 */
		public function initCommon( $wp_customize ) {
			// enable plugin setting
			$wp_customize->add_setting( UPF_OPTIONS . '[location]', array(
				'capability'        => 'edit_theme_options',
				'default'           => 'both',
				'sanitize_callback' => 'sanitize_text_field',
				'type'              => 'option',
			) );

			// enable plugin control
			$wp_customize->add_control( UPF_PREFIX . '_location', array(
				'description' => esc_html__( 'Choose where you want to use UPF on the frontend of your website', 'upf' ),
				'label'       => esc_html__( 'Location', 'upf' ),
				'section'     => UPF_OPTIONS_SECTION,
				'settings'    => UPF_OPTIONS . '[location]',
				'type'        => 'select',
				'choices'     => array(
					'both'   => esc_html__( 'On both lists and singles', 'upf' ),
					'single' => esc_html__( 'On singles only', 'upf' ),
					'list'   => esc_html__( 'On lists only', 'upf' ),
				),
			) );

			// content width on lists setting
			$wp_customize->add_setting( UPF_OPTIONS . '[content_width_list]', array(
				'capability'        => 'edit_theme_options',
				'default'           => '100%',
				'sanitize_callback' => 'sanitize_text_field',
				'type'              => 'option',
			) );

			// content width on lists control
			$wp_customize->add_control( UPF_PREFIX . '_content_width_list', array(
				'description' => esc_html__( 'Set UPF content width on lists', 'upf' ),
				'label'       => esc_html__( 'Content width on lists', 'upf' ),
				'section'     => UPF_OPTIONS_SECTION,
				'settings'    => UPF_OPTIONS . '[content_width_list]',
			) );

			// content width on single setting
			$wp_customize->add_setting( UPF_OPTIONS . '[content_width_single]', array(
				'capability'        => 'edit_theme_options',
				'default'           => '1200px',
				'sanitize_callback' => 'sanitize_text_field',
				'type'              => 'option',
			) );

			// content width on single control
			$wp_customize->add_control( UPF_PREFIX . '_content_width_single', array(
				'description' => esc_html__( 'Set UPF content width on singles', 'upf' ),
				'label'       => esc_html__( 'Content width on singles', 'upf' ),
				'section'     => UPF_OPTIONS_SECTION,
				'settings'    => UPF_OPTIONS . '[content_width_single]',
			) );

			// skin setting
			$wp_customize->add_setting( UPF_OPTIONS . '[skin]', array(
				'capability'        => 'edit_theme_options',
				'default'           => 'none',
				'sanitize_callback' => 'sanitize_text_field',
				'type'              => 'option',
			) );

			// skin control
			$wp_customize->add_control( UPF_PREFIX . '_skin', array(
				'description' => esc_html__( 'Choose UPF content skin. Light skin goes well with dark content while dark skin goes well with light content. Choose "None" to use themes color scheme', 'upf' ),
				'label'       => esc_html__( 'Skin', 'upf' ),
				'section'     => UPF_OPTIONS_SECTION,
				'settings'    => UPF_OPTIONS . '[skin]',
				'type'        => 'select',
				'choices'     => array(
					'none'  => esc_html__( 'None', 'upf' ),
					'light' => esc_html__( 'Light', 'upf' ),
					'dark'  => esc_html__( 'Dark', 'upf' ),
				),
			) );
		}

		/**
		 * init customizer gallery settings function
		 *
		 * @param object $wp_customize - global wp var containing customizer object
		 *
		 * hooked on 'customize_register' action
		 *
		 * @since 1.0.0
		 */
		public function initGallery( $wp_customize ) {
			// slider animation setting
			$wp_customize->add_setting( UPF_OPTIONS . '[slider_animation]', array(
				'default'    => 'fade',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			) );

			// slider animation control
			$wp_customize->add_control( UPF_PREFIX . '_slider_animation', array(
				'description' => esc_html__( 'Choose slider animation type for "Gallery" post formats', 'upf' ),
				'label'       => esc_html__( 'Slider animation type', 'upf' ),
				'section'     => UPF_OPTIONS_SECTION,
				'settings'    => UPF_OPTIONS . '[slider_animation]',
				'type'        => 'select',
				'choices'     => array(
					'fade'  => esc_html__( 'Fade', 'upf' ),
					'slide' => esc_html__( 'Slide', 'upf' ),
				),
			) );
		}
	}
}