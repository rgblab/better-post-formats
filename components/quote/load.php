<?php

$post_format = 'quote';

// if post format is supported by theme
if ( uberPostFormatsHelper::isPostFormatSupported( $post_format ) ) {
	// add post format to array of post formats
	add_filter( 'upf_set_post_format', function ( $post_formats ) use ( $post_format ) {
		return uberPostFormatsHelper::setPostFormat( $post_formats, $post_format );
	} );

	// include component
	uberPostFormatsHelper::getComponent( $post_format, 'require' );
}