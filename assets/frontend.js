jQuery(function ($) {
    'use strict';

    $(document).ready(function () {
        bpfModifyTag.init();
        bpfResizeIFrame.init();
        bpfAddArticleClass.init();
        bpfAddBodyClass.init();
    });

    $(document).ajaxComplete(function () {
        bpfModifyTag.init();
        bpfResizeIFrame.init();
        bpfAddArticleClass.init();
    });

    $(window).resize(function () {
        bpfResizeIFrame.init();
    });

    var bpfModifyTag = {
        init: function () {
            var holder = $('.bpf-content');

            if (holder.length) {
                holder.each(function () {
                    // call replace permalink method
                    var modifiedPermalink = bpfModifyTag.replacePermalink($(this));

                    // if there is no permalink, call modify tag method
                    if (!modifiedPermalink) {
                        bpfModifyTag.modifyTag($(this), 'replace');
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
                    var newHtml = bpfModifyTag.modifyTag($(this), 'return');

                    return $('<div/>', {
                        class: 'bpf-default-permalink--replaced',
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
                if (holder.hasClass('bpf-content--format-link') || holder.hasClass('bpf-content--format-quote')) {
                    newHtml = oldHtml.replace(/var/g, 'a').replace(/data-/g, '');
                    holder.html(newHtml);

                    console.log('replace');
                }
            } else if ('return' === option) {
                if (holder.find('.bpf-content--format-link') || holder.find('.bpf-content--format-quote')) {
                    newHtml = oldHtml.replace(/var/g, 'a').replace(/data-/g, '');
                } else {
                    newHtml = oldHtml;
                }

                console.log('return');

                return newHtml;
            }
        }
    };

    var bpfResizeIFrame = {
        init: function () {
            var holder = $('.bpf-content iframe');

            // call resize method
            if (holder.length) {
                holder.each(function () {
                    bpfResizeIFrame.resize($(this));
                });
            }
        },

        resize: function (holder) {
            var ratio = holder.attr('width') / holder.attr('height');

            holder.height(holder.width() / ratio);
        },
    };

    var bpfAddArticleClass = {
        init: function () {
            var body = $('body'),
                holder = $('.format-link, .format-quote');

            if (holder.length) {
                holder.each(function () {
                    // if single and bpf content in body
                    if (body.hasClass('single')) {
                        if (body.find('.bpf-content').length) {
                            // call add class method
                            bpfAddArticleClass.addClass(body);
                        }
                    } else {
                        // if not single and bpf content in wrapper, should be article tag
                        if ($(this).find('.bpf-content').length) {
                            // call add class method
                            bpfAddArticleClass.addClass($(this));
                        }
                    }
                });
            }
        },

        addClass: function (holder) {
            holder.addClass('bpf-hide-default-title');
        },
    };

    var bpfAddBodyClass = {
        init: function () {
            $('body').addClass('bpf-clear-foreign-content');
        },
    };
});
jQuery(function ($) {
    'use strict';

    $(document).ready(function () {
        bpfGallery.init();
    });

    $(document).ajaxComplete(function (event, request, settings) {
        bpfGallery.init();
    });

    var bpfGallery = {
        init: function () {
            var holder = $('.bpf-content--format-gallery');

            if (holder.length) {
                holder.each(function () {
                    var currentHolder = $(this),
                        interval,
                        noOfItems,
                        prev = $('.bpf-content__gallery-prev'),
                        next = $('.bpf-content__gallery-next'),
                        pagination;

                    // get no of items
                    noOfItems = bpfGallery.getNoOfItems(currentHolder);

                    // generate pagination
                    bpfGallery.generatePagination(currentHolder, noOfItems);

                    // set initial active classes for first image
                    bpfGallery.setActiveClasses(currentHolder, 0);

                    // play
                    interval = bpfGallery.play(currentHolder, noOfItems);

                    // play/pause
                    $(this).on({
                        // on mouse enter call pause method
                        mouseenter: function () {
                            bpfGallery.pause(interval);
                        },
                        // on mouse leave call play method
                        mouseleave: function () {
                            interval = bpfGallery.play(currentHolder, noOfItems);
                        }
                    });

                    // goto prev
                    prev.on('click', function (event) {
                        event.preventDefault();
                        // call set new index method
                        bpfGallery.setNewIndex(currentHolder, noOfItems, 'prev');
                    });

                    // goto next
                    next.on('click', function (event) {
                        event.preventDefault();
                        // call set new index method
                        bpfGallery.setNewIndex(currentHolder, noOfItems, 'next');
                    });

                    // must go after generate pagination
                    pagination = $('.bpf-content__gallery-pagination li');

                    // goto specific
                    pagination.on('click', function (event) {
                        event.preventDefault();
                        // call set active classes method if current bullet is not active
                        if (!$(this).hasClass('active')) {
                            bpfGallery.setActiveClasses(currentHolder, $(this).index());
                        }
                    });
                });
            }
        },

        getNoOfItems: function (holder) {
            return holder.find('.bpf-content__gallery-image').length;
        },

        generatePagination: function (holder, noOfItems) {
            var paginationHolder = holder.find('.bpf-content__gallery-pagination');

            while (noOfItems--) {
                paginationHolder.append('<li class="bpf-content__gallery-page"></li>');
            }
        },

        setActiveClasses: function (holder, nextIndex) {
            // remove active class from all
            holder.find('.bpf-content__gallery-image').removeClass('active');
            holder.find('.bpf-content__gallery-pagination li').removeClass('active');
            // set active class to new
            holder.find('.bpf-content__gallery-image').eq(nextIndex).addClass('active');
            holder.find('.bpf-content__gallery-pagination li').eq(nextIndex).addClass('active');
        },

        play: function (holder, noOfItems) {
            return setInterval(function () {
                // call set new index method
                bpfGallery.setNewIndex(holder, noOfItems, 'next');
            }, 3000);
        },

        setNewIndex: function (holder, noOfItems, newIndex) {
            var currentIndex = holder.find('.bpf-content__gallery-image.active').index();

            // set new index if prev
            if ('prev' === newIndex) {
                newIndex = (0 === currentIndex) ? noOfItems - 1 : currentIndex - 1;
            }

            // set new index if next
            if ('next' === newIndex) {
                newIndex = (noOfItems === currentIndex + 1) ? 0 : currentIndex + 1;
            }

            // call set active classes method
            bpfGallery.setActiveClasses(holder, newIndex);
        },

        pause: function (interval) {
            clearInterval(interval);
        }
    };
});