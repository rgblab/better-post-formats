<?php

// filter has post thumbnail
add_filter( 'has_post_thumbnail', function () {
	return uberPostFormatsHelper::setFeatured();
} );

// filter post thumbnail html
add_filter( 'post_thumbnail_html', function ( $html ) {
	return uberPostFormatsHelper::getFeaturedMedia( $html );
} );