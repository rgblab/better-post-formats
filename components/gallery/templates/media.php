<?php

$meta_value = get_post_meta( $post->ID, $meta_key, true );
$skin       = uberPostFormatsHelper::getSkin( $meta_value[0] );
$animation  = 'upf-content--fade'; // TODO check global value for slider animation type

?>

<div class="upf-content upf-content--format-gallery <?php echo esc_attr( $animation ); ?> <?php echo esc_attr( $skin ); ?>">
	<?php foreach ( $meta_value as $image ): ?>
		<?php if ( is_numeric( $image ) ): ?>
            <img alt="<?php esc_attr_e( 'Gallery Image', 'upf' ); ?>" class="upf-content__gallery-image" src="<?php echo esc_attr( wp_get_attachment_url( $image ) ) ?>">
		<?php endif; ?>
	<?php endforeach; ?>
    <div class="upf-content__gallery-navigation">
        <div class="upf-content__gallery-prev"></div>
        <div class="upf-content__gallery-next"></div>
    </div>
</div>