jQuery(function ($) {
    'use strict';

    $(document).ready(function () {
        upfDependency.init();
    });

    $(window).load(function () {
        upfDependency.init(true);
    });


    var upfDependency = {
        init: function (onLoad) {
            console.log('here');

            if (onLoad) {
                upfDependency.gutenbergEditor();
            } else {
                upfDependency.classicEditor();
            }
        },
        classicEditor: function () {
            var $holder = $('#post-formats-select'),
                $postFormats = $holder.find('input[name="post_format"]'),
                $selectedFormat = $holder.find('input[name="post_format"]:checked'),
                selectedFormatID = $selectedFormat.attr('id');

            // This is temporary case - waiting ui style
            $postFormats.each(function () {
                upfDependency.metaBoxVisibility(false, $(this).attr('id'));
            });

            upfDependency.metaBoxVisibility(true, selectedFormatID);

            $postFormats.change(function () {
                upfDependency.classicEditor();
            });
        },
        gutenbergEditor: function () {
            var $holder = $('.block-editor__container');

            if ($holder.length) {
                var $postFormats = $holder.find('.editor-post-format'),
                    $selectedFormat = $postFormats.find('select option:selected');

                $postFormats.find('select option').each(function () {
                    upfDependency.metaBoxVisibility(false, 'post_format_' + $(this).val());
                });

                if ($selectedFormat.length) {
                    upfDependency.metaBoxVisibility(true, 'post_format_' + $selectedFormat.val());
                }

                $postFormats.find('select').change(function () {
                    upfDependency.gutenbergEditor();
                });
            }
        },
        metaBoxVisibility: function (visibility, itemID) {
            if (itemID !== '' && itemID !== undefined) {
                var postFormatName = itemID.replace(/-/g, '_');

                if (visibility) {
                    $('.upf_' + postFormatName).fadeIn();
                } else {
                    $('.upf_' + postFormatName).hide();
                }
            }
        }
    };

});