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
jQuery(function ($) {
    'use strict';

    $(document).ready(function () {
        upfGallery.init();
    });

    $(document).ajaxComplete(function (event, request, settings) {
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
                        // on mouse enter call pause method
                        mouseenter: function () {
                            upfGallery.pause(interval);
                        },
                        // on mouse leave call play method
                        mouseleave: function () {
                            interval = upfGallery.play(currentHolder, noOfItems);
                        }
                    });

                    // goto prev
                    prev.on('click', function (event) {
                        event.preventDefault();
                        // call set new index method
                        upfGallery.setNewIndex(currentHolder, noOfItems, 'prev');
                    });

                    // goto next
                    next.on('click', function (event) {
                        event.preventDefault();
                        // call set new index method
                        upfGallery.setNewIndex(currentHolder, noOfItems, 'next');
                    });

                    // must go after generate pagination
                    pagination = $('.upf-content__gallery-pagination li');

                    // goto specific
                    pagination.on('click', function (event) {
                        event.preventDefault();
                        // call set active classes method if current bullet is not active
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
                paginationHolder.append('<li class="upf-content__gallery-page"></li>');
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
                // call set new index method
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

            // call set active classes method
            upfGallery.setActiveClasses(holder, newIndex);
        },

        pause: function (interval) {
            clearInterval(interval);
        }
    };
});