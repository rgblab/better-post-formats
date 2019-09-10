<?php

$meta_value = get_post_meta( $post->ID, $meta_key, true );

?>

<div class="upf-content upf-content--gallery">
	<?php foreach ( $meta_value as $image ): ?>
        <img alt="<?php esc_attr_e( 'Gallery Image', 'upf' ); ?>" class="upf-content__gallery-image" src="<?php echo esc_attr( wp_get_attachment_url( $image ) ) ?>">
	<?php endforeach; ?>
</div>