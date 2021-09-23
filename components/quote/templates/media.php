<?php

$meta_value       = get_post_meta( $post->ID, $meta_key, true );
$skin             = betterPostFormatsHelper::getSkin( $meta_value[2] );
$background_image = ! empty( $featured_image_url ) ? 'background-image:url(' . $featured_image_url . ')' : '';
$single           = is_single();
$permalink        = get_permalink();
$title_tag        = $single ? 'h1' : 'h2';
$quote            = $meta_value[0];
$author           = $meta_value[1];

?>
<div class="bpf-content bpf-content--format-quote <?php echo esc_attr( $skin ); ?>" style="<?php echo esc_attr( $background_image ); ?>">
	<div class="bpf-content__grid">
		<?php if ( ! $single ) : ?>
			<var class="bpf-content__permalink" data-href="<?php echo esc_url( $permalink ); ?>" title="<?php the_title_attribute(); ?>"></var>
		<?php endif; ?>
		<div class="bpf-content__icon"></div>
		<blockquote class="bpf-content__quote">
			<?php echo '<' . esc_attr( $title_tag ); ?> class="bpf-content__quote-text">
			<?php echo esc_html( $quote ); ?>
			<?php echo '</' . esc_attr( $title_tag ); ?>>
			<?php if ( ! empty( $author ) ) : ?>
				<cite class="bpf-content__quote-author"><?php echo esc_html( $author ); ?></cite>
			<?php endif; ?>
		</blockquote>
	</div>
</div>
