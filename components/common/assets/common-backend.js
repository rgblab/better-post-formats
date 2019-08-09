jQuery(function ($) {
    'use strict';

    $(window).load(function () {
        //
        console.log('load 1');
        //

        upfDependency.init();
    });

    // $(document).ready(function () {
    //     upfDependency.init();
    // });

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
                //
                console.log('gutenberg 1');
                //

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