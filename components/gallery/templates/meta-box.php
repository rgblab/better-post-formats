<?php

$input_field_attr      = betterPostFormatsHelper::swapUnderscoreDash( $meta_key ); // bpf-gallery
$ids                   = get_post_meta( $post->ID, $meta_key, true );
$skin_key              = 0;
$skin_value            = get_post_meta( $post->ID, $meta_key, true )[ $skin_key ];
$skin_input_field_attr = $input_field_attr . '[' . $skin_key . ']';

?>
<div class="bpf-control bpf-control--gallery">
	<a class="button bpf-control__add" href="#" data-uploader-title="<?php esc_attr_e( 'Add images to gallery', 'bpf' ); ?>" data-uploader-button-text="<?php esc_attr_e( 'Add images', 'bpf' ); ?>"><?php esc_html_e( 'Add images', 'bpf' ); ?></a>
	<ul class="bpf-control__gallery">
		<?php

		if ( $ids ) {
			foreach ( $ids as $key => $value ) {
				if ( is_numeric( $value ) ) {
					$image = wp_get_attachment_image_url( $value );

					?>
					<li>
						<input name="<?php echo esc_attr( $input_field_attr . '[' . $key . ']' ); ?>" type="hidden" value="<?php echo esc_attr( $value ); ?>">
						<img alt="Thumbnail image" class="bpf-control__image" src="<?php echo esc_url( $image ); ?>">
						<a class="bpf-control__replace" href="#" data-uploader-title="<?php esc_attr_e( 'Replace image', 'bpf' ); ?>" data-uploader-button-text="<?php esc_attr_e( 'Replace image', 'bpf' ); ?>">
							<span class="dashicons dashicons-edit"></span>
						</a>
						<a class="bpf-control__remove" href="#">
							<span class="dashicons dashicons-no"></span>
						</a>
					</li>
					<?php

				}
			}
		}

		?>
	</ul>
	<div class="bpf-control__select bpf-control--no-bottom-margin">
		<label class="bpf-control__label" for="<?php echo esc_attr( $skin_input_field_attr ); ?>"><?php esc_html_e( 'Set content skin', 'bpf' ) ?></label>
		<select class="bpf-control__select-field" name="<?php echo esc_attr( $skin_input_field_attr ); ?>">
			<option value="global" <?php echo ( 'global' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Global from the customizer', 'bpf' ); ?></option>
			<option value="light" <?php echo ( 'light' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Light', 'bpf' ); ?></option>
			<option value="dark" <?php echo ( 'dark' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Dark', 'bpf' ); ?></option>
		</select>
	</div>
</div>
