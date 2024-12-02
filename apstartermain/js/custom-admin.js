jQuery(document).ready(function ($) {
    $('select[name^="attribute_"]').on('change', function () {
        var selectedOption = $(this).find('option:selected');
        var previewImage = selectedOption.data('image-url');
        var previewSlug = selectedOption.data('slug');

        // Display the image preview
        if (previewImage) {
            $('#attribute-preview').html('<img src="' + previewImage + '" alt="' + previewSlug + '" />');
        } else {
            $('#attribute-preview').html('<p>No preview available</p>');
        }
    });

    // Optional: Handle hover
    $('select[name^="attribute_"] option').hover(function () {
        var previewImage = $(this).data('image-url');
        var previewSlug = $(this).data('slug');

        if (previewImage) {
            $('#attribute-preview').html('<img src="' + previewImage + '" alt="' + previewSlug + '" />');
        } else {
            $('#attribute-preview').html('<p>No preview available</p>');
        }
    });
});
