// TODO use objects, train yourself :)))

jQuery(document).ready(function ($) {

    var file_frame;

    $(document).on('click', '.upf-control__add', function (e) {


        e.preventDefault();

        if (file_frame) file_frame.close();

        file_frame = wp.media.frames.file_frame = wp.media({
            title: $(this).data('uploader-title'),
            button: {
                text: $(this).data('uploader-button-text'),
            },
            multiple: true
        });

        file_frame.on('select', function () {
            var listIndex = $('#upf-control__gallery li').index($('#upf-control__gallery li:last')),
                selection = file_frame.state().get('selection');

            selection.map(function (attachment, i) {
                attachment = attachment.toJSON(),
                    index = listIndex + (i + 1);

                $('#upf-control__gallery').append('<li><input type="hidden" name="upf-gallery[' + index + ']" value="' + attachment.id + '"><img class="upf-control__image" src="' + attachment.sizes.thumbnail.url + '"><a class="upf-control__replace" href="#" data-uploader-title="Replace image" data-uploader-button-text="Replace image"><span class="dashicons dashicons-edit"></span></a><a class="upf-control__remove" href="#"><span class="dashicons dashicons-trash"></span></a></li>');
            });
        });

        makeSortable();

        file_frame.open();

    });

    $(document).on('click', '.upf-control__replace', function (e) {

        e.preventDefault();

        var that = $(this);

        if (file_frame) file_frame.close();

        file_frame = wp.media.frames.file_frame = wp.media({
            title: $(this).data('uploader-title'),
            button: {
                text: $(this).data('uploader-button-text'),
            },
            multiple: false
        });

        file_frame.on('select', function () {
            attachment = file_frame.state().get('selection').first().toJSON();

            that.parent().find('input:hidden').attr('value', attachment.id);
            that.parent().find('img.upf-control__image').attr('src', attachment.sizes.thumbnail.url);
        });

        file_frame.open();

    });

    function resetIndex() {
        $('#upf-control__gallery li').each(function (i) {
            $(this).find('input:hidden').attr('name', 'upf-gallery[' + i + ']');
        });
    }

    function makeSortable() {
        $('#upf-control__gallery').sortable({
            opacity: 0.6,
            stop: function () {
                resetIndex();
            }
        });
    }

    $(document).on('click', '.upf-control__remove', function (e) {
        e.preventDefault();

        $(this).parents('li').animate({opacity: 0}, 200, function () {
            $(this).remove();
            resetIndex();
        });
    });

    makeSortable();

});