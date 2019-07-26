<?php

$meta_key         = $meta_box_id;
$input_field_attr = UberPostFormatsHelper::swapUnderscoreDash( $meta_key );

?>

<div class="components-base-control">
    <div class="components-base-control__field">
        <label class="components-base-control__label" for="<?php echo esc_attr( $input_field_attr ); ?>"><?php esc_html_e( 'Enter URL pointing to audio file or audio streaming provider', 'upf' ) ?></label>
        <input class="components-base-control__input" type="text" name="<?php echo esc_attr( $input_field_attr ); ?>" id="<?php echo esc_attr( $input_field_attr ); ?>" value="<?php echo esc_attr( get_post_meta( $post->ID, $meta_key, true ) ); ?>">
    </div>
</div>
<p>
	<?php echo sprintf( '%1s <a href="https://wordpress.org/support/article/embeds/#okay-so-what-sites-can-i-embed-from" target="_blank">%2s %3s</a>', esc_html__( 'You can use all of these', 'upf' ), esc_html__( 'web sites', 'upf' ), UberPostFormatsHelper::getSVG( 'external-link' ) ); ?>
</p>
