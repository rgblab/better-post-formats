<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// filter post thumbnail output
// return apply_filters( 'post_thumbnail_html', $html, $post->ID, $post_thumbnail_id, $size, $attr );
add_filter( 'post_thumbnail_html', 'test1', 10, 5 );

/**
 * @param $html
 * @param $post_id
 * @param $post_thumbnail_id
 * @param $size
 * @param $attr
 *
 * @return string
 * @see get_the_post_thumbnail
 */
function test1( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
	$html = '';

	$html .= '<h1>KPGS</h1>';

	return $html;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// filter if post has thumbnail
// return (bool) apply_filters( 'has_post_thumbnail', $has_thumbnail, $post, $thumbnail_id );
add_filter( 'has_post_thumbnail', 'test2', 10, 4 );

/**
 * @param $has_thumbnail
 * @param $post
 * @param $thumbnail_id
 *
 * @return bool
 * @see has_post_thumbnail
 */
function test2( $has_thumbnail, $post, $thumbnail_id ) {

	return true;
}
