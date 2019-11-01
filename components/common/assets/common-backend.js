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