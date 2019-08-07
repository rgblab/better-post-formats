<?php

if ( ! class_exists( 'uberPostFormatsMeta' ) ) {
	/**
	 * class uberPostFormatsMeta
	 */
	class uberPostFormatsMeta {
		// base var
		private $post_format;

		// additional vars
		private $meta_key;
		private $nonce;

		/**
		 * uberPostFormatsMeta constructor
		 *
		 * @param string $post_format
		 *
		 * @since 1.0.0
		 */
		public function __construct( $post_format ) {
			// set base var
			$this->post_format = $post_format;

			// set additional vars
			$this->meta_key = UPF_PREFIX . '_' . $this->post_format;
			$this->nonce    = UPF_PREFIX . '_' . $this->post_format . '_nonce';

			// init meta box on 'load-posts.php' hook
			add_action( 'load-post.php', array( $this, 'init_meta_box' ) );
			// init meta box on 'load-posts-new.php' hook
			add_action( 'load-post-new.php', array( $this, 'init_meta_box' ) );
		}

		/**
		 * init function
		 *
		 * hooked on 'load-posts.php' action
		 * hooked on 'load-posts-new.php' action
		 *
		 * @since 1.0.0
		 */
		public function init_meta_box() {
			// add meta box field on the 'add_meta_boxes' hook
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );

			// save meta box value on the 'save_post' hook
			add_action( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
		}

		/**
		 * add meta box function
		 *
		 * hooked on 'add_meta_boxes' action
		 *
		 * @since 1.0.0
		 */
		public function add_meta_box() {
			add_meta_box(
				$this->meta_key, // id
				esc_html__( 'Featured Content', 'upf' ), // title
				array( $this, 'display_meta_box' ), // callback, function to display meta box html
				'post', // screen, where to show meta box
				'side', // context, position of meta box
				'low' // priority
			);
		}

		/**
		 * display meta box function
		 *
		 * @param object $post - global wp var containing post object
		 *
		 * @since 1.0.0
		 */
		public function display_meta_box( $post ) {
			// create nonce field
			wp_nonce_field( basename( __FILE__ ), $this->nonce );

			// get meta box html
			$params = array(
				'meta_key' => $this->meta_key,
			);

			uberPostFormatsHelper::getComponentTemplate( $this->post_format, 'meta-box', 'require', $params );
		}

		/**
		 * save meta box value function
		 * add, update or delete meta value for given meta key
		 *
		 * hooked on 'save_post' action
		 *
		 * @param int $post_id
		 * @param object $post
		 *
		 * @return mixed
		 * @since 1.0.0
		 */
		public function save_meta_box( $post_id, $post ) {
			// bail if doing autosave
			if ( defined( "DOING_AUTOSAVE" ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			// check nonce field
			if ( ! isset( $_POST[ $this->nonce ] ) || ! wp_verify_nonce( $_POST[ $this->nonce ], basename( __FILE__ ) ) ) {
				return $post_id;
			}

			// get post type object
			$post_type = get_post_type_object( $post->post_type );

			// check if user has permission to edit post type
			if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
				return $post_id;
			}

			// loop through all posted keys
			foreach ( $_POST as $input_field_name => $input_field_value ) {
				// check if key starts with plugins prefix
				// FIXME set prefix from constant
				if ( preg_match( '/^upf/', $input_field_name ) ) {
					// get posted key
					$meta_key = uberPostFormatsHelper::swapUnderscoreDash( $input_field_name, 'reverse' );
					// get posted value and sanitize it
					$new_meta_value = ( ! empty( $_POST[ $input_field_name ] ) ? uberPostFormatsHelper::sanitizeInput( $_POST[ $input_field_name ] ) : '' );
					// get last saved meta value
					$meta_value = get_post_meta( $post_id, $meta_key, true );

					// if new meta value was added and there was no previous value, add it
					if ( ! empty( $new_meta_value ) && '' === $meta_value ) {
						add_post_meta( $post_id, $meta_key, $new_meta_value, true );
					} // if new meta value does not match the old value, update it
					elseif ( ! empty( $new_meta_value ) && $new_meta_value !== $meta_value ) {
						update_post_meta( $post_id, $meta_key, $new_meta_value );
					} // if there is no new meta value but an old value exists, delete it
					elseif ( '' === $new_meta_value && ! empty( $meta_value ) ) {
						delete_post_meta( $post_id, $meta_key, $meta_value );
					}
				}
			}
		}
	}
}