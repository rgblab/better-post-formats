jQuery(
	function ($) {
		'use strict';

		$( document ).ready(
			function () {
				bpfModifyTag.init();
				bpfResizeIFrame.init();
				bpfAddArticleClass.init();
			}
		);

		$( document ).ajaxComplete(
			function () {
				bpfModifyTag.init();
				bpfResizeIFrame.init();
				bpfAddArticleClass.init();
			}
		);

		$( window ).resize(
			function () {
				bpfResizeIFrame.init();
			}
		);

		var bpfModifyTag = {
			init: function () {
				var holder = $( '.bpf-content' );

				if (holder.length) {
					holder.each(
						function () {
							// call replace permalink method
							var modifiedPermalink = bpfModifyTag.replacePermalink( $( this ) );

							// if there is no permalink, call modify tag method
							if ( ! modifiedPermalink) {
								bpfModifyTag.modifyTag( $( this ), 'replace' );
							}
						}
					);
				}
			},

			replacePermalink: function (holder) {
				var defaultPermalink = holder.closest( 'a' );

				if (defaultPermalink.length) {
					// replace a with div
					defaultPermalink.replaceWith(
						function () {
							// call modify tag method
							var newHtml = bpfModifyTag.modifyTag( $( this ), 'return' );

							return $(
								'<div/>',
								{
									class: 'bpf-default-permalink--replaced',
									html : newHtml,
								}
							);
						}
					);

					return true;
				} else {
					return false;
				}
			},

			modifyTag: function (holder, option) {
				var oldHtml = holder.html(),
					newHtml     = '';

				if ('replace' === option) {
					if (holder.hasClass( 'bpf-content--format-link' ) || holder.hasClass( 'bpf-content--format-quote' )) {
						newHtml = oldHtml.replace( /var/g, 'a' ).replace( /data-/g, '' );
						holder.html( newHtml );

						console.log( 'replace' );
					}
				} else if ('return' === option) {
					if (holder.find( '.bpf-content--format-link' ) || holder.find( '.bpf-content--format-quote' )) {
						newHtml = oldHtml.replace( /var/g, 'a' ).replace( /data-/g, '' );
					} else {
						newHtml = oldHtml;
					}

					console.log( 'return' );

					return newHtml;
				}
			}
		};

		var bpfResizeIFrame = {
			init: function () {
				var holder = $( '.bpf-content iframe' );

				// call resize method
				if (holder.length) {
					holder.each(
						function () {
							bpfResizeIFrame.resize( $( this ) );
						}
					);
				}
			},

			resize: function (holder) {
				var ratio = holder.attr( 'width' ) / holder.attr( 'height' );

				holder.height( holder.width() / ratio );
			},
		};

		var bpfAddArticleClass = {
			init: function () {
				var body = $( 'body' ),
					holder   = $( '.format-link, .format-quote' );

				if (holder.length) {
					holder.each(
						function () {
							// if single and bpf content in body
							if (body.hasClass( 'single' )) {
								if (body.find( '.bpf-content' ).length) {
									// call add class method
									bpfAddArticleClass.addClass( body );
								}
							} else {
								// if not single and bpf content in wrapper, should be article tag
								if ($( this ).find( '.bpf-content' ).length) {
									// call add class method
									bpfAddArticleClass.addClass( $( this ) );
								}
							}
						}
					);
				}
			},

			addClass: function (holder) {
				holder.addClass( 'bpf-hide-default-title' );
			},
		};
	}
);
