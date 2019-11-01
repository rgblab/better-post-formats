jQuery(function ($) {
    'use strict';

    $(window).load(function () {
        upfDependency.init();
        upfObserver.init();
    });

    var upfObserver = {
        init: function () {
            var mutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;

            // create mutation observer prototype for class changes
            $.fn.attrChange = function (attrChangeCallback) {
                if (mutationObserver) {
                    var options = {
                        attributes: true,
                        attributeFilter: ['class'],
                        subtree: false,
                    };

                    var observer = new mutationObserver(function (mutations) {
                        mutations.forEach(function (event) {
                            attrChangeCallback.call(event.target);
                        });
                    });

                    return this.each(function () {
                        observer.observe(this, options);
                    });
                }
            };

            // append event listener
            $('.edit-post-sidebar__panel-tabs ul li:first-child button').attrChange(function () {
                if ($(this).hasClass('is-active')) {
                    upfDependency.init();
                }
            });
        }
    };

    var upfDependency = {
        init: function () {
            var gutenbergEditorHolder = $('.editor-post-format').find('select'),
                classicEditorHolder = $('#post-formats-select').find('input');

            // call gutenberg handler method
            if (gutenbergEditorHolder.length) {
                upfDependency.gutenbergEditorHandler(gutenbergEditorHolder);
            }

            // call classic handler method
            if (classicEditorHolder.length) {
                upfDependency.classicEditorHandler(classicEditorHolder);
            }
        },

        gutenbergEditorHandler: function (holder) {
            holder.find('option').each(function () {
                // show if selected
                if ($(this).is(':selected')) {
                    upfDependency.setMetaBoxVisibility('show', $(this).val());
                } else {
                    upfDependency.setMetaBoxVisibility('hide', $(this).val());
                }
            });

            // call handler method on change
            holder.on('change', function () {
                upfDependency.gutenbergEditorHandler(holder);
            });
        },

        classicEditorHandler: function (holder) {
            // hide all
            holder.each(function () {
                // show if checked
                if ($(this).is(':checked')) {
                    upfDependency.setMetaBoxVisibility('show', $(this).val());
                } else {
                    upfDependency.setMetaBoxVisibility('hide', $(this).val());
                }
            });

            // call handler method on click
            holder.on('click', function () {
                upfDependency.classicEditorHandler(holder);
            });
        },

        setMetaBoxVisibility: function (visibility, postFormat) {
            // if hide
            if ('hide' === visibility) {
                $('#upf_' + postFormat).hide();
            }

            // if show
            if ('show' === visibility) {
                $('#upf_' + postFormat).fadeIn();
            }
        }
    };
});
jQuery(function ($) {
    'use strict';

    $(document).ready(function () {
        upfGallery.init();
        upfGallery.makeSortable();
    });

    var upfGallery = {
        init: function () {
            var holder = $('.upf-control--gallery');

            if (holder.length) {
                holder.each(function () {
                    // add
                    $(document).on('click', '.upf-control__add', function (event) {
                        event.preventDefault();
                        // call media frame method
                        upfGallery.getMediaFrame($(this), true);
                    });

                    // replace
                    $(document).on('click', '.upf-control__replace', function (event) {
                        event.preventDefault();
                        // call media frame method
                        upfGallery.getMediaFrame($(this), false);
                    });

                    // remove
                    $(document).on('click', '.upf-control__remove', function (event) {
                        event.preventDefault();
                        // call remove item method
                        upfGallery.removeItem($(this));
                    });
                });
            }
        },

        getMediaFrame: function (button, multiple) {
            var mediaFrame = '';

            // if media frame already exist open it
            if (mediaFrame) {
                mediaFrame.open();
            }

            // create media frame
            mediaFrame = wp.media.frames.mediaFrame = wp.media({
                title: button.data('uploader-title'),
                button: {
                    text: button.data('uploader-button-text'),
                },
                library: {
                    type: 'image'
                },
                multiple: multiple,
            });

            // if add
            if (button.hasClass('upf-control__add')) {
                mediaFrame.on('select', function () {
                    var listIndex = $('.upf-control__gallery li').index($('.upf-control__gallery li:last')), // last item index
                        selection = mediaFrame.state().get('selection');

                    selection.map(function (attachment, i) {
                        var index = listIndex + (i + 1 + 1); // last item index plus one (since adding as next) plus one (skin dropdown already exists) plus current selection in media frame index
                        attachment = attachment.toJSON();

                        // append markup as in meta box template
                        $('.upf-control__gallery').append('<li><input type="hidden" name="upf-gallery[' + index + ']" value="' + attachment.id + '"><img class="upf-control__image" src="' + attachment.sizes.thumbnail.url + '"><a class="upf-control__replace" href="#" data-uploader-title="Replace image" data-uploader-button-text="Replace image"><span class="dashicons dashicons-edit"></span></a><a class="upf-control__remove" href="#"><span class="dashicons dashicons-trash"></span></a></li>');
                    });
                });

                upfGallery.makeSortable();
            }

            // if replace
            if (button.hasClass('upf-control__replace')) {
                mediaFrame.on('select', function () {
                    var attachment = mediaFrame.state().get('selection').first().toJSON();

                    // replace value and preview image
                    button.parent().find('input:hidden').attr('value', attachment.id);
                    button.parent().find('.upf-control__image').attr('src', attachment.sizes.thumbnail.url);
                });
            }

            mediaFrame.open();
        },

        removeItem: function (button) {
            // get parent of clicked button and remove it
            button.parents('li').fadeOut(400, function () {
                $(this).remove();

                upfGallery.resetIndex();
            });
        },

        resetIndex: function () {
            var i = '';

            // rename in order of appearance
            $('.upf-control__gallery li').each(function (i) {
                $(this).find('input:hidden').attr('name', 'upf-gallery[' + (i + 1) + ']'); // plus one (skin dropdown already exists)
            });
        },

        makeSortable: function () {
            $('.upf-control__gallery').sortable({
                opacity: 0.6,
                stop: function () {
                    upfGallery.resetIndex();
                }
            });
        },
    };
});