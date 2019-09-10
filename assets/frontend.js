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
jQuery(function ($) {
    'use strict';

    $(document).ready(function () {
        upfGallery.init();
    });

    var upfGallery = {
        init: function () {
            var holder = $('.upf-content--gallery'),
                interval,
                noOfItems;

            if (holder.length) {
                holder.each(function () {
                    // get no of items
                    noOfItems = upfGallery.getNoOfItems($(this));

                    // set initial active classes
                    upfGallery.setActive($(this), 0);

                    // call play handler
                    interval = upfGallery.play($(this), noOfItems);

                    // on mouse enter call pause handler

                    // on mouse leave call play handler

                    // goto slide on click

                });
            }
        },

        getNoOfItems: function (holder) {
            return holder.find('.upf-content__gallery-image').length;
        },

        setActive: function (holder, index) {
            // remove active from all
            holder.find('.upf-content__gallery-image').removeClass('active');
            // set active to new
            holder.find('.upf-content__gallery-image').eq(index).addClass('active');
        },

        play: function (holder, noOfItems) {
            return setInterval(function () {
                upfGallery.next(holder, noOfItems);
            }, 3000);
        },

        next: function (holder, noOfItems) {
            var currentIndex = holder.find('.upf-content__gallery-image.active').index(),
                nextIndex = (noOfItems === currentIndex + 1) ? 0 : currentIndex + 1;

            upfGallery.setActive(holder, nextIndex);
        },

        prev: function () {

        },

    };


});