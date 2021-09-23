<?php

$meta_value = get_post_meta( $post->ID, $meta_key, true );
$oembed     = wp_oembed_get( $meta_value[0] );
$skin       = betterPostFormatsHelper::getSkin( $meta_value[1] );
$controls   = 'controls'; // TODO check global value to use custom controls

?>
<div class="bpf-content bpf-content--format-audio">
	<?php if ( ! empty( $oembed ) ) : ?>
		<?php echo $oembed; ?>
	<?php else : ?>
		<?php if ( ! empty( $featured_image_url ) ) : ?>
			<img alt="<?php esc_attr_e( 'Featured Image', 'bpf' ); ?>" class="bpf-content__image wp-post-image" src="<?php echo esc_attr( $featured_image_url ); ?>">
		<?php endif; ?>
		<audio class="<?php echo esc_attr( $skin ); ?>" <?php echo esc_attr( $controls ); ?>>
			<source src="<?php echo esc_url( $meta_value[0] ); ?>">
			<?php esc_html_e( 'Your browser does not support audio element', 'bpf' ); ?>
		</audio>
		<?php // TODO custom controls container ?>
	<?php endif; ?>
</div>
