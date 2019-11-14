jQuery(function ($) {
    'use strict';

    $(document).ready(function () {
        upfModifyTag.init();
        upfResizeIFrame.init();
        upfAddArticleClass.init();
        upfAddBodyClass.init();
    });

    $(document).ajaxComplete(function () {
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
                    // call replace permalink method
                    var modifiedPermalink = upfModifyTag.replacePermalink($(this));

                    // if there is no permalink, call modify tag method
                    if (!modifiedPermalink) {
                        upfModifyTag.modifyTag($(this), 'replace');
                    }
                });
            }
        },

        replacePermalink: function (holder) {
            var defaultPermalink = holder.closest('a');

            if (defaultPermalink.length) {
                // replace a with div
                defaultPermalink.replaceWith(function () {
                    // call modify tag method
                    var newHtml = upfModifyTag.modifyTag($(this), 'return');

                    return $('<div/>', {
                        class: 'upf-default-permalink--replaced',
                        html: newHtml,
                    });
                });

                return true;
            } else {
                return false;
            }
        },

        modifyTag: function (holder, option) {
            var oldHtml = holder.html(),
                newHtml = '';

            if ('replace' === option) {
                if (holder.hasClass('upf-content--format-link') || holder.hasClass('upf-content--format-quote')) {
                    newHtml = oldHtml.replace(/var/g, 'a').replace(/data-/g, '');
                    holder.html(newHtml);

                    console.log('replace');
                }
            } else if ('return' === option) {
                if (holder.find('.upf-content--format-link') || holder.find('.upf-content--format-quote')) {
                    newHtml = oldHtml.replace(/var/g, 'a').replace(/data-/g, '');
                } else {
                    newHtml = oldHtml;
                }

                console.log('return');

                return newHtml;
            }
        }
    };

    var upfResizeIFrame = {
        init: function () {
            var holder = $('.upf-content iframe');

            // call resize method
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

    var upfAddBodyClass = {
        init: function () {
            $('body').addClass('upf-clear-foreign-content');
        },
    };
});