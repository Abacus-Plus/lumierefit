<?php
// Template for wishlist page
// Template Name: Wishlist
get_header();
?>
<section class="new-products">
    <div class="container">
        <div class="new-products__heading-wrapper">
            <h2 class="w-400 hm-2">Lista želja</h2>
        </div>
        <div class="new-products__slider">
            <div class="new-products__wrapper">
                <?php
                // Fetch the wishlist from the user's meta
                $user_id = get_current_user_id();
                if ($user_id) {
                    // Logged-in user
                    $wishlist = get_user_meta($user_id, 'wishlist', true);
                    $wishlist = $wishlist ? explode(',', $wishlist) : [];
                } else {
                    // Guest user
                    $wishlist = isset($_COOKIE['wishlist_ids']) ? json_decode(stripslashes($_COOKIE['wishlist_ids']), true) : [];
                }





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

                                $default_color_slug = isset($default_attributes['pa_boja']) ? $default_attributes['pa_boja'] : '';
                                $default_color_term = get_term_by('slug', $default_color_slug, 'pa_boja');
                                $default_color_name = $default_color_term ? $default_color_term->name : '';
                                $boja = $default_color_term ? get_field('realnameattribute', 'term_' . $default_color_term->term_id) : '';
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
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo wp_get_attachment_url($default_variation->get_image_id()); ?>" alt="Product Image" />
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
                                    ?>
                                        <div class="sizes">
                                            <span class="korpa w-400 color-is-neutral-900">Dodaj u korpu</span>
                                            <div class="sizes__wrapper">
                                                <?php foreach ($sizes as $size) {
                                                    $term = get_term_by('name', $size, 'pa_velicina');
                                                    $size_slug = $term ? $term->slug : '';
                                                ?>
                                                    <a href="#" class="size-numbers w-400 color-is-neutral-900" data-size-slug="<?php echo esc_attr($size_slug); ?>">
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