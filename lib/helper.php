<?php

if ( ! class_exists( 'uberPostFormatsHelper' ) ) {
	/**
	 * class uberPostFormatsHelper
	 */
	class uberPostFormatsHelper {
		/**
		 * is post format supported function
		 * check if post format is supported by current theme
		 *
		 * @param string $post_format
		 *
		 * @return bool
		 * @since 1.0.0
		 */
		public static function isPostFormatSupported( $post_format ) {
			if ( current_theme_supports( 'post-formats' ) ) {
				$post_formats = get_theme_support( 'post-formats' );

				if ( is_array( $post_formats[0] ) ) {
					if ( in_array( $post_format, $post_formats[0] ) ) {
						return true;
					}
				}
			}

			return false;
		}

		/**
		 * get component template function
		 *
		 * @param string $component - name of component
		 * @param string $template - name of template
		 * @param array $params - params, for meta boxes it is meta_box_id
		 *
		 * @since 1.0.0
		 */
		public static function getComponentTemplate( $component, $template, $params = array() ) {
			// must declare wp global $post variable, need post id in meta box template
			global $post;

			if ( ! empty( $params ) ) {
				extract( $params );
			}

			$file = UPF_ABS_PATH . '/components/' . $component . '/templates/' . $template . '.php';

			if ( file_exists( $file ) ) {
				require $file;
			} else {
				echo esc_html__( 'File not found', 'upf' );
			}
		}

		/**
		 * swap underscore dash function
		 * convert underscore to dash or vice versa
		 *
		 * @param string $string
		 * @param string $direction
		 *
		 * @return string
		 * @since 1.0.0
		 */
		public static function swapUnderscoreDash( $string, $direction = '' ) {
			if ( 'reverse' === $direction ) {
				return str_replace( '-', '_', $string );
			} else {
				return str_replace( '_', '-', $string );
			}
		}

		/**
		 * get svg function
		 *
		 * @param $name
		 *
		 * @return string
		 * @since 1.0.0
		 */
		public static function getSVG( $name ) {
			$svg = '';

			switch ( $name ) {
				case 'external-link':
					$svg .= '<svg aria-hidden="true" role="img" focusable="false" class="dashicon dashicons-external components-external-link__icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">';
					$svg .= '<path d="M9 3h8v8l-2-1V6.92l-5.6 5.59-1.41-1.41L14.08 5H10zm3 12v-3l2-2v7H3V6h8L9 8H5v7h7z"></path>';
					$svg .= '</svg>';
					break;
				default:
					break;
			}

			return $svg;
		}
	}
}