<?php

// filter has post thumbnail
add_filter( 'has_post_thumbnail', function () {
	return uberPostFormatsHelper::setFeatured();
} );

// filter post thumbnail html
add_filter( 'post_thumbnail_html', function ( $html ) {
	return uberPostFormatsHelper::getFeaturedMedia( $html );
} );

// filter upf set style
add_filter( 'upf_set_style', function () {
	$style = '';

	$content_width_list = get_option( UPF_OPTIONS )['content_width_list'] ? get_option( UPF_OPTIONS )['content_width_list'] : '100%';
	$style              .= '.upf-content__grid{width:' . esc_attr( $content_width_list ) . '}';

	$content_width_single = get_option( UPF_OPTIONS )['content_width_single'] ? get_option( UPF_OPTIONS )['content_width_single'] : '1200px';
	$style                .= '.single .upf-content__grid{width:' . esc_attr( $content_width_single ) . '}';

	return $style;
} );
