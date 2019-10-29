<?php

$input_field_attr      = uberPostFormatsHelper::swapUnderscoreDash( $meta_key ); // upf-gallery
$ids                   = get_post_meta( $post->ID, $meta_key, true );
$skin_key              = 0;
$skin_value            = get_post_meta( $post->ID, $meta_key, true )[ $skin_key ];
$skin_input_field_attr = $input_field_attr . '[' . $skin_key . ']';

?>

<div class="upf-control upf-control--gallery">
    <a class="button upf-control__add" href="#" data-uploader-title="<?php esc_attr_e( 'Add images to gallery', 'upf' ); ?>" data-uploader-button-text="<?php esc_attr_e( 'Add images', 'upf' ); ?>"><?php esc_html_e( 'Add images', 'upf' ); ?></a>
    <ul class="upf-control__gallery">

		<?php

		if ( $ids ) {
			foreach ( $ids as $key => $value ) {
				if ( is_numeric( $value ) ) {
					$image = wp_get_attachment_image_url( $value );

					?>

                    <li>
                        <input name="<?php echo esc_attr( $input_field_attr . '[' . $key . ']' ); ?>" type="hidden" value="<?php echo esc_attr( $value ); ?>">
                        <img alt="thumbnail" class="upf-control__image" src="<?php echo esc_url( $image ); ?>">
                        <a class="upf-control__replace" href="#" data-uploader-title="<?php esc_attr_e( 'Replace image', 'upf' ); ?>" data-uploader-button-text="<?php esc_attr_e( 'Replace image', 'upf' ); ?>">
                            <span class="dashicons dashicons-edit"></span>
                        </a>
                        <a class="upf-control__remove" href="#">
                            <span class="dashicons dashicons-no"></span>
                        </a>
                    </li>

					<?php

				}
			}
		}

		?>

    </ul>

    <div class="upf-control__select">
        <label class="upf-control__label" for="<?php echo esc_attr( $skin_input_field_attr ); ?>"><?php esc_html_e( 'Set content skin', 'upf' ) ?></label>
        <select class="upf-control__select-field" name="<?php echo esc_attr( $skin_input_field_attr ); ?>">
            <option value="global" <?php echo ( 'global' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Global from the customizer', 'upf' ); ?></option>
            <option value="light" <?php echo ( 'light' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Light', 'upf' ); ?></option>
            <option value="dark" <?php echo ( 'dark' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Dark', 'upf' ); ?></option>
        </select>
    </div>
</div>