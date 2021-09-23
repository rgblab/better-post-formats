jQuery(
	function ($) {
		'use strict';

		$( document ).ready(
			function () {
				bpfGallery.init();
			}
		);

		$( document ).ajaxComplete(
			function (event, request, settings) {
				bpfGallery.init();
			}
		);

		var bpfGallery = {
			init: function () {
				var holder = $( '.bpf-content--format-gallery' );

				if (holder.length) {
					holder.each(
						function () {
							var currentHolder = $( this ),
								interval,
								noOfItems,
								prev          = $( '.bpf-content__gallery-prev' ),
								next          = $( '.bpf-content__gallery-next' ),
								pagination;

							// get no of items
							noOfItems = bpfGallery.getNoOfItems( currentHolder );

							// generate pagination
							bpfGallery.generatePagination( currentHolder, noOfItems );

							// set initial active classes for first image
							bpfGallery.setActiveClasses( currentHolder, 0 );

							// play
							interval = bpfGallery.play( currentHolder, noOfItems );

							// play/pause
							$( this ).on(
								{
									// on mouse enter call pause method
									mouseenter: function () {
										bpfGallery.pause( interval );
									},
									// on mouse leave call play method
									mouseleave: function () {
										interval = bpfGallery.play( currentHolder, noOfItems );
									}
								}
							);

							// goto prev
							prev.on(
								'click',
								function (event) {
									event.preventDefault();
									// call set new index method
									bpfGallery.setNewIndex( currentHolder, noOfItems, 'prev' );
								}
							);

							// goto next
							next.on(
								'click',
								function (event) {
									event.preventDefault();
									// call set new index method
									bpfGallery.setNewIndex( currentHolder, noOfItems, 'next' );
								}
							);

							// must go after generate pagination
							pagination = $( '.bpf-content__gallery-pagination li' );

							// goto specific
							pagination.on(
								'click',
								function (event) {
									event.preventDefault();
									// call set active classes method if current bullet is not active
									if ( ! $( this ).hasClass( 'active' )) {
										bpfGallery.setActiveClasses( currentHolder, $( this ).index() );
									}
								}
							);
						}
					);
				}
			},

			getNoOfItems: function (holder) {
				return holder.find( '.bpf-content__gallery-image' ).length;
			},

			generatePagination: function (holder, noOfItems) {
				var paginationHolder = holder.find( '.bpf-content__gallery-pagination' );

				while (noOfItems--) {
					paginationHolder.append( '<li class="bpf-content__gallery-page"></li>' );
				}
			},

			setActiveClasses: function (holder, nextIndex) {
				// remove active class from all
				holder.find( '.bpf-content__gallery-image' ).removeClass( 'active' );
				holder.find( '.bpf-content__gallery-pagination li' ).removeClass( 'active' );
				// set active class to new
				holder.find( '.bpf-content__gallery-image' ).eq( nextIndex ).addClass( 'active' );
				holder.find( '.bpf-content__gallery-pagination li' ).eq( nextIndex ).addClass( 'active' );
			},

			play: function (holder, noOfItems) {
				return setInterval(
					function () {
						// call set new index method
						bpfGallery.setNewIndex( holder, noOfItems, 'next' );
					},
					3000
				);
			},

			setNewIndex: function (holder, noOfItems, newIndex) {
				var currentIndex = holder.find( '.bpf-content__gallery-image.active' ).index();

				// set new index if prev
				if ('prev' === newIndex) {
					newIndex = (0 === currentIndex) ? noOfItems - 1 : currentIndex - 1;
				}

				// set new index if next
				if ('next' === newIndex) {
					newIndex = (noOfItems === currentIndex + 1) ? 0 : currentIndex + 1;
				}

				// call set active classes method
				bpfGallery.setActiveClasses( holder, newIndex );
			},

			pause: function (interval) {
				clearInterval( interval );
			}
		};
	}
);
