<?php

foreach ( glob( UPF_ABS_PATH . '/components/*/load.php' ) as $file ) {
	require_once $file;
}