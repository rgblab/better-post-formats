<?php

if ( ! defined( 'UPF_VERSION' ) ) {
	define( 'UPF_VERSION', '1.0.0' );
}

if ( ! defined( 'UPF_ABS_PATH' ) ) {
	define( 'UPF_ABS_PATH', dirname( __FILE__ ) );
}

if ( ! defined( 'UPF_REL_PATH' ) ) {
	define( 'UPF_REL_PATH', dirname( plugin_basename( __FILE__ ) ) );
}

if ( ! defined( 'UPF_URL_PATH' ) ) {
	define( 'UPF_URL_PATH', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'UPF_PREFIX' ) ) {
	define( 'UPF_PREFIX', 'upf' );
}

if ( ! defined( 'UPF_OPTIONS' ) ) {
	define( 'UPF_OPTIONS', UPF_PREFIX . '_options' );
}

if ( ! defined( 'UPF_OPTIONS_SECTION' ) ) {
	define( 'UPF_OPTIONS_SECTION', UPF_PREFIX . '_options_section' );
}