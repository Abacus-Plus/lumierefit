<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
$naziv_boje_kod_boje = get_field('naziv_boje_-_kod_boje', 'option');
get_header();
// Get selected categories from URL and split by commas
$selected_categories = isset($_GET['categories']) ? explode(',', $_GET['categories']) : [];
// Determine the selected gender slug (muskarci or zene) and remove it from the list of categories
$selected_gender_slug = in_array('muskarci', $selected_categories) ? 'muskarci' : (in_array('zene', $selected_categories) ? 'zene' : '');
$selected_categories = array_diff($selected_categories, [$selected_gender_slug]);
?>

<section class="new-products">
    <div class="container">
        <div class="new-products__heading-wrapper">
            <div></div>
            <h2 class="w-400 hm-2">Shop</h2>
            <div class="overlay2"></div>
            <div class="show-hide-filters">
                <img src="/wp-content/uploads/2024/07/2-layers.svg" alt="Filter Icon" />
                <span class="p-small color-is-neutral-900 w-400">Sakrij filtere</span>
            </div>
        </div>
        <div class="new-products__shop-content">
            <div class="new-products__filter show-filters" id="filter-container">
                <div class="accordion" id="accordionFilters">

                    <!-- Sort Filter Accordion -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSort">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSort" aria-expanded="true" aria-controls="collapseSort">
                                Sortiranje
                            </button>
                        </h2>
                        <div id="collapseSort" class="accordion-collapse collapse show" aria-labelledby="headingSort" data-bs-parent="#accordionFilters">
                            <div class="accordion-body">
                                <div id="sort-options">
                                    <label>
                                        <input type="checkbox" name="sort_by" value="price_asc" class="sort-option" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] === 'price_asc') ? 'checked' : ''; ?> /> Najjeftinije prvo
                                    </label>
                                    <label>
                                        <input type="checkbox" name="sort_by" value="price_desc" class="sort-option" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] === 'price_desc') ? 'checked' : ''; ?> /> Najskuplje prvo
                                    </label>
                                    <label>
                                        <input type="checkbox" name="sort_by" value="title_asc" class="sort-option" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] === 'title_asc') ? 'checked' : ''; ?> /> Od A do Z
                                    </label>
                                    <label>
                                        <input type="checkbox" name="sort_by" value="title_desc" class="sort-option" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] === 'title_desc') ? 'checked' : ''; ?> /> Od Z do A
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Filter Accordion -->
                    <!-- Zila <div class="accordion-item">
                <h2 class="accordion-header" id="headingCategory">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                        Kategorije proizvoda
                    </button>
                </h2>
                <div id="collapseCategory" class="accordion-collapse collapse" aria-labelledby="headingCategory" data-bs-parent="#accordionFilters">
                    <div class="accordion-body">
                        <div id="category-options">
                            <?php
                            // Retrieve selected filters
                            $selected_categories = isset($_GET['categories']) ? explode(',', $_GET['categories']) : array();
                            $selected_colors = isset($_GET['colors']) ? explode(',', $_GET['colors']) : array();
                            $selected_sizes = isset($_GET['sizes']) ? explode(',', $_GET['sizes']) : array();

                            // Get the IDs of the categories to exclude with safety checks
                            $exclude_term_ids = array();

                            $term_novo = get_term_by('slug', 'novo', 'product_cat');
                            if ($term_novo && !is_wp_error($term_novo)) {
                                $exclude_term_ids[] = $term_novo->term_id;
                            } else {
                                // Handle the case where 'novo' term is not found
                                // Optionally log or notify
                            }

                            $term_uncategorized = get_term_by('slug', 'uncategorized', 'product_cat');
                            if ($term_uncategorized && !is_wp_error($term_uncategorized)) {
                                $exclude_term_ids[] = $term_uncategorized->term_id;
                            } else {
                                // Handle the case where 'uncategorized' term is not found
                                // Optionally log or notify
                            }

                            // Ensure $selected_gender_slug is defined
                            // Define it or retrieve it as per your application logic
                            // For example:
                            $selected_gender_slug = isset($selected_gender_slug) ? $selected_gender_slug : '';

                            if ($selected_gender_slug) {
                                $opposite_slug = ($selected_gender_slug === 'muskarci') ? 'zene' : 'muskarci';
                                $opposite_gender_term = get_term_by('slug', $opposite_slug, 'product_cat');
                                if ($opposite_gender_term && !is_wp_error($opposite_gender_term)) {
                                    $exclude_term_ids[] = $opposite_gender_term->term_id;
                                } else {
                                    // Handle the case where opposite gender term is not found
                                    // Optionally log or notify
                                }
                            }

                            // Define the display_categories function only if it doesn't already exist
                            if (!function_exists('display_categories')) {
                                function display_categories($parent_id, $level = 0, $exclude_term_ids, $selected_categories)
                                {
                                    $terms = get_terms(array(
                                        'taxonomy' => 'product_cat',
                                        'hide_empty' => false,
                                        'parent' => $parent_id,
                                        'exclude' => $exclude_term_ids,
                                    ));

                                    if (is_wp_error($terms)) {
                                        echo '<p>Error retrieving categories.</p>';
                                        return;
                                    }

                                    if (!empty($terms)) {
                                        foreach ($terms as $term) {
                                            $indent = str_repeat('&nbsp;', $level * 4);
                                            $checked = in_array($term->slug, $selected_categories) ? 'checked' : '';
                            ?>
                                            <label>
                                                <input type="checkbox" class="category-option" name="categories[]" value="<?php echo esc_attr($term->slug); ?>" <?php echo $checked; ?> />
                                                <?php echo $indent . esc_html($term->name); ?>
                                            </label>
                                            <?php
                                            // Recursive call to display subcategories
                                            display_categories($term->term_id, $level + 1, $exclude_term_ids, $selected_categories);
                                        }
                                    }
                                }
                            }

                            // Gender selection
                            if ($selected_gender_slug) {
                                $gender_parent_term = get_term_by('slug', $selected_gender_slug, 'product_cat');
                                if ($gender_parent_term && !is_wp_error($gender_parent_term)) {
                                    display_categories($gender_parent_term->term_id, 0, $exclude_term_ids, $selected_categories);
                                } else {
                                    echo '<p>No categories available for the selected gender.</p>';
                                }
                            } else {
                                echo '<p>Gender not selected.</p>';
                            }

                            // Other categories (e.g., Oprema za trening)
                            $oprema_term = get_term_by('slug', 'oprema-za-trening', 'product_cat');
                            if ($oprema_term && !is_wp_error($oprema_term)) {
                                display_categories($oprema_term->term_id, 0, $exclude_term_ids, $selected_categories);
                            } else {
                                echo '<p>No categories available for equipment.</p>';
                            }
                                            ?>
                        </div>
                    </div>
                </div>
            </div> -->

                    <?php
                    // Retrieve selected filters
                    $selected_categories = isset($_GET['categories']) ? explode(',', $_GET['categories']) : array();
                    $selected_gender_slug = isset($selected_gender_slug) ? $selected_gender_slug : ''; // Ensure $selected_gender_slug is defined

                    // Categories to exclude (e.g., 'novo' and 'uncategorized')
                    $exclude_term_ids = array();
                    $term_novo = get_term_by('slug', 'novo', 'product_cat');
                    if ($term_novo && !is_wp_error($term_novo)) {
                        $exclude_term_ids[] = $term_novo->term_id;
                    }

                    $term_uncategorized = get_term_by('slug', 'uncategorized', 'product_cat');
                    if ($term_uncategorized && !is_wp_error($term_uncategorized)) {
                        $exclude_term_ids[] = $term_uncategorized->term_id;
                    }

                    // Exclude opposite gender category if gender is selected
                    if ($selected_gender_slug) {
                        $opposite_slug = ($selected_gender_slug === 'muskarci') ? 'zene' : 'muskarci';
                        $opposite_gender_term = get_term_by('slug', $opposite_slug, 'product_cat');
                        if ($opposite_gender_term && !is_wp_error($opposite_gender_term)) {
                            $exclude_term_ids[] = $opposite_gender_term->term_id;
                        }
                    }

                    // Define function to display categories if it doesn't already exist
                    if (!function_exists('display_categories_with_gender')) {
                        function display_categories_with_gender($parent_id, $exclude_term_ids, $selected_categories)
                        {
                            $terms = get_terms(array(
                                'taxonomy'   => 'product_cat',
                                'hide_empty' => true,
                                'parent'     => $parent_id,
                                'exclude'    => $exclude_term_ids,
                            ));

                            if (is_wp_error($terms) || empty($terms)) {
                                echo '';
                                return;
                            } ?>
                            <div class="category-listing">
                                <?php foreach ($terms as $term) {
                                ?>



                                    <div class="accordion-item" style="border-bottom: 0;">
                                        <h2 class="accordion-header" id="heading-<?php echo esc_attr($term->slug); ?>">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo esc_attr($term->slug); ?>" aria-expanded="false" aria-controls="collapse-<?php echo esc_attr($term->slug); ?>">
                                                <?php echo esc_html($term->name); ?>
                                            </button>
                                        </h2>
                                        <div id="collapse-<?php echo esc_attr($term->slug); ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo esc_attr($term->slug); ?>" data-bs-parent="#accordionFilters">
                                            <div class="accordion-body">
                                                <div id="category-options" style="gap: 14px;">
                                                    <?php
                                                    $child_terms = get_terms(array(
                                                        'taxonomy'   => 'product_cat',
                                                        'hide_empty' => true,
                                                        'parent'     => $term->term_id,
                                                        'exclude'    => $exclude_term_ids,
                                                    ));

                                                    if (!empty($child_terms) && !is_wp_error($child_terms)) {
                                                        foreach ($child_terms as $child_term) {
                                                            $checked = in_array($child_term->slug, $selected_categories) ? 'checked' : '';
                                                    ?>
                                                            <label>
                                                                <input type="checkbox" class="category-option" name="categories[]" value="<?php echo esc_attr($child_term->slug); ?>" <?php echo $checked; ?> />
                                                                <?php echo esc_html($child_term->name); ?>
                                                            </label>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo '<p>No subcategories available.</p>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                } ?>
                            </div>
                    <?php }
                    }

                    // Display gender-based categories
                    if ($selected_gender_slug) {
                        $gender_parent_term = get_term_by('slug', $selected_gender_slug, 'product_cat');
                        if ($gender_parent_term && !is_wp_error($gender_parent_term)) {
                            display_categories_with_gender($gender_parent_term->term_id, $exclude_term_ids, $selected_categories);
                        } else {
                            echo '<p>No categories available for the selected gender.</p>';
                        }
                    } else {
                        echo '<p>Gender not selected.</p>';
                    }

                    // Display other categories (e.g., 'oprema-za-trening')
                    $oprema_term = get_term_by('slug', 'oprema-za-trening', 'product_cat');
                    if ($oprema_term && !is_wp_error($oprema_term)) {
                        display_categories_with_gender($oprema_term->term_id, $exclude_term_ids, $selected_categories);
                    } else {
                        echo '<p>No categories available for equipment.</p>';
                    }
                    ?>

                    <!-- Color Filter Accordion -->
                    <div class="accordion-item" style="border-top: 1px solid rgb(26 26 26 / 12%);">
                        <h2 class="accordion-header" id="headingColor">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseColor" aria-expanded="false" aria-controls="collapseColor">
                                Boja
                            </button>
                        </h2>
                        <div id="collapseColor" class="accordion-collapse collapse" aria-labelledby="headingColor" data-bs-parent="#accordionFilters">
                            <div class="accordion-body">
                                <div id="color-options" style="gap: 14px;">
                                    <?php
                                    // Retrieve the repeater field values
                                    $naziv_boje_kod_boje = [];
                                    if (have_rows('naziv_boje_-_kod_boje', 'option')) {
                                        while (have_rows('naziv_boje_-_kod_boje', 'option')) {
                                            the_row();
                                            $naziv_boje_kod_boje[] = [
                                                'naziv_boje' => get_sub_field('naziv_boje'),
                                                'kod_boje' => get_sub_field('kod_boje'),
                                                'boja_checkmarka' => get_sub_field('boja_checkmarka'),
                                            ];
                                        }
                                    }

                                    // Retrieve all color terms
                                    $boje = get_terms('pa_boja');

                                    if (!is_wp_error($boje) && !empty($boje)) {
                                        // Create an array to store grouped colors by ACF name
                                        $grouped_colors = array();

                                        // Group colors by the real name attribute
                                        foreach ($boje as $boja) {
                                            $acf_color_name = get_field('grupa_kojoj_pripada', $boja);
                                            foreach ($naziv_boje_kod_boje as $color_data) {
                                                if ($color_data['naziv_boje'] === $acf_color_name) {
                                                    $grouped_colors[$acf_color_name][] = [
                                                        'slug' => $boja->slug,
                                                        'kod_boje' => $color_data['kod_boje'],
                                                        'boja_checkmarka' => $color_data['boja_checkmarka'],
                                                    ];
                                                }
                                            }
                                        }

                                        // Display grouped color filters
                                        foreach ($grouped_colors as $acf_color_name => $color_data) {
                                            // Check if any of the color slugs are selected
                                            $is_checked = false;
                                            foreach ($color_data as $color) {
                                                if (in_array($color['slug'], $selected_colors)) {
                                                    $is_checked = true;
                                                    break;
                                                }
                                            }
                                            $checked = $is_checked ? 'checked' : '';
                                            $background_color = !empty($color_data[0]['kod_boje']) ? esc_attr($color_data[0]['kod_boje']) : '#ffffff';
                                            $checkmark_image = $color_data[0]['boja_checkmarka'] === 'Bijela'
                                                ? '/wp-content/uploads/2024/09/checkmark-svgrepo-com-1.svg'
                                                : '/wp-content/uploads/2024/09/checkmark-svgrepo-com.svg';
                                    ?>
                                            <label class="color-label" style="display: flex; gap: 24px; align-items: center;">
                                                <span style="display: <?php echo $is_checked ? 'none' : 'block'; ?>; width: 28px; height: 28px; border-radius: 4px; background-color: <?php echo $background_color; ?>;"></span>
                                                <span style="border-radius: 4px; width: 28px; height: 28px; background-color: <?php echo $background_color; ?>; background-position: center; background-repeat: no-repeat; background-image: url('<?php echo $checkmark_image; ?>'); background-size: 20px; display: <?php echo $is_checked ? 'block' : 'none'; ?>;"></span>
                                                <input type="checkbox" class="color-option" name="colors[]" value="<?php echo esc_attr(implode(',', array_column($color_data, 'slug'))); ?>" <?php echo $checked; ?> style="display: none;" />
                                                <?php echo esc_html($acf_color_name); ?>
                                            </label>
                                    <?php
                                        }
                                    } else {
                                        echo '<p>No colors found.</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Size Filter Accordion -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSize">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSize" aria-expanded="false" aria-controls="collapseSize">
                                Veličina
                            </button>
                        </h2>
                        <div id="collapseSize" class="accordion-collapse collapse" aria-labelledby="headingSize" data-bs-parent="#accordionFilters">
                            <div class="accordion-body">
                                <div id="size-options" style="gap: 14px;">
                                    <?php
                                    $velicine = get_terms('pa_velicina');

                                    if (!is_wp_error($velicine) && !empty($velicine)) {
                                        foreach ($velicine as $velicina) { ?>
                                            <label>
                                                <input type="checkbox" class="size-option" name="sizes[]" value="<?php echo esc_attr($velicina->slug); ?>" <?php echo in_array($velicina->slug, $selected_sizes) ? 'checked' : ''; ?> />
                                                <?php echo esc_html($velicina->name); ?>
                                            </label>
                                    <?php }
                                    } else {
                                        echo '<p>No sizes found.</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- End of accordionFilters -->
                <button id="apply-filters" class="secondary-button">Filtriraj</button>
            </div> <!-- End of filter-container -->
            <div class="new-products__wrapper">
                <?php
                $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'date';
                $categories = isset($_GET['categories']) ? explode(',', $_GET['categories']) : array();
                $colors = isset($_GET['colors']) ? explode(',', $_GET['colors']) : array();
                $sizes = isset($_GET['sizes']) ? explode(',', $_GET['sizes']) : array();

                // Ensure $selected_gender_slug is an array if multiple categories are passed
                $selected_gender_slug = isset($categories[0]) ? $categories[0] : '';

                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => -1,
                    'tax_query' => array('relation' => 'AND'),
                );

                // If gender is selected, add to the tax_query
                if (!empty($selected_gender_slug)) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $selected_gender_slug,
                        'operator' => 'IN',
                    );
                }

                // Add additional categories filtering
                if (count($categories) > 1) {
                    // Exclude the first gender category if it's already in $selected_gender_slug
                    $selected_categories = array_slice($categories, 1);

                    $args['tax_query'][] = array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $selected_categories,
                        'operator' => 'IN',
                        'include_children' => false,
                    );
                }

                // Handle colors filter
                if (!empty($colors)) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'pa_boja',
                        'field' => 'slug',
                        'terms' => $colors,
                        'operator' => 'IN',
                    );
                }

                // Handle sizes filter
                if (!empty($sizes)) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'pa_velicina',
                        'field' => 'slug',
                        'terms' => $sizes,
                        'operator' => 'IN',
                    );
                }

                // If no colors or sizes are selected, ensure that category filter is always applied if categories are selected
                if (empty($colors) && empty($sizes)) {
                    if (empty($args['tax_query'])) {
                        unset($args['tax_query']);
                    }
                }

                // Sorting logic
                switch ($sort_by) {
                    case 'price_asc':
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_key'] = '_price';
                        $args['order'] = 'ASC';
                        break;
                    case 'price_desc':
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_key'] = '_price';
                        $args['order'] = 'DESC';
                        break;
                    case 'title_asc':
                        $args['orderby'] = 'title';
                        $args['order'] = 'ASC';
                        break;
                    case 'title_desc':
                        $args['orderby'] = 'title';
                        $args['order'] = 'DESC';
                        break;
                }

                $loop = new WP_Query($args);

                while ($loop->have_posts()) :
                    $loop->the_post();
                    global $product;

                    if ($product->is_type('variable')) {
                        $variations = $product->get_available_variations();
                        $filtered_variations = array();

                        foreach ($variations as $variation) {
                            $variation_id = $variation['variation_id'];
                            $variation_product = new WC_Product_Variation($variation_id);
                            $attributes = $variation_product->get_attributes();

                            // Check if the variation's color is in the selected colors or if no color filter is applied
                            if (isset($attributes['pa_boja'])) {
                                $color_slug = $attributes['pa_boja'];
                                if (in_array($color_slug, $colors) || empty($colors)) {
                                    $filtered_variations[$color_slug][] = $variation_product;
                                }
                            }
                        }

                        foreach ($filtered_variations as $color_slug => $variation_products) :
                            $default_variation = $filtered_variations[$color_slug][0];
                            $color_term = get_term_by('slug', $color_slug, 'pa_boja');

                            // Get the ACF field value
                            $acf_realnameattribute = get_field('realnameattribute', $color_term);

                            // Use the ACF field value or fallback to the color term name if ACF field is empty
                            $color_name = !empty($acf_realnameattribute) ? $acf_realnameattribute : ($color_term ? $color_term->name : '');

                ?>
                            <div class="new-products__product" data-product-id="<?php echo $product->get_id(); ?>" data-color-slug="<?php echo esc_attr($color_slug); ?>">
                                <div class="wishlist">
                                    <div class="wishlist__wrapper">
                                        <?php
                                        $user_id = get_current_user_id();
                                        $wishlist = [];

                                        if ($user_id) {
                                            // Logged-in user
                                            $wishlist = get_user_meta($user_id, 'wishlist', true);
                                            $wishlist = $wishlist ? explode(',', $wishlist) : [];
                                        } else {
                                            // Guest user
                                            if (isset($_COOKIE['wishlist_ids'])) {
                                                $wishlist = json_decode(stripslashes($_COOKIE['wishlist_ids']), true);
                                                if (!is_array($wishlist)) {
                                                    $wishlist = [];
                                                }
                                            }
                                        }

                                        $is_in_wishlist = in_array($product->get_id(), $wishlist);
                                        ?>
                                        <a href="#" class="wishlist-icon" data-product-id="<?php echo $product->get_id(); ?>">
                                            <img src="/wp-content/uploads/2024/07/<?php echo $is_in_wishlist ? 'heart-fill-svgrepo-com.svg' : 'heart-svgrepo-com.svg'; ?>" alt="Wishlist" />
                                        </a>

                                        <?php if (has_term('novo', 'product_cat', $product->get_id())) {
    echo '<span class="new-label w-700 color-is-white">Novo</span>';
}

// Check if the product is on sale
if ($product->is_on_sale()) {
    // For variable products, calculate the sale percentage based on the lowest variation price
    if ($product->is_type('variable')) {
        $regular_price = $product->get_variation_regular_price('max');
        $sale_price = $product->get_variation_sale_price('min');
    } else {
        // For simple products
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
    }

    // Calculate the discount percentage
    if ($regular_price && $sale_price) {
        $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);

        // Display the sale badge with the same class as "Novo"
        echo '<span class="new-label w-700 color-is-white black">-' . $discount_percentage . '%</span>';
    }
}
?>
                                    </div>
                                </div>
                                <div class="image-and-sizes">
                                    <a href="<?php the_permalink(); ?>" class="variation-image" data-color-slug="<?php echo esc_attr($color_slug); ?>">
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

                                                    // Initialize in_stock variable to false by default for each color and size
                                                    $is_in_stock_for_color = false;

                                                    foreach ($available_variations as $variation) {
                                                        $variation_attributes = $variation['attributes'];

                                                        // Check if this variation matches the current color and size
                                                        if (isset($variation_attributes['attribute_pa_boja']) && $variation_attributes['attribute_pa_velicina']) {
                                                            $variation_color = $variation_attributes['attribute_pa_boja'];
                                                            $variation_size = $variation_attributes['attribute_pa_velicina'];

                                                            // Assuming you have the $color_slug already defined for the color
                                                            if ($variation_color === $color_slug && $variation_size === $size_slug) {
                                                                $variation_product = new WC_Product_Variation($variation['variation_id']);

                                                                // Check stock quantity
                                                                $stock_status = $variation_product->get_stock_quantity();

                                                                // Disable size if stock is 0, regardless of backorders
                                                                if ($stock_status > 0) {
                                                                    $is_in_stock_for_color = true;
                                                                }

                                                                break; // Exit loop once the match is found
                                                            }
                                                        }
                                                    }

                                                    // Apply the 'disabled' class if stock is 0 for the specific color and size combination
                                                    $disabled_class = !$is_in_stock_for_color ? 'disabled' : '';
                                                ?>
                                                    <a href="#"
                                                        class="size-numbers w-400 color-is-neutral-900 <?php echo esc_attr($disabled_class); ?>"
                                                        data-size-slug="<?php echo esc_attr($size_slug); ?>"
                                                        <?php echo !$is_in_stock_for_color ? 'aria-disabled="true"' : ''; ?>>
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
                                        <?php echo esc_html($color_name); ?>
                                    </p>
                                    <span class="price w-700 color-is-neutral-900"><?php echo $default_variation->get_price_html(); ?></span>
                                </div>
                            </div>
                <?php
                        endforeach;
                    }
                endwhile;
                wp_reset_postdata();
                ?>
            </div>



        </div>
    </div>
</section>

<?php get_footer(); ?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var filterToggle = document.querySelector('.show-hide-filters');
        var filterContainer = document.querySelector('.new-products__filter');
        var overlay = document.querySelector('.overlay2');
        var sortOptions = document.querySelectorAll('.sort-option');
        var categoryOptions = document.querySelectorAll('.category-option');
        var colorOptions = document.querySelectorAll('.color-option');
        var sizeOptions = document.querySelectorAll('.size-option');
        var applyFiltersBtn = document.getElementById('apply-filters');

        // Define currentGender based on URL parameter
        var currentUrl = new URL(window.location.href);
        var categoriesParam = currentUrl.searchParams.get('categories');
        var currentGender = categoriesParam ? categoriesParam.split(',')[0] : '';

        // Initialize filters if needed
        if (window.innerWidth <= 599) {
            filterContainer.classList.remove('show-filters');
            filterToggle.querySelector('span').textContent = 'Prikaži filtere';
        }

        filterToggle.addEventListener('click', function() {
            filterContainer.classList.toggle('show-filters');
            var isShowing = filterContainer.classList.contains('show-filters');
            filterToggle.querySelector('span').textContent = isShowing ? 'Sakrij filtere' : 'Prikaži filtere';
            if (window.innerWidth <= 599) {
                // Show or hide the overlay
                if (isShowing) {
                    overlay.style.display = 'block';
                    $('body').addClass('no-scroll');
                } else {
                    overlay.style.display = 'none';
                    $('body').removeClass('no-scroll');
                }
            }
        });

        // Prevent clicks on the overlay from closing the filters
        overlay.addEventListener('click', function(event) {
            event.stopPropagation();
        });

        function collectSelectedFilters() {
            var selectedSort = Array.from(sortOptions).find(option => option.checked)?.value || '';
            var selectedCategories = Array.from(categoryOptions).filter(option => option.checked).map(option => option.value);
            var selectedColors = Array.from(colorOptions).filter(option => option.checked).map(option => option.value.split(',')).flat();
            var selectedSizes = Array.from(sizeOptions).filter(option => option.checked).map(option => option.value);

            return {
                selectedSort,
                selectedCategories,
                selectedColors,
                selectedSizes
            };
        }

        function applyFilters() {
            var filters = collectSelectedFilters();
            var categories = [currentGender];

            // Add selected categories
            if (filters.selectedCategories.length > 0) {
                categories = categories.concat(filters.selectedCategories);
            }

            // Update the URL parameters
            currentUrl.searchParams.set('categories', categories.join(','));

            if (filters.selectedColors.length > 0) {
                currentUrl.searchParams.set('colors', filters.selectedColors.join(','));
            } else {
                currentUrl.searchParams.delete('colors');
            }

            if (filters.selectedSizes.length > 0) {
                currentUrl.searchParams.set('sizes', filters.selectedSizes.join(','));
            } else {
                currentUrl.searchParams.delete('sizes');
            }

            if (filters.selectedSort) {
                currentUrl.searchParams.set('sort_by', filters.selectedSort);
            } else {
                currentUrl.searchParams.delete('sort_by');
            }

            // Navigate to the updated URL
            window.location.href = currentUrl.toString();
        }


        applyFiltersBtn.addEventListener('click', function() {
            applyFilters();
        });
    });
			
	document.addEventListener('DOMContentLoaded', function () {
    const targetDiv = document.querySelector('.new-products__filter');
    if (!targetDiv) return;

    if (window.innerWidth <= 599) {
        // Apply the transition after the page loads
        setTimeout(function () {
            targetDiv.style.transition = 'opacity 0.5s ease'; // Smooth transition
            targetDiv.style.opacity = 1;
        }, 500); // Delay of 1 second
    }
	});
</script>

<script>
    document.querySelectorAll('.color-label').forEach(label => {
        label.addEventListener('click', function() {
            const checkbox = this.querySelector('.color-option');
            checkbox.checked = !checkbox.checked; // Toggle the checkbox state

            if (checkbox.checked) {
                this.classList.add('checked'); // Add checked class
            } else {
                this.classList.remove('checked'); // Remove checked class
            }

            // Optional: Update the display of the spans based on the checkbox state
            const firstSpan = this.querySelector('span:first-child');
            const secondSpan = this.querySelector('span:nth-child(2)');
            firstSpan.style.display = checkbox.checked ? 'none' : 'block';
            secondSpan.style.display = checkbox.checked ? 'block' : 'none';
        });
    });
</script>

<style>
    div#sort-options {
        gap: 14px;
        ;
    }

    .accordion label {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    input[type="checkbox"] {
        appearance: none;
    }

    input[type="checkbox"]::before {
        display: block;
        content: '';
        background-color: rgba(26, 26, 26, .15);
        box-shadow: inset 1px 1px 2px #0000001a;
        border-radius: 2px;
        width: 18px;
        height: 18px;
    }

    input[type="checkbox"]:checked::before {
        background-image: url('/wp-content/uploads/2024/09/checkmark-svgrepo-com.svg');
        background-size: 12px;
        background-repeat: no-repeat;
        background-position: center center;
    }

    .category-listing {
        padding: 12px 0;
    }

    .category-listing button.accordion-button.collapsed {
        padding: 8px 0;
    }
</style>