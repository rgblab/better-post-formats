<?php

$meta_value       = get_post_meta( $post->ID, $meta_key, true );
$skin             = uberPostFormatsHelper::getSkin( $meta_value[2] );
$background_image = ! empty( $featured_image_url ) ? 'background-image:url(' . $featured_image_url . ')' : '';
$single           = is_single();
$permalink        = get_permalink();
$tag              = $single ? 'h1' : 'h2';
$quote            = $meta_value[0];
$author           = $meta_value[1];

?>

<div class="upf-content upf-content--format-quote <?php echo esc_attr( $skin ); ?>" style="<?php echo esc_attr( $background_image ); ?>">
	<?php if ( ! $single ): ?>
        <div class="upf-content__permalink" data-href="<?php echo esc_url( $permalink ); ?>"></div>
	<?php endif; ?>
    <blockquote class="upf-content__quote">
		<?php echo '<' . esc_attr( $tag ); ?> class="upf-content__quote-text">
		<?php echo esc_html( $quote ); ?>
		<?php echo '</' . esc_attr( $tag ); ?>>
		<?php if ( ! empty( $author ) ) : ?>
            <cite class="upf-content__quote-author"><?php echo esc_html( $author ); ?></cite>
		<?php endif; ?>
    </blockquote>
</div>