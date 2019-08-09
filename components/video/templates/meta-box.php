<?php

$input_field_attr = uberPostFormatsHelper::swapUnderscoreDash( $meta_key ); // upf-video

?>

<div class="upf-control upf-control--audio">
    <div class="upf-control__text">
        <label class="upf-control__label" for="<?php echo esc_attr( $input_field_attr ); ?>"><?php esc_html_e( 'Enter URL pointing to video file or video streaming provider', 'upf' ) ?></label>
        <input class="upf-control__text-field" type="text" name="<?php echo esc_attr( $input_field_attr ); ?>" value="<?php echo esc_attr( get_post_meta( $post->ID, $meta_key, true ) ); ?>">
    </div>
</div>
<p>
	<?php echo sprintf( '%1s <a href="https://wordpress.org/support/article/embeds/#okay-so-what-sites-can-i-embed-from" target="_blank">%2s %3s</a>', esc_html__( 'You can use all of these', 'upf' ), esc_html__( 'web sites', 'upf' ), uberPostFormatsHelper::getSVG( 'external-link' ) ); ?>
</p>
