<?php


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


<?php

$input_field_attr = uberPostFormatsHelper::swapUnderscoreDash( $meta_key );
$ids              = get_post_meta( $post->ID, $meta_key, true );

?>

<div class="upf-control upf-control--gallery">
    <a class="upf-control__add" href="#" data-uploader-title="<?php esc_attr_e( 'Add images to gallery', 'upf' ); ?>" data-uploader-button-text="<?php esc_attr_e( 'Add images', 'upf' ); ?>"><?php esc_html_e( 'Add images', 'upf' ); ?></a>
    <ul id="upf-control__gallery">

		<?php

		if ( $ids ) {
			foreach ( $ids as $key => $value ) {
				$image = wp_get_attachment_image_url( $value );

				?>

                <li>
                    <input type="hidden" name="<?php echo esc_attr( $input_field_attr ); ?>[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value ); ?>">
                    <img alt="thumbnail" class="upf-control__image" src="<?php echo esc_url( $image ); ?>">
                    <a class="upf-control__replace" href="#" data-uploader-title="<?php esc_attr_e( 'Replace image', 'upf' ); ?>" data-uploader-button-text="<?php esc_attr_e( 'Replace image', 'upf' ); ?>">
                        <span class="dashicons dashicons-edit"></span>
                    </a>
                    <a class="upf-control__remove" href="#">
                        <span class="dashicons dashicons-trash"></span>
                    </a>
                </li>

				<?php

			}
		}

		?>

    </ul>
</div>