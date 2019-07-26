<?php

// TODO check if current theme supports audio post fomrat
if ( UberPostFormatsHelper::isPostFormatSupported( 'audio' ) ) {
	require_once UPF_ABS_PATH . '/components/audio/audio.php';
}

