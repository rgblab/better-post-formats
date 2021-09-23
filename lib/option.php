<?php

if ( ! class_exists( 'betterPostsFormatsCustomizerSection' ) ) {
	/**
	 * class betterPostsFormatsCustomizerSection
	 */
	class betterPostsFormatsCustomizerSection {
		// instance var
		private static $instance;

		/**
		 * get instance function
		 *
		 * get single instance of betterPostsFormatsCustomizerSection class
		 *
		 * @return object betterPostsFormatsCustomizerSection
		 */
		public static function getInstance() {
			if ( ! ( self::$instance instanceof self ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * betterPostsFormatsCustomizerSection constructor
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
		 * @since  1.0.0
		 */
		public function initSection( $wp_customize ) {
			$wp_customize->add_section(
				BPF_OPTIONS_SECTION,
				array(
					'capability' => 'edit_theme_options',
					'priority'   => 200,
					'title'      => esc_html__( 'Better Post Formats', 'bpf' ),
				)
			);
		}
	}
}

betterPostsFormatsCustomizerSection::getInstance();

if ( ! class_exists( 'betterPostFormatsCustomizerSettings' ) ) {
	class betterPostFormatsCustomizerSettings {
		/**
		 * betterPostFormatsCustomizerSettings constructor
		 *
		 * @param string $post_format
		 *
		 * @since 1.0.0
		 */
		public function __construct( $post_format ) {
			// init customizer settings on 'customize_register' hook
			switch ( $post_format ) {
				case 'common':
					add_action( 'customize_register', array( $this, 'initCommon' ) );
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
			$wp_customize->add_setting(
				BPF_OPTIONS . '[location]',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'both',
					'sanitize_callback' => 'sanitize_text_field',
					'type'              => 'option',
				)
			);

			// enable plugin control
			$wp_customize->add_control(
				BPF_PREFIX . '_location',
				array(
					'description' => esc_html__( 'Choose where you want to use BPF on the frontend of your website', 'bpf' ),
					'label'       => esc_html__( 'Location', 'bpf' ),
					'section'     => BPF_OPTIONS_SECTION,
					'settings'    => BPF_OPTIONS . '[location]',
					'type'        => 'select',
					'choices'     => array(
						'both'   => esc_html__( 'On both lists and singles', 'bpf' ),
						'single' => esc_html__( 'On singles only', 'bpf' ),
						'list'   => esc_html__( 'On lists only', 'bpf' ),
					),
				)
			);

			// content width on lists setting
			$wp_customize->add_setting(
				BPF_OPTIONS . '[content_width_list]',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => '100%',
					'sanitize_callback' => 'sanitize_text_field',
					'type'              => 'option',
				)
			);

			// content width on lists control
			$wp_customize->add_control(
				BPF_PREFIX . '_content_width_list',
				array(
					'description' => esc_html__( 'Set BPF content width on lists. Default value is "100%"', 'bpf' ),
					'label'       => esc_html__( 'Content width on lists', 'bpf' ),
					'section'     => BPF_OPTIONS_SECTION,
					'settings'    => BPF_OPTIONS . '[content_width_list]',
				)
			);

			// content width on single setting
			$wp_customize->add_setting(
				BPF_OPTIONS . '[content_width_single]',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => '1200px',
					'sanitize_callback' => 'sanitize_text_field',
					'type'              => 'option',
				)
			);

			// content width on single control
			$wp_customize->add_control(
				BPF_PREFIX . '_content_width_single',
				array(
					'description' => esc_html__( 'Set BPF content width on singles. Default value is "1200px"', 'bpf' ),
					'label'       => esc_html__( 'Content width on singles', 'bpf' ),
					'section'     => BPF_OPTIONS_SECTION,
					'settings'    => BPF_OPTIONS . '[content_width_single]',
				)
			);

			// skin setting
			$wp_customize->add_setting(
				BPF_OPTIONS . '[skin]',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'none',
					'sanitize_callback' => 'sanitize_text_field',
					'type'              => 'option',
				)
			);

			// skin control
			$wp_customize->add_control(
				BPF_PREFIX . '_skin',
				array(
					'description' => esc_html__( 'Choose BPF content skin. Light skin goes well with dark content while dark skin goes well with light content. Choose "None" to use themes color scheme', 'bpf' ),
					'label'       => esc_html__( 'Skin', 'bpf' ),
					'section'     => BPF_OPTIONS_SECTION,
					'settings'    => BPF_OPTIONS . '[skin]',
					'type'        => 'select',
					'choices'     => array(
						'none'  => esc_html__( 'None', 'bpf' ),
						'light' => esc_html__( 'Light', 'bpf' ),
						'dark'  => esc_html__( 'Dark', 'bpf' ),
					),
				)
			);
		}
	}
}
