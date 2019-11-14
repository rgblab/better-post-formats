<?php

// FIXME add in helper
add_theme_support(
	'post-formats',
	array(
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	)
);

foreach ( glob( UPF_ABS_PATH . '/components/*/load.php' ) as $file ) {
	require_once $file;
}