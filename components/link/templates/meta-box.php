<?php

$input_field_attr      = betterPostFormatsHelper::swapUnderscoreDash( $meta_key ); // bpf-link
$meta_value            = get_post_meta( $post->ID, $meta_key, true );
$skin_key              = 2;
$skin_value            = $meta_value[ $skin_key ];
$skin_input_field_attr = $input_field_attr . '[' . $skin_key . ']';

?>
<div class="bpf-control bpf-control--link">
	<div class="bpf-control__text">
		<label class="bpf-control__label" for="<?php echo esc_attr( $input_field_attr . '[0]' ); ?>"><?php esc_html_e( 'Enter link URL', 'bpf' ); ?></label>
		<input class="bpf-control__text-field" type="text" name="<?php echo esc_attr( $input_field_attr . '[0]' ); ?>" value="<?php echo esc_attr( $meta_value[0] ); ?>">
	</div>
	<div class="bpf-control__select">
		<label class="bpf-control__label" for="<?php echo esc_attr( $input_field_attr . '[1]' ); ?>"><?php esc_html_e( 'Set where to open link', 'bpf' ); ?></label>
		<select class="bpf-control__select-field" name="<?php echo esc_attr( $input_field_attr . '[1]' ); ?>">
			<option value="_blank" <?php echo ( '_blank' === $meta_value[1] ) ? 'selected' : ''; ?>><?php esc_html_e( 'New browser tab', 'bpf' ); ?></option>
			<option value="_self" <?php echo ( '_self' === $meta_value[1] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Same browser tab', 'bpf' ); ?></option>
		</select>
	</div>
	<div class="bpf-control__select bpf-control--no-bottom-margin">
		<label class="bpf-control__label" for="<?php echo esc_attr( $skin_input_field_attr ); ?>"><?php esc_html_e( 'Set content skin', 'bpf' ); ?></label>
		<select class="bpf-control__select-field" name="<?php echo esc_attr( $skin_input_field_attr ); ?>">
			<option value="global" <?php echo ( 'global' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Global from the customizer', 'bpf' ); ?></option>
			<option value="light" <?php echo ( 'light' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Light', 'bpf' ); ?></option>
			<option value="dark" <?php echo ( 'dark' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Dark', 'bpf' ); ?></option>
		</select>
	</div>
</div>
