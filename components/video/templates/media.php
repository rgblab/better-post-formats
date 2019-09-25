<?php

$meta_value = get_post_meta( $post->ID, $meta_key, true );
$oembed     = wp_oembed_get( $meta_value[0] );
$skin       = uberPostFormatsHelper::getSkin( $meta_value[1] );
$controls   = 'controls'; // TODO check global value to use custom controls

?>

<div class="upf-content upf-content--format-video">
	<?php if ( ! empty( $oembed ) ) : ?>
		<?php echo $oembed; ?>
	<?php else: ?>
        <video class="<?php echo esc_attr( $skin ); ?>" <?php echo esc_attr( $controls ); ?>>
            <source src="<?php echo esc_url( $meta_value ); ?>">
			<?php esc_html_e( 'Your browser does not support video element', 'upf' ); ?>
        </video>
		<?php // TODO custom controls container ?>
	<?php endif; ?>
</div>