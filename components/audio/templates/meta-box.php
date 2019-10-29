<?php

$input_field_attr      = uberPostFormatsHelper::swapUnderscoreDash( $meta_key ); // upf-audio
$meta_value            = get_post_meta( $post->ID, $meta_key, true );
$skin_key              = 1;
$skin_value            = $meta_value[ $skin_key ];
$skin_input_field_attr = $input_field_attr . '[' . $skin_key . ']';

// FIXME remove skin

?>

<div class="upf-control upf-control--audio">
    <div class="upf-control__text">
        <label class="upf-control__label" for="<?php echo esc_attr( $input_field_attr . '[0]' ); ?>"><?php esc_html_e( 'Enter URL pointing to audio file or audio streaming provider', 'upf' ) ?></label>
        <input class="upf-control__text-field" type="text" name="<?php echo esc_attr( $input_field_attr . '[0]' ); ?>" value="<?php echo esc_attr( $meta_value[0] ); ?>">
    </div>
    <div class="upf-control__select">
        <label class="upf-control__label" for="<?php echo esc_attr( $skin_input_field_attr ); ?>"><?php esc_html_e( 'Set content skin', 'upf' ) ?></label>
        <select class="upf-control__select-field" name="<?php echo esc_attr( $skin_input_field_attr ); ?>">
            <option value="global" <?php echo ( 'global' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Global from the customizer', 'upf' ); ?></option>
            <option value="light" <?php echo ( 'light' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Light', 'upf' ); ?></option>
            <option value="dark" <?php echo ( 'dark' === $skin_value ) ? 'selected' : ''; ?>><?php esc_html_e( 'Dark', 'upf' ); ?></option>
        </select>
    </div>
</div>
<p>
	<?php echo sprintf( '%1s <a href="https://wordpress.org/support/article/embeds/#okay-so-what-sites-can-i-embed-from" target="_blank">%2s %3s</a>', esc_html__( 'You can use all of these', 'upf' ), esc_html__( 'web sites', 'upf' ), uberPostFormatsHelper::getSVG( 'external-link' ) ); ?>
</p>