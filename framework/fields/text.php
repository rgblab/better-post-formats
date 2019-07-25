<div class="components-base-control">
    <div class="components-base-control__field">
        <label class="components-base-control__label" for="<?php echo esc_attr( $this->input_field_attr ); ?>"><?php echo $this->input_field_label; // WPCS: XSS ok ?></label>
        <input class="components-base-control__input" type="text" name="<?php echo esc_attr( $this->input_field_attr ); ?>" id="<?php echo esc_attr( $this->input_field_attr ); ?>" value="<?php echo esc_attr( get_post_meta( $post->ID, $this->meta_box_id, true ) ); ?>">
    </div>
</div>
<p><?php echo $this->input_field_description; // WPCS: XSS ok  ?></p>