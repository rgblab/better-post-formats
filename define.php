<?php

if ( ! defined( 'BPF_VERSION' ) ) {
	define( 'BPF_VERSION', '1.0.0' );
}

if ( ! defined( 'BPF_ABS_PATH' ) ) {
	define( 'BPF_ABS_PATH', dirname( __FILE__ ) );
}

if ( ! defined( 'BPF_REL_PATH' ) ) {
	define( 'BPF_REL_PATH', dirname( plugin_basename( __FILE__ ) ) );
}

if ( ! defined( 'BPF_URL_PATH' ) ) {
	define( 'BPF_URL_PATH', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'BPF_PREFIX' ) ) {
	define( 'BPF_PREFIX', 'bpf' );
}

if ( ! defined( 'BPF_OPTIONS' ) ) {
	define( 'BPF_OPTIONS', BPF_PREFIX . '_options' );
}

if ( ! defined( 'BPF_OPTIONS_SECTION' ) ) {
	define( 'BPF_OPTIONS_SECTION', BPF_PREFIX . '_options_section' );
}