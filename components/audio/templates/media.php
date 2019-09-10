<?php

$meta_value = get_post_meta( $post->ID, $meta_key, true );
$oembed     = wp_oembed_get( $meta_value );
$controls   = 'controls'; // TODO check global value to use custom controls

?>

<div class="upf-content upf-content--audio">
	<?php if ( ! empty( $oembed ) ) : ?>
		<?php echo $oembed; ?>
	<?php else: ?>
		<?php if ( ! empty( $featured_image_url ) ) : ?>
            <img alt="<?php esc_attr_e( 'Featured Image', 'upf' ); ?>" class="upf-content__image wp-post-image" src="<?php echo esc_attr( $featured_image_url ) ?>">
		<?php endif; ?>
        <audio <?php echo esc_attr( $controls ); ?>>
            <source src="<?php echo esc_url( $meta_value ); ?>">
			<?php esc_html_e( 'Your browser does not support audio element', 'upf' ); ?>
        </audio>
		<?php // TODO custom controls container ?>
	<?php endif; ?>
</div>