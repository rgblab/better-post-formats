<?php

// filter has post thumbnail
add_filter(
	'has_post_thumbnail',
	function () {
		return betterPostFormatsHelper::setFeatured();
	}
);

// filter post thumbnail html
add_filter(
	'post_thumbnail_html',
	function ( $html ) {
		return betterPostFormatsHelper::getFeaturedMedia( $html );
	}
);

// filter bpf set style
add_filter(
	'bpf_set_style',
	function () {
		$style = '';

		$content_width_list = ! empty( get_option( BPF_OPTIONS )['content_width_list'] ) ? get_option( BPF_OPTIONS )['content_width_list'] : '100%';
		$style             .= '.bpf-content__grid{width:' . esc_attr( $content_width_list ) . '}';

		$content_width_single = ! empty( get_option( BPF_OPTIONS )['content_width_single'] ) ? get_option( BPF_OPTIONS )['content_width_single'] : '1200px';
		$style               .= '.single .bpf-content__grid{width:' . esc_attr( $content_width_single ) . '}';

		return $style;
	}
);
