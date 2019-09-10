jQuery(function ($) {
    'use strict';

    $(document).ready(function () {
        upfReplaceLink.init();
        upfResizeIFrame.init();
    });

    var upfReplaceLink = {
        init: function () {
            var holder = $('.upf-content');

            // call replace handler
            if (holder.length) {
                holder.each(function () {
                    upfReplaceLink.replace($(this));
                });
            }
        },

        replace: function (holder) {
            holder.closest('a').replaceWith(function () {
                return $('<div/>', {
                    class: 'upf-link--replaced',
                    html: this.innerHTML
                });
            });
        }
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

            console.log(ratio);
        }
    }
});