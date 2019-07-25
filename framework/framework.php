<?php

if ( ! class_exists( 'UberPostFormatFramework' ) ) {
	/**
	 * Class UberPostFormatFramework
	 */
	class UberPostFormatFramework {
		// base vars
		private $post_format;
		private $meta_box_title;
		private $input_field_type;
		private $input_field_label;
		private $input_field_description;

		// additional vars
		private $meta_box_id;
		private $nonce;
		private $input_field_attr;

		/**
		 * UberPostFormatFramework constructor
		 *
		 * @param array $args
		 * keys: post_format, meta_box_title, input_field_type, input_field_label, input_field_description
		 */
		public function __construct( $args ) {
			// set base vars from array
			foreach ( $args as $key => $value ) {
				$this->$key = $value;
			}

			// set additional vars
			$this->meta_box_id      = UPF_PREFIX . '_' . $this->post_format;
			$this->nonce            = UPF_PREFIX . '_' . $this->post_format . '_nonce';
			$this->input_field_attr = UPF_PREFIX . '-' . $this->post_format;

			// init meta box on 'load-posts.php' hook
			add_action( 'load-post.php', array( $this, 'init_meta_box' ) );
			// init meta box on 'load-posts-new.php' hook
			add_action( 'load-post-new.php', array( $this, 'init_meta_box' ) );
		}

		/**
		 * init function
		 *
		 * hooked on 'load-posts.php'
		 * hooked on 'load-posts-new.php'
		 */
		public function init_meta_box() {
			// add meta box field on the 'add_meta_boxes' hook
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );

			// save meta box value on the 'save_post' hook
			add_action( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
		}

		/**
		 * add meta box function
		 */
		public function add_meta_box() {
			add_meta_box(
				$this->meta_box_id, // meta box id
				$this->meta_box_title, // meta box title
				array( $this, 'display_meta_box' ), // callback function to display meta box html
				'post', // where to show meta box, admin page or post type
				'side', // position of meta box
				'default' // priority
			);
		}

		/**
		 * display meta box function
		 *
		 * @param object $post
		 */
		public function display_meta_box( $post ) {
			// create nonce field
			wp_nonce_field( basename( __FILE__ ), $this->nonce );

			// TODO create some kind of get template part function?
			// get meta box html
			require_once UPF_ABS_PATH . '/framework/fields/' . $this->input_field_type . '.php'; // TODO move templates to components
		}

		/**
		 * save meta box value function
		 *
		 * @param int $post_id
		 * @param object $post
		 *
		 * @return mixed
		 */
		public function save_meta_box( $post_id, $post ) {
			// TODO figure out how to handle multiple post values
			// TODO post values are prefixed with upf constant
			// TODO @see https://stackoverflow.com/questions/5112167/php-post-name-wildcard-postvar
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

			// get posted data and sanitize it
			$new_meta_value = ( isset( $_POST[ $this->input_field_attr ] ) ? sanitize_text_field( $_POST[ $this->input_field_attr ] ) : '' );

			// get meta value
			$meta_value = get_post_meta( $post_id, $this->meta_box_id, true );

			// if new meta value was added and there was no previous value, add it
			if ( $new_meta_value && '' === $meta_value ) {
				add_post_meta( $post_id, $this->meta_box_id, $new_meta_value, true );
			} // if new meta value does not match the old value, update it
			elseif ( $new_meta_value && $new_meta_value !== $meta_value ) {
				update_post_meta( $post_id, $this->meta_box_id, $new_meta_value );
			} // if there is no new meta value but an old value exists, delete it
			elseif ( '' === $new_meta_value && $meta_value ) {
				delete_post_meta( $post_id, $this->meta_box_id, $meta_value );
			}
		}
	}
}