jQuery(
	function ($) {
		'use strict';

		$( window ).load(
			function () {
				bpfDependency.init();
				bpfObserver.init();
			}
		);

		var bpfDependency = {
			init: function () {
				var gutenbergEditorHolder = $( '.editor-post-format' ).find( 'select' ),
					classicEditorHolder       = $( '#post-formats-select' ).find( 'input' );

				// call gutenberg handler method
				if (gutenbergEditorHolder.length) {
					bpfDependency.gutenbergEditorHandler( gutenbergEditorHolder );
				}

				// call classic handler method
				if (classicEditorHolder.length) {
					bpfDependency.classicEditorHandler( classicEditorHolder );
				}
			},

			gutenbergEditorHandler: function (holder) {
				holder.find( 'option' ).each(
					function () {
						// show if selected
						if ($( this ).is( ':selected' )) {
							// call set meta box visibility method
							bpfDependency.setMetaBoxVisibility( 'show', $( this ).val() );
						} else {
							// call set meta box visibility method
							bpfDependency.setMetaBoxVisibility( 'hide', $( this ).val() );
						}
					}
				);

				// call handler method on change
				holder.on(
					'change',
					function () {
						bpfDependency.gutenbergEditorHandler( holder );
					}
				);
			},

			classicEditorHandler: function (holder) {
				// hide all
				holder.each(
					function () {
						// show if checked
						if ($( this ).is( ':checked' )) {
							// call set meta box visibility method
							bpfDependency.setMetaBoxVisibility( 'show', $( this ).val() );
						} else {
							// call set meta box visibility method
							bpfDependency.setMetaBoxVisibility( 'hide', $( this ).val() );
						}
					}
				);

				// call handler method on click
				holder.on(
					'click',
					function () {
						bpfDependency.classicEditorHandler( holder );
					}
				);
			},

			setMetaBoxVisibility: function (visibility, postFormat) {
				// if hide
				if ('hide' === visibility) {
					$( '#bpf_' + postFormat ).hide();
				}

				// if show
				if ('show' === visibility) {
					$( '#bpf_' + postFormat ).fadeIn();
				}
			}
		};

		var bpfObserver = {
			init: function () {
				var holder = $( '.edit-post-sidebar__panel-tabs ul li:first-child button' );

				if (holder.length) {
					var mutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;

					// if supported by browser
					if (mutationObserver) {
						var holderNode = holder[0]; // vanilla js node

						// create mutation observer instance
						mutationObserver = new MutationObserver(
							function (mutations) {
								mutations.forEach(
									function (mutation) {
										if (holder.hasClass( 'is-active' )) {
											bpfDependency.init();
										}
									}
								);
							}
						);

						// mutation observer options, only class name
						var options = {
							attributes     : true,
							attributeFilter: ['class'],
							subtree        : false
						};

						// observe node with options
						mutationObserver.observe( holderNode, options );
					}
				}
			},
		};
	}
);
