<?php
// sidebar-cart.php
?>
<div id="sidebar-cart" class="sidebar-cart">
    <div class="sidebar-cart-header">
        <h2>Your Cart</h2>
        <button id="close-cart" class="close-cart">X</button>
    </div>
    <div class="sidebar-cart-content">
        <?php
        if (WC()->cart->get_cart_contents_count() > 0) {
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product = $cart_item['data'];
                $product_id = $cart_item['product_id'];
        ?>
                <div class="cart-item">
                    <img src="<?php echo get_the_post_thumbnail_url($product_id); ?>" alt="<?php echo $_product->get_name(); ?>" />
                    <div class="cart-item-details">
                        <h3><?php echo $_product->get_name(); ?></h3>
                        <span><?php echo wc_price($_product->get_price()); ?></span>
                        <span><?php echo $cart_item['quantity']; ?></span>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<p>Your cart is empty.</p>';
        }
        ?>
    </div>
</div>