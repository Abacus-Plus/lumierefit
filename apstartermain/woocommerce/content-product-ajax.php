<div class="new-products__product" data-product-id="<?php echo esc_attr($product->get_id()); ?>" data-color-slug="<?php echo esc_attr($color_slug); ?>">
    <div class="wishlist">
        <div class="wishlist__wrapper">
            <?php
            $user_id = get_current_user_id();
            $wishlist = [];

            if ($user_id) {
                $wishlist = get_user_meta($user_id, 'wishlist', true);
                $wishlist = $wishlist ? explode(',', $wishlist) : [];
            } else {
                if (isset($_COOKIE['wishlist_ids'])) {
                    $wishlist = json_decode(stripslashes($_COOKIE['wishlist_ids']), true);
                    if (!is_array($wishlist)) {
                        $wishlist = [];
                    }
                }
            }

            $is_in_wishlist = in_array($product->get_id(), $wishlist);
            ?>
            <a href="#" class="wishlist-icon" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                <img src="/wp-content/uploads/2024/07/<?php echo $is_in_wishlist ? 'heart-fill-svgrepo-com.svg' : 'heart-svgrepo-com.svg'; ?>" alt="Wishlist" />
            </a>

            <?php if (has_term('novo', 'product_cat', $product->get_id())) {
                echo '<span class="new-label w-700 color-is-white">Novo</span>';
            } ?>
        </div>
    </div>
    <div class="image-and-sizes">
        <a href="<?php the_permalink(); ?>" class="variation-image" data-color-slug="<?php echo esc_attr($color_slug); ?>">
            <img src="<?php echo esc_url(wp_get_attachment_url($default_variation->get_image_id())); ?>" alt="Product Image" />
        </a>
        <?php
        $sizes = wc_get_product_terms($product->get_id(), 'pa_velicina', array('fields' => 'names'));
        if ($sizes) {
            $size_order = array('XS', 'S', 'M', 'L', 'XL', 'XXL');
            usort($sizes, function ($a, $b) use ($size_order) {
                $pos_a = array_search($a, $size_order);
                $pos_b = array_search($b, $size_order);
                return $pos_a - $pos_b;
            });

            $available_variations = $product->get_available_variations();
        ?>
            <div class="sizes">
                <span class="korpa w-400 color-is-neutral-900">Dodaj u korpu</span>
                <div class="sizes__wrapper">
                    <?php
                    foreach ($sizes as $size) {
                        $term = get_term_by('name', $size, 'pa_velicina');
                        $size_slug = $term ? $term->slug : '';

                        $is_in_stock = false;
                        foreach ($available_variations as $variation) {
                            $variation_attributes = $variation['attributes'];
                            if (isset($variation_attributes['attribute_pa_velicina']) && $variation_attributes['attribute_pa_velicina'] === $size_slug) {
                                $variation_product = new WC_Product_Variation($variation['variation_id']);
                                if ($variation_product->is_in_stock()) {
                                    $is_in_stock = true;
                                }
                                break;
                            }
                        }

                        $disabled_class = !$is_in_stock ? 'disabled' : '';
                    ?>
                        <a href="#"
                            class="size-numbers w-400 color-is-neutral-900 <?php echo esc_attr($disabled_class); ?>"
                            data-size-slug="<?php echo esc_attr($size_slug); ?>"
                            <?php echo !$is_in_stock ? 'aria-disabled="true"' : ''; ?>>
                            <?php echo esc_html($size); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="new-products__content">
        <a href="<?php the_permalink(); ?>">
            <h6 class="w-700 color-is-neutral-900 hm-6"><?php the_title(); ?></h6>
        </a>
        <p class="color w-400 color-is-neutral-300">
            <?php echo esc_html($boja ? $boja : $color_name); ?>
        </p>
        <span class="price w-700 color-is-neutral-900"><?php echo $default_variation->get_price_html(); ?></span>
    </div>
</div>