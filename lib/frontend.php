<?php

// filter post thumbnail output
add_filter( 'post_thumbnail_html', function () {
	return uberPostFormatsHelper::getFeaturedMedia();
} );

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// filter if post has thumbnail
add_filter( 'has_post_thumbnail', 'test2', 10, 3 );

/**
 * @param $has_thumbnail
 * @param $post
 * @param $thumbnail_id
 *
 * @return bool
 * @see has_post_thumbnail
 */
function test2( $has_thumbnail, $post, $thumbnail_id ) {
	// tmp return value
	return true;

	// check for given post if it has uber post format meta
}

// add_filter( 'upf_set_post_format', function ( $post_formats ) use ( $post_format ) {
// 	return uberPostFormatsHelper::setPostFormat( $post_formats, $post_format );
// } );