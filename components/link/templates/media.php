<?php

echo '<h1>LINK FRONTEND</h1>';
if ( is_single() ) {
	echo '<h2>SINGLE</h2>';
}

?>

<img alt="xxx" class="wp-post-image" src="<?php echo esc_attr( $featured_image_url ); ?>">
