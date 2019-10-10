jQuery(function ($) {
    'use strict';

    $(document).ready(function () {
        upfModifyTag.init();
        upfResizeIFrame.init();
        upfAddArticleClass.init();
        upfAddBodyId.init();
    });

    $(document).ajaxComplete(function (event, request, settings) {
        upfModifyTag.init();
        upfResizeIFrame.init();
        upfAddArticleClass.init();
    });

    $(window).resize(function () {
        upfResizeIFrame.init();
    });

    var upfModifyTag = {
        init: function () {
            var holder = $('.upf-content');

            if (holder.length) {
                holder.each(function () {
                    // call modify tag handler
                    upfModifyTag.modifyTag($(this));
                });
            }
        },

        modifyTag: function (holder) {
            var default_permalink = holder.closest('a');

            default_permalink.replaceWith(function () {
                var html = this.innerHTML.replace(/var/g, 'a').replace(/data-/g, '');

                return $('<div/>', {
                    class: 'upf-default-permalink--replaced',
                    html: html,
                });
            });
        },
    };

    var upfResizeIFrame = {
        init: function () {
            var holder = $('.upf-content iframe');

            // call resize handler
            if (holder.length) {
                holder.each(function () {
                    upfResizeIFrame.resize($(this));
                });
            }
        },

        resize: function (holder) {
            var ratio = holder.attr('width') / holder.attr('height');

            holder.height(holder.width() / ratio);

            console.log('resized');
        },
    };

    var upfAddArticleClass = {
        init: function () {
            var body = $('body'),
                holder = $('.format-link, .format-quote');

            if (holder.length) {
                holder.each(function () {
                    // if single and upf content in body
                    if (body.hasClass('single')) {
                        if (body.find('.upf-content').length) {
                            // call add class method
                            upfAddArticleClass.addClass(body);
                        }
                    } else {
                        // if not single and upf content in wrapper, should be article tag
                        if ($(this).find('.upf-content').length) {
                            // call add class method
                            upfAddArticleClass.addClass($(this));
                        }
                    }
                });
            }
        },

        addClass: function (holder) {
            holder.addClass('upf-hide-default-title');
        },
    };

    var upfAddBodyId = {
        init: function () {
            $('body').attr('id', 'upf-content');
        },
    };
});