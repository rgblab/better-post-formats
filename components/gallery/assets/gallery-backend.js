jQuery(
	function ($) {
		'use strict';

		$( document ).ready(
			function () {
				bpfGallery.init();
				bpfGallery.makeSortable();
			}
		);

		var bpfGallery = {
			init: function () {
				var holder = $( '.bpf-control--gallery' );

				if (holder.length) {
					holder.each(
						function () {
							// add
							$( document ).on(
								'click',
								'.bpf-control__add',
								function (event) {
									event.preventDefault();
									// call media frame method
									bpfGallery.getMediaFrame( $( this ), true );
								}
							);

							// replace
							$( document ).on(
								'click',
								'.bpf-control__replace',
								function (event) {
									event.preventDefault();
									// call media frame method
									bpfGallery.getMediaFrame( $( this ), false );
								}
							);

							// remove
							$( document ).on(
								'click',
								'.bpf-control__remove',
								function (event) {
									event.preventDefault();
									// call remove item method
									bpfGallery.removeItem( $( this ) );
								}
							);
						}
					);
				}
			},

			getMediaFrame: function (button, multiple) {
				var mediaFrame = '';

				// if media frame already exist open it
				if (mediaFrame) {
					mediaFrame.open();
				}

				// create media frame
				mediaFrame = wp.media.frames.mediaFrame = wp.media(
					{
						title   : button.data( 'uploader-title' ),
						button  : {
							text: button.data( 'uploader-button-text' ),
						},
						library : {
							type: 'image'
						},
						multiple: multiple,
					}
				);

				// if add
				if (button.hasClass( 'bpf-control__add' )) {
					mediaFrame.on(
						'select',
						function () {
							var listIndex = $( '.bpf-control__gallery li' ).index( $( '.bpf-control__gallery li:last' ) ), // last item index
							selection     = mediaFrame.state().get( 'selection' );

							selection.map(
								function (attachment, i) {
									var index  = listIndex + (i + 1 + 1); // last item index plus one (since adding as next) plus one (skin dropdown already exists) plus current selection in media frame index
									attachment = attachment.toJSON();

									// append markup as in meta box template
									$( '.bpf-control__gallery' ).append( '<li><input type="hidden" name="bpf-gallery[' + index + ']" value="' + attachment.id + '"><img class="bpf-control__image" src="' + attachment.sizes.thumbnail.url + '"><a class="bpf-control__replace" href="#" data-uploader-title="' + backendLabels.uploaderTitle + '" data-uploader-button-text="' + backendLabels.uploaderButtonText + '"><span class="dashicons dashicons-edit"></span></a><a class="bpf-control__remove" href="#"><span class="dashicons dashicons-trash"></span></a></li>' );
								}
							);
						}
					);

					bpfGallery.makeSortable();
				}

				// if replace
				if (button.hasClass( 'bpf-control__replace' )) {
					mediaFrame.on(
						'select',
						function () {
							var attachment = mediaFrame.state().get( 'selection' ).first().toJSON();

							// replace value and preview image
							button.parent().find( 'input:hidden' ).attr( 'value', attachment.id );
							button.parent().find( '.bpf-control__image' ).attr( 'src', attachment.sizes.thumbnail.url );
						}
					);
				}

				mediaFrame.open();
			},

			removeItem: function (button) {
				// get parent of clicked button and remove it
				button.parents( 'li' ).fadeOut(
					400,
					function () {
						$( this ).remove();

						bpfGallery.resetIndex();
					}
				);
			},

			resetIndex: function () {
				var i = '';

				// rename in order of appearance
				$( '.bpf-control__gallery li' ).each(
					function (i) {
						$( this ).find( 'input:hidden' ).attr( 'name', 'bpf-gallery[' + (i + 1) + ']' ); // plus one (skin dropdown already exists)
					}
				);
			},

			makeSortable: function () {
				$( '.bpf-control__gallery' ).sortable(
					{
						opacity: 0.6,
						stop   : function () {
							bpfGallery.resetIndex();
						}
					}
				);
			},
		};
	}
);
