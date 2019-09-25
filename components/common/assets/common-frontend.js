jQuery(function ($) {
    'use strict';

    $(document).ready(function () {
        upfReplaceArticlePermalink.init();
        upfResizeIFrame.init();
        upfClick.init();
        upfAddArticleClass.init();
    });

    var upfReplaceArticlePermalink = {
        init: function () {
            var holder = $('.upf-content');

            if (holder.length) {
                holder.each(function () {
                    // call replace permalink handler
                    upfReplaceArticlePermalink.replacePermalink($(this));
                });
            }
        },

        replacePermalink: function (holder) {
            holder.closest('a').replaceWith(function () {
                return $('<div/>', {
                    class: 'upf-default-permalink--replaced',
                    html: this.innerHTML
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
        },
    };

    var upfClick = {
        init: function () {
            var holder = $('.upf-content__link, .upf-content__permalink');

            if (holder.length) {
                holder.each(function () {
                    $(this).on('click', function (event) {
                        event.preventDefault();
                        // call open link handler
                        upfClick.openLink($(this));
                    });
                });
            }
        },

        openLink: function (holder) {
            var href = holder.data('href'),
                target = ('undefined' !== typeof holder.data('target')) ? holder.data('target') : 'same';

            if ('new' === target) {
                window.open(href);
            } else if ('same' === target) {
                window.location = href;
            }
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
    }
});