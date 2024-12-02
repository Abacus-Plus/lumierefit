jQuery(document).ready(function ($) {
    function updateWishlistCount() {
        var wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
        $('.wishlist-count').text(wishlist.length);
    }

    updateWishlistCount();

    $('.wishlist-icon').on('click', function (e) {
        e.preventDefault();

        var product_id = parseInt($(this).data('product-id')); // Ensure product_id is an integer
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

        // Set the cookie with encoded JSON string
        document.cookie = "wishlist_ids=" + encodeURIComponent(JSON.stringify(wishlist)) + ";path=/";

        updateWishlistCount();

        // AJAX call to update the wishlist on the server side
        $.ajax({
            url: ajaxurl, // Make sure ajaxurl is defined in your script
            method: 'POST',
            data: {
                action: 'toggle_wishlist',
                wishlist_ids: JSON.stringify(wishlist)
            },
            success: function (response) {
                console.log(response.data); // Success message from the server
            }
        });
    });
});
