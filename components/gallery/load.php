<?php

$post_format = 'gallery';

// if post format is supported by theme
if ( uberPostFormatsHelper::isPostFormatSupported( $post_format ) ) {
	// add post format to array of post formats
	add_filter( 'upf_set_post_format', function ( $post_formats ) use ( $post_format ) {
		return uberPostFormatsHelper::setPostFormat( $post_formats, $post_format );
	} );

	// include component
	uberPostFormatsHelper::getComponent( $post_format, 'require' );

	// add section w/ settings
	// priority 3 to ensure loading after init and section
	add_action( 'customize_register', function () use ( $post_format ) {
		new uberPostFormatsCustomizerSettings( $post_format );
	}, 3 );
}