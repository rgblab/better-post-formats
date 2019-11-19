<?php

foreach ( glob( UPF_ABS_PATH . '/components/*/load.php' ) as $file ) {
	require_once $file;
}

// add theme support
add_theme_support( 'post-formats', uberPostFormatsHelper::getPostFormats() );