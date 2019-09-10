<?php

$input_field_attr = uberPostFormatsHelper::swapUnderscoreDash( $meta_key ); // upf-quote

?>

<div class="upf-control upf-control--quote">
    <div class="upf-control__textarea">
        <label class="upf-control__label" for="<?php echo esc_attr( $input_field_attr ); ?>[0]"><?php esc_html_e( 'Enter quotation text', 'upf' ) ?></label>
        <textarea class="upf-control__textarea-field" name="<?php echo esc_attr( $input_field_attr ); ?>[0]" rows="4"><?php echo esc_attr( get_post_meta( $post->ID, $meta_key, true )[0] ); ?></textarea>
    </div>
    <div class="upf-control__text">
        <label class="upf-control__label" for="<?php echo esc_attr( $input_field_attr ); ?>[1]"><?php esc_html_e( 'Enter quotation author', 'upf' ) ?></label>
        <input class="upf-control__text-field" type="text" name="<?php echo esc_attr( $input_field_attr ); ?>[1]" value="<?php echo esc_attr( get_post_meta( $post->ID, $meta_key, true )[1] ); ?>">
    </div>
</div>