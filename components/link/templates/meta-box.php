<?php

$input_field_attr = uberPostFormatsHelper::swapUnderscoreDash( $meta_key ); // upf-link

?>

<div class="upf-control upf-control--link">
    <div class="upf-control__text">
        <label class="upf-control__label" for="<?php echo esc_attr( $input_field_attr ); ?>[0]"><?php esc_html_e( 'Enter link URL', 'upf' ) ?></label>
        <input class="upf-control__text-field" type="text" name="<?php echo esc_attr( $input_field_attr ); ?>[0]" value="<?php echo esc_attr( get_post_meta( $post->ID, $meta_key, true )[0] ); ?>">
    </div>
    <div class="upf-control__select">
        <label class="upf-control__label" for="<?php echo esc_attr( $input_field_attr ); ?>[1]"><?php esc_html_e( 'Set where to open link', 'upf' ) ?></label>
        <select class="upf-control__select-field" name="<?php echo esc_attr( $input_field_attr . '[1]' ); ?>">
            <option value="new" <?php echo ( 'new' === get_post_meta( $post->ID, $meta_key, true )[1] ) ? 'selected' : ''; ?>><?php esc_html_e( 'New Window', 'upf' ); ?></option>
            <option value="same" <?php echo ( 'same' === get_post_meta( $post->ID, $meta_key, true )[1] ) ? 'selected' : ''; ?>><?php esc_html_e( 'Same Window', 'upf' ); ?></option>
        </select>
    </div>
</div>