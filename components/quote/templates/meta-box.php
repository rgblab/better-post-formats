<?php

$input_field_attr      = uberPostFormatsHelper::swapUnderscoreDash( $meta_key ); // upf-quote
$meta_value            = get_post_meta( $post->ID, $meta_key, true );
$skin_key              = 2;
$skin_value            = $meta_value[ $skin_key ];
$skin_input_field_attr = $input_field_attr . '[' . $skin_key . ']';

?>

<div class="upf-control upf-control--quote">
    <div class="upf-control__textarea">
        <label class="upf-control__label" for="<?php echo esc_attr( $input_field_attr . '[0]' ); ?>"><?php esc_html_e( 'Enter quotation text', 'upf' ) ?></label>
        <textarea class="upf-control__textarea-field" name="<?php echo esc_attr( $input_field_attr . '[0]' ); ?>" rows="4"><?php echo esc_attr( $meta_value[0] ); ?></textarea>
    </div>
    <div class="upf-control__text">
        <label class="upf-control__label" for="<?php echo esc_attr( $input_field_attr . '[1]' ); ?>"><?php esc_html_e( 'Enter quotation author', 'upf' ) ?></label>
        <input class="upf-control__text-field" type="text" name="<?php echo esc_attr( $input_field_attr . '[1]' ); ?>" value="<?php echo esc_attr( $meta_value[1] ); ?>">
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