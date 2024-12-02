jQuery(document).ready(function ($) {
    $('.size-numbers').on('click', function (e) {
        e.preventDefault();

        var product_id = $(this).closest('.new-products__product').data('product-id');
        var size_slug = $(this).data('size-slug'); // Correct size slug
        var color_slug = $(this).closest('.new-products__product').data('color-slug'); // Correct color slug

        console.log('Product ID:', product_id);
        console.log('Size Slug:', size_slug);
        console.log('Color Slug:', color_slug);

        // Add to cart AJAX request
        $.ajax({
            url: custom_add_to_cart_params.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'custom_add_to_cart',
                nonce: custom_add_to_cart_params.nonce,
                product_id: product_id,
                size: size_slug, // Send the correct size slug
                color: color_slug // Send the correct color slug
            }
        }).done(function (response) {
            console.log(response); // Log the response
            if (response.success) {
                // Update WooCommerce cart fragments
                $.ajax({
                    url: custom_add_to_cart_params.ajax_url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'woocommerce_get_refreshed_fragments'
                    }
                }).done(function (data) {
                    if (data && data.fragments) {
                        $.each(data.fragments, function (key, value) {
                            $(key).replaceWith(value);
                        });

                        // Trigger WooCommerce event to update cart
                        $(document.body).trigger('wc_fragments_refreshed');

                        // Check for Side Cart WooCommerce specific events
                        $(document.body).trigger('added_to_cart');
                        $(document.body).trigger('side_cart_opened');

                        // Attempt to use known Side Cart WooCommerce methods
                        if (typeof SideCart !== 'undefined' && SideCart.hasOwnProperty('open')) {
                            SideCart.open();
                        } else if (typeof sideCart !== 'undefined' && sideCart.hasOwnProperty('open')) {
                            sideCart.open();
                        } else {
                            // If no methods found, try clicking the cart icon (as a fallback)
                            $('.side-cart-icon').trigger('click');
                        }
                    }
                }).fail(function (xhr, status, error) {
                    console.error('AJAX error: ', error); // Log the error
                    console.error(xhr.responseText); // Log the server response
                });
            } else {
                alert(response.data.message);
            }
        }).fail(function (xhr, status, error) {
            console.error('AJAX error: ', error); // Log the error
            console.error(xhr.responseText); // Log the server response
        });
    });
});
