<?php

$meta_key         = $meta_box_id;
$input_field_attr = uberPostFormatsHelper::swapUnderscoreDash( $meta_key );

// TODO use proper vars in template

?>

<!--<div class="components-base-control">-->
<!--    <div class="components-base-control__field">-->
<!--        <label class="components-base-control__label" for="--><?php //echo esc_attr( $input_field_attr ); ?><!--">--><?php //esc_html_e( 'Enter URL pointing to audio file or audio streaming provider', 'upf' ) ?><!--</label>-->
<!--        <input class="components-base-control__input" type="text" name="--><?php //echo esc_attr( $input_field_attr ); ?><!--" id="--><?php //echo esc_attr( $input_field_attr ); ?><!--" value="--><?php //echo esc_attr( get_post_meta( $post->ID, $meta_key, true ) ); ?><!--">-->
<!---->
<!--        <input type="text" name="--><?php //echo esc_attr( $input_field_attr . '-1' ); ?><!--" id="--><?php //echo esc_attr( $input_field_attr . '-1' ); ?><!--" value="--><?php //echo esc_attr( get_post_meta( $post->ID, $meta_key . '_1', true ) ); ?><!--">-->
<!---->
<!--    </div>-->
<!--</div>-->
<!--<p>-->
<!--	--><?php //echo sprintf( '%1s <a href="https://wordpress.org/support/article/embeds/#okay-so-what-sites-can-i-embed-from" target="_blank">%2s %3s</a>', esc_html__( 'You can use all of these', 'upf' ), esc_html__( 'web sites', 'upf' ), uberPostFormatsHelper::getSVG( 'external-link' ) ); ?>
<!--</p>-->


<?php $ids = get_post_meta( $post->ID, 'vdw_gallery_id', true ); ?>

<table class="form-table">
    <tr>
        <td>
            <a class="gallery-add button" href="#" data-uploader-title="Add image(s) to gallery" data-uploader-button-text="Add image(s)">Add
                image(s)</a>

            <ul id="upf_gallery-list">
				<?php if ( $ids ) : foreach ( $ids as $key => $value ) : $image = wp_get_attachment_image_src( $value ); ?>

                    <li>
                        <input type="hidden" name="vdw_gallery_id[<?php echo $key; ?>]" value="<?php echo $value; ?>">
                        <img class="image-preview" src="<?php echo $image[0]; ?>">
                        <a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image">Change
                            image</a><br>
                        <small><a class="remove-image" href="#">Remove image</a></small>
                    </li>

				<?php endforeach; endif; ?>
            </ul>

        </td>
    </tr>
</table>