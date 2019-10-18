<?php

// add section w/ settings
// priority 3 to ensure loading after init and panel
add_action( 'customize_register', function () {
	new uberPostFormatsCustomizerSettings( 'common' );
}, 3 );