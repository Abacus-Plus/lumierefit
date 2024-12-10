<?php
// Template for wishlist page
// Template Name: Wishlist
get_header();

$user_id = get_current_user_id();
$wishlist = [];

if ($user_id) {
    // Get wishlist from user meta
    $wishlist_string = get_user_meta($user_id, 'wishlist', true);
    if (!empty($wishlist_string)) {
        $wishlist = array_filter(array_map('intval', explode(',', $wishlist_string)));
    }
} else {
    // Get wishlist from cookie
    if (isset($_COOKIE['wishlist_ids'])) {
        $wishlist = json_decode(stripslashes($_COOKIE['wishlist_ids']), true);
        $wishlist = is_array($wishlist) ? array_filter(array_map('intval', $wishlist)) : [];
    }
}

// Debug information (remove in production)
error_log('User ID: ' . $user_id);
error_log('Wishlist: ' . print_r($wishlist, true));
?>
<section class="new-products">
    <div class="container">
        <div class="new-products__heading-wrapper">
            <h2 class="w-400 hm-2">Lista želja</h2>
        </div>
        <div class="new-products__slider">
            <div class="new-products__wrapper">
                <?php
                if ($wishlist) {
                    $wishlist = array_map('intval', $wishlist); // Ensure product IDs are integers
                    $args = array(
                        'post_type' => 'product',
                        'post__in' => $wishlist,
                        'posts_per_page' => -1
                    );

                    $query = new WP_Query($args);

                    if (empty($wishlist) || !$query->have_posts()) {
                        echo '<p class="big">Nemate proizvoda na listi želja.</p>';
                    }


                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            global $product;

                            if ($product->is_type('variable')) {
                                $default_attributes = $product->get_default_attributes();
                                $variations = $product->get_available_variations();

                                foreach ($variations as $variation) {
                                    $variation_id = $variation['variation_id'];
                                    $variation_product = new WC_Product_Variation($variation_id);
                                    $attributes = $variation_product->get_attributes();
                                    $match = true;

                                    foreach ($default_attributes as $key => $value) {
                                        if (!isset($attributes[$key]) || $attributes[$key] != $value) {
                                            $match = false;
                                            break;
                                        }
                                    }

                                    if ($match) {
                                        $default_variation = $variation_product;
                                        break;
                                    }
                                }

                                if (!isset($default_variation)) {
                                    $default_variation = new WC_Product_Variation($variations[0]['variation_id']);
                                }

                                $color_slug = isset($variation['attributes']['attribute_pa_boja']) ? $variation['attributes']['attribute_pa_boja'] : '';

                                // Get the color term and name
                                $color_term = get_term_by('slug', $color_slug, 'pa_boja');
                                $color_name = $color_term ? $color_term->name : '';

                                // Get the ACF field value associated with the color term
                                $boja = $color_term ? get_field('realnameattribute', 'term_' . $color_term->term_id) : '';
                            }
                            $is_in_wishlist = in_array($product->get_id(), $wishlist);
                ?>
                            <div class="new-products__product wishlist-item" data-product-id="<?php echo $product->get_id(); ?>" data-color-slug="<?php echo esc_attr($default_color_slug); ?>">
                                <div class="wishlist">
                                    <div class="wishlist__wrapper">
                                        <a href="#" class="wishlist-icon" data-product-id="<?php echo $product->get_id(); ?>">
                                            <img src="/wp-content/uploads/2024/07/<?php echo $is_in_wishlist ? 'heart-fill-svgrepo-com.svg' : 'heart-svgrepo-com.svg'; ?>" alt="Wishlist" />
                                        </a>
                                        <?php if (has_term('novo', 'product_cat', $product->get_id())) : ?>
                                            <span class="new-label w-700 color-is-white">Novo</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="image-and-sizes">
                                    <a href="<?php the_permalink(); ?>" class="variation-image" data-color-slug="<?php echo esc_attr($color_slug); ?>">
                                        <img src="<?php echo wp_get_attachment_url($variation_product->get_image_id()); ?>" alt="Product Image" />
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

                                        // Get the product's available variations
                                        $available_variations = $product->get_available_variations();

                                    ?>
                                        <div class="sizes">
                                            <span class="korpa w-400 color-is-neutral-900">Dodaj u korpu</span>
                                            <div class="sizes__wrapper">
                                                <?php
                                                foreach ($sizes as $size) {
                                                    $term = get_term_by('name', $size, 'pa_velicina');
                                                    $size_slug = $term ? $term->slug : ''; // Get the slug from the term

                                                    // Initialize in_stock variable to false by default
                                                    $is_in_stock = false;

                                                    foreach ($available_variations as $variation) {
                                                        $variation_attributes = $variation['attributes'];

                                                        if (isset($variation_attributes['attribute_pa_velicina']) && $variation_attributes['attribute_pa_velicina'] === $size_slug) {
                                                            $variation_product = new WC_Product_Variation($variation['variation_id']);

                                                            // Check stock status
                                                            $stock_status = $variation_product->get_stock_quantity();

                                                            // Disable size if stock is 0, regardless of backorders
                                                            if ($stock_status > 0) {
                                                                $is_in_stock = true;
                                                            }

                                                            break; // Exit loop once the match is found
                                                        }
                                                    }

                                                    // Apply the 'disabled' class if stock is 0
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
                                        <?php echo $boja ? esc_html($boja) : esc_html($default_color_name); ?>
                                    </p>
                                    <span class="price w-700 color-is-neutral-900"><?php echo $default_variation->get_price_html(); ?></span>
                                </div>
                            </div>
                <?php
                        }
                    } else {
                        echo '<p class="big">Nemate proizvoda na listi želja.</p>';
                    }
                } else {
                    echo '<p class="big">Nemate proizvoda na listi želja.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php
get_footer();
?>