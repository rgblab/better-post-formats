<?php

$input_field_attr      = betterPostFormatsHelper::swapUnderscoreDash( $meta_key ); // bpf-video
$meta_value            = get_post_meta( $post->ID, $meta_key, true );
$skin_key              = 1;
$skin_value            = $meta_value[ $skin_key ];
$skin_input_field_attr = $input_field_attr . '[' . $skin_key . ']';

?>
<div class="bpf-control bpf-control--audio">
	<div class="bpf-control__text">
		<label class="bpf-control__label" for="<?php echo esc_attr( $input_field_attr . '[0]' ); ?>"><?php esc_html_e( 'Enter URL pointing to video file or video streaming provider', 'bpf' ); ?></label>
		<input class="bpf-control__text-field" type="text" name="<?php echo esc_attr( $input_field_attr . '[0]' ); ?>" value="<?php echo esc_attr( $meta_value[0] ); ?>">
	</div>
	<input type="hidden" name="<?php echo esc_attr( $skin_input_field_attr ); ?>">
</div>
<p>
	<?php echo sprintf( '%1s <a href="https://wordpress.org/support/article/embeds/#okay-so-what-sites-can-i-embed-from" target="_blank">%2s %3s</a>', esc_html__( 'You can use all of these', 'bpf' ), esc_html__( 'web sites', 'bpf' ), betterPostFormatsHelper::getSVG( 'external-link' ) ); ?>
</p>
