<?php

$meta_value = get_post_meta( $post->ID, $meta_key, true );
$skin       = betterPostFormatsHelper::getSkin( $meta_value[0] );
$animation  = 'bpf-content--fade'; // TODO check global value for slider animation type

?>
<div class="bpf-content bpf-content--format-gallery <?php echo esc_attr( $animation ); ?> <?php echo esc_attr( $skin ); ?>">
	<?php foreach ( $meta_value as $image ): ?>
		<?php if ( is_numeric( $image ) ): ?>
			<img alt="<?php esc_attr_e( 'Gallery Image', 'bpf' ); ?>" class="bpf-content__gallery-image" src="<?php echo esc_attr( wp_get_attachment_url( $image ) ) ?>">
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="bpf-content__gallery-navigation">
		<div class="bpf-content__gallery-prev"></div>
		<div class="bpf-content__gallery-next"></div>
	</div>
	<div class="bpf-content__gallery-pagination"></div>
</div>
