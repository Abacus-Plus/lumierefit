jQuery(document).ready(function ($) {
    function updateWishlistCount() {
        var wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
        $('.wishlist-count').text(wishlist.length);
    }

    updateWishlistCount();

    $('.wishlist-icon').on('click', function (e) {
        e.preventDefault();

        var product_id = parseInt($(this).data('product-id'));
        var $icon = $(this);
        var wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');

        if (wishlist.includes(product_id)) {
            wishlist = wishlist.filter(function (id) {
                return id !== product_id;
            });
            $icon.find('img').attr('src', '/wp-content/uploads/2024/07/heart-svgrepo-com.svg');
        } else {
            wishlist.push(product_id);
            $icon.find('img').attr('src', '/wp-content/uploads/2024/07/heart-fill-svgrepo-com.svg');
        }

        // Store in localStorage
        localStorage.setItem('wishlist', JSON.stringify(wishlist));

        // AJAX call to update the wishlist on the server side
        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
                action: 'toggle_wishlist',
                wishlist_ids: JSON.stringify(wishlist)
            },
            success: function (response) {
                if (response.success) {
                    updateWishlistCount();
                    // Optionally refresh the page if on wishlist page
                    if ($('body').hasClass('page-template-wishlist')) {
                        location.reload();
                    }
                } else {
                    console.error('Failed to update wishlist:', response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Ajax error:', error);
            }
        });
    });

    // Initialize wishlist icons on page load
    function initializeWishlistIcons() {
        var wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
        $('.wishlist-icon').each(function () {
            var product_id = parseInt($(this).data('product-id'));
            if (wishlist.includes(product_id)) {
                $(this).find('img').attr('src', '/wp-content/uploads/2024/07/heart-fill-svgrepo-com.svg');
            }
        });
    }

    initializeWishlistIcons();
});
