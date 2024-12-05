jQuery(function ($) {
    let paged = 2;
    let loading = false;
    let canLoad = true;

    // Get current URL parameters
    const urlParams = new URLSearchParams(window.location.search);

    $(window).scroll(function () {
        // Check if we're near the bottom of the page
        if (!loading && canLoad && ($(window).scrollTop() + $(window).height() + 100 >= $(document).height())) {
            loading = true;

            // Show loading spinner
            $('.new-products__wrapper').append('<div class="loading"><div class="spinner"></div></div>');

            // Get current filter parameters
            const categories = urlParams.get('categories') || '';
            const colors = urlParams.get('colors') || '';
            const sizes = urlParams.get('sizes') || '';
            const sort_by = urlParams.get('sort_by') || '';

            // Make AJAX call
            $.ajax({
                url: infinite_scroll_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'infinite_scroll',
                    nonce: infinite_scroll_params.nonce,
                    paged: paged,
                    categories: categories,
                    colors: colors,
                    sizes: sizes,
                    sort_by: sort_by
                },
                success: function (response) {
                    if (response.success && response.data) {
                        $('.new-products__wrapper').append(response.data);
                        paged++;
                    } else {
                        canLoad = false;
                    }
                },
                error: function () {
                    canLoad = false;
                },
                complete: function () {
                    $('.loading').remove();
                    loading = false;
                }
            });
        }
    });
});
