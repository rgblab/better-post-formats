<?php

$meta_value       = get_post_meta( $post->ID, $meta_key, true );
$skin             = uberPostFormatsHelper::getSkin( $meta_value[2] );
$background_image = ! empty( $featured_image_url ) ? 'background-image:url(' . $featured_image_url . ')' : '';
$single           = is_single();
$permalink        = get_permalink();
$link             = $meta_value[0];
$target           = $meta_value[1];
$tag              = $single ? 'h1' : 'h2';

?>

<div class="upf-content upf-content--format-link <?php echo esc_attr( $skin ); ?>" style="<?php echo esc_attr( $background_image ); ?>">
	<?php if ( ! $single ): ?>
        <var class="upf-content__permalink" data-href="<?php echo esc_url( $permalink ); ?>" title="<?php the_title_attribute(); ?>"></var>
	<?php endif; ?>
    <var class="upf-content__icon upf-content__link" data-href="<?php echo esc_url( $link ); ?>" data-target="<?php echo esc_attr( $target ); ?>"></var>
	<?php echo '<' . esc_attr( $tag ); ?> class="upf-content__title">
	<?php the_title(); ?>
	<?php echo '</' . esc_attr( $tag ); ?>>
</div>