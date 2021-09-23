<?php

if ( ! class_exists( 'betterPostFormatsHelper' ) ) {
	/**
	 * class betterPostFormatsHelper
	 */
	class betterPostFormatsHelper {
		/**
		 * check appearance function
		 * determine where to apply plugin
		 *
		 * @return bool
		 * @since 1.0.0
		 */
		public static function checkAppearance() {
			$appearance = '';
			$location   = ! empty( get_option( BPF_OPTIONS )['location'] ) ? get_option( BPF_OPTIONS )['location'] : 'both';

			if ( 'both' === $location ) {
				$appearance = true;
			}

			if ( 'single' === $location ) {
				$appearance = is_single() ? true : false;
			}

			if ( 'list' === $location ) {
				$appearance = is_single() ? false : true;
			}

			return $appearance;
		}

		/**
		 * get post formats function
		 * get array of all post formats handled by plugin
		 *
		 * @return array
		 * @since 1.0.0
		 */
		public static function getPostFormats() {
			$post_formats = array();
			$post_formats = apply_filters( 'bpf_set_post_format', $post_formats );

			return $post_formats;
		}

		/**
		 * set post format function
		 *
		 * @param array  $post_formats - all post formats handled by plugin
		 * @param string $post_format
		 *
		 * hooked on 'bpf_set_post_format' filter
		 *
		 * @return array
		 * @since 1.0.0
		 */
		public static function setPostFormat( $post_formats, $post_format ) {
			$post_formats[] = $post_format;

			return $post_formats;
		}

		/**
		 * init post format function
		 * set post format and include component files
		 *
		 * @param string $post_format - post format
		 *
		 * @since 1.0.0
		 */
		public static function initPostFormat( $post_format ) {
			// add post format to array of post formats
			add_filter(
				'bpf_set_post_format',
				function ( $post_formats ) use ( $post_format ) {
					return self::setPostFormat( $post_formats, $post_format );
				}
			);

			// include component
			self::getComponent( $post_format, 'require' );
		}

		/**
		 * set featured function
		 * set output to true if post has featured image or media
		 *
		 * hooked on 'has_post_thumbnail' filter
		 *
		 * @return bool
		 * @see   has_post_thumbnail
		 * @since 1.0.0
		 */
		public static function setFeatured() {
			if ( self::checkFeaturedMedia() || self::checkFeaturedImage() ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * check featured image function
		 * check if post has featured image
		 * can't use 'has_post_thumbnail' function since we're modifying it via 'has_post_thumbnail' filter
		 * we're using 'get_post_thumbnail_id' instead
		 *
		 * @return bool
		 * @since 1.0.0
		 */
		public static function checkFeaturedImage() {
			// return has_post_thumbnail( $post->ID );
			return (bool) get_post_thumbnail_id();
		}

		/**
		 * check featured media function
		 * check if post has featured media meta
		 *
		 * @return bool
		 * @since 1.0.0
		 */
		public static function checkFeaturedMedia() {
			if ( self::checkAppearance() ) {
				// get current post format
				$post_format = get_post_format();

				// if current post format is handled by plugin
				if ( in_array( $post_format, self::getPostFormats() ) ) {
					$meta_value = get_post_meta( get_the_ID(), BPF_PREFIX . '_' . $post_format, true );

					// if current post have featured media for current post format
					// meta value array must have more than one element (gallery) and first element must be not empty
					if ( count( $meta_value ) > 1 && ! empty( $meta_value[0] ) ) {
						return true;
					}
				}
			}
		}

		/**
		 * get featured media function
		 * filter themes post thumbnail output w/ plugins html if post has featured media
		 * otherwise return default wp generated output
		 *
		 * @param $html - default wp generated output
		 *
		 * hooked on 'post_thumbnail_html' filter
		 *
		 * @return string
		 * @see   get_the_post_thumbnail
		 * @since 1.0.0
		 */
		public static function getFeaturedMedia( $html ) {
			global $post;

			// get current post format
			$post_format = get_post_format();

			// if current post have featured media for saved post format
			if ( self::checkFeaturedMedia() ) {
				$featured_image_url = get_the_post_thumbnail_url( $post->ID, 'full' );

				$params = array(
					'meta_key'           => BPF_PREFIX . '_' . $post_format,
					'featured_image_url' => $featured_image_url,
				);

				return self::getComponentTemplate( $post_format, 'media', 'return', $params );

			} else {
				return $html;
			}
		}

		/**
		 * get component function
		 * load component only on backend
		 *
		 * @param string $component - name of component
		 * @param string $method    - either return (to put in var) or require
		 *
		 * @return string
		 * @since 1.0.0
		 */
		public static function getComponent( $component, $method ) {
			if ( is_admin() ) {
				$file = BPF_ABS_PATH . '/components/' . $component . '/' . $component . '.php';

				if ( 'require' === $method ) {
					if ( file_exists( $file ) ) {
						require $file;
					} else {
						echo esc_html__( 'File not found', 'bpf' );
					}
				}
				if ( 'return' === $method ) {
					if ( file_exists( $file ) ) {
						ob_start();
						require $file;

						return ob_get_clean();
					} else {
						return esc_html__( 'File not found', 'bpf' );
					}
				}
			}
		}

		/**
		 * get component template function
		 *
		 * @param string $component - name of component
		 * @param string $template  - name of template
		 * @param string $method    - either return (to put in var) or require
		 * @param array  $params    - params, for meta boxes it is meta_box_id
		 *
		 * @return string
		 * @since 1.0.0
		 */
		public static function getComponentTemplate( $component, $template, $method = 'require', $params = array() ) {
			// must declare wp global $post variable, need post id in meta box template
			global $post;

			if ( ! empty( $params ) ) {
				extract( $params );
			}

			$file = BPF_ABS_PATH . '/components/' . $component . '/templates/' . $template . '.php';

			if ( 'require' === $method ) {
				if ( file_exists( $file ) ) {

					require $file;
				} else {
					echo esc_html__( 'File not found', 'bpf' );
				}
			}
			if ( 'return' === $method ) {
				if ( file_exists( $file ) ) {
					ob_start();
					require $file;

					return ob_get_clean();
				} else {
					return esc_html__( 'File not found', 'bpf' );
				}
			}
		}

		/**
		 * swap underscore dash function
		 * convert underscore to dash or vice versa
		 *
		 * @param string $string
		 * @param string $direction - either empty or reverse
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
		 * sanitize input function
		 * make sure input value is XSS OK before saving to database
		 *
		 * @param mixed $input
		 *
		 * @return mixed
		 * @since 1.0.0
		 */
		public static function sanitizeInput( $input ) {
			if ( is_array( $input ) ) {
				foreach ( $input as $key => $value ) {
					$input[ $key ] = sanitize_text_field( $value );
				}

				return $input;
			} else {
				return sanitize_text_field( $input );
			}
		}

		/**
		 * get svg function
		 *
		 * @param string $name - name of svg image
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

		/**
		 * get skin function
		 * return global if local is set to default
		 * otherwise return local
		 *
		 * @param string $local_skin - local skin value, either default, light or dark
		 *
		 * @return string
		 * @since 1.0.0
		 */
		public static function getSkin( $local_skin ) {
			$global_skin = ! empty( get_option( BPF_OPTIONS )['skin'] ) ? get_option( BPF_OPTIONS )['skin'] : 'none';

			$skin = ( 'global' === $local_skin ) ? $global_skin : $local_skin;
			$skin = ( 'none' === $skin ) ? '' : BPF_PREFIX . '-content--' . $skin;

			return $skin;
		}

		/**
		 * generate styles function
		 *
		 * @since 1.0.0
		 */
		public static function generateStyles() {
			$style = '';
			$style = apply_filters( 'bpf_set_style', $style );

			wp_add_inline_style( 'bpf-frontend', $style );
		}
	}
}

if ( ! function_exists( 'bpf_var_dump' ) ) {
	/**
	 * formatted var dump function
	 *
	 * @param mixed $data
	 *
	 * @since 1.0.0
	 */
	function bpf_var_dump( $data ) {
		echo '<pre>';
		var_dump( $data );
		echo '</pre>';
	}
}
