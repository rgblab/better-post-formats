jQuery(function ($) {
    'use strict';

    $(document).ready(function () {
        upfGallery.init();
    });

    var upfGallery = {
        init: function () {
            var holder = $('.upf-content--format-gallery');

            if (holder.length) {
                holder.each(function () {
                    var currentHolder = $(this),
                        interval,
                        noOfItems,
                        prev = $('.upf-content__gallery-prev'),
                        next = $('.upf-content__gallery-next'),
                        pagination;

                    // get no of items
                    noOfItems = upfGallery.getNoOfItems(currentHolder);

                    // generate pagination
                    upfGallery.generatePagination(currentHolder, noOfItems);

                    // set initial active classes for first image
                    upfGallery.setActiveClasses(currentHolder, 0);

                    // play
                    interval = upfGallery.play(currentHolder, noOfItems);

                    // play/pause
                    $(this).on({
                        // on mouse enter call pause handler
                        mouseenter: function () {
                            upfGallery.pause(interval);
                        },
                        // on mouse leave call play handler
                        mouseleave: function () {
                            interval = upfGallery.play(currentHolder, noOfItems);
                        }
                    });

                    // goto prev
                    prev.on('click', function (event) {
                        event.preventDefault();
                        // call set new index handler
                        upfGallery.setNewIndex(currentHolder, noOfItems, 'prev');
                    });

                    // goto next
                    next.on('click', function (event) {
                        event.preventDefault();
                        // call set new index handler
                        upfGallery.setNewIndex(currentHolder, noOfItems, 'next');
                    });

                    // must go after generate pagination
                    pagination = $('.upf-content__gallery-pagination li');

                    // goto specific
                    pagination.on('click', function (event) {
                        event.preventDefault();
                        // call set active classes handler if current bullet is not active
                        if (!$(this).hasClass('active')) {
                            upfGallery.setActiveClasses(currentHolder, $(this).index());
                        }
                    });
                });
            }
        },

        getNoOfItems: function (holder) {
            return holder.find('.upf-content__gallery-image').length;
        },

        generatePagination: function (holder, noOfItems) {
            var paginationHolder = holder.find('.upf-content__gallery-pagination');

            while (noOfItems--) {
                paginationHolder.append('<li></li>');
            }
        },

        setActiveClasses: function (holder, nextIndex) {
            // remove active class from all
            holder.find('.upf-content__gallery-image').removeClass('active');
            holder.find('.upf-content__gallery-pagination li').removeClass('active');
            // set active class to new
            holder.find('.upf-content__gallery-image').eq(nextIndex).addClass('active');
            holder.find('.upf-content__gallery-pagination li').eq(nextIndex).addClass('active');
        },

        play: function (holder, noOfItems) {
            return setInterval(function () {
                // call set new index handler
                upfGallery.setNewIndex(holder, noOfItems, 'next');
            }, 3000);
        },

        setNewIndex: function (holder, noOfItems, newIndex) {
            var currentIndex = holder.find('.upf-content__gallery-image.active').index();

            // set new index if prev
            if ('prev' === newIndex) {
                newIndex = (0 === currentIndex) ? noOfItems - 1 : currentIndex - 1;
            }

            // set new index if next
            if ('next' === newIndex) {
                newIndex = (noOfItems === currentIndex + 1) ? 0 : currentIndex + 1;
            }

            // call set active classes handler
            upfGallery.setActiveClasses(holder, newIndex);
        },

        pause: function (interval) {
            clearInterval(interval);
        }

        // TODO getNewIndex, when clicked on pagination bullets

    };


});