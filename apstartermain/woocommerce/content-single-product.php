<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<div class="product-section">
    <div class="container">
        <div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

            <div class="product-single-wrapper">

                <?php
                /**
                 * Hook: woocommerce_before_single_product_summary.
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action('woocommerce_before_single_product_summary');
                ?>

                <div class="summary-product">
                    <div class="summary entry-summary">
                        <div class="single-wrapper-wishlist">
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
                            <?php
                            /**
                             * Hook: woocommerce_single_product_summary.
                             *
                             * @hooked woocommerce_template_single_title - 5
                             * @hooked woocommerce_template_single_rating - 10
                             * @hooked woocommerce_template_single_price - 10
                             * @hooked woocommerce_template_single_excerpt - 20
                             * @hooked woocommerce_template_single_add_to_cart - 30
                             * @hooked woocommerce_template_single_meta - 40
                             * @hooked woocommerce_template_single_sharing - 50
                             * @hooked WC_Structured_Data::generate_product_data() - 60
                             */
                            do_action('woocommerce_single_product_summary');
                            ?>
                        </div>
                        <div id="variation-stock-quantity" class="variation-stock" style="margin-top:10px;"></div>
                        <div class="btn-disabled">
                            Nema na stanju
                        </div>
                        <hr>
                        </hr>
                        <div id="size-chart">Size Chart</div>
                        <div class="chart-overlay"></div>
                        <div class="show-size-chart">
                            <div class="show-size-chart__header">
                                <span>Size Guide</span>
                                <img id="close-chart" src="/wp-content/uploads/2024/08/x.svg" alt="close-icon" />
                            </div>
                            <?php echo do_shortcode('[wpdatatable id=1]'); ?>
                        </div>
                        <hr>
                        </hr>
                        <div class="product-infos">
                            <div class="product-infos__single">
                                <img src="/wp-content/uploads/2024/09/lock.svg" alt="Icon" />
                                <span>Sigurna kupovina</span>
                            </div>
                            <div class="product-infos__single">
                                <img src="/wp-content/uploads/2024/09/shield-check.svg" alt="Icon" />
                                <span>Provjerena kvaliteta</span>
                            </div>
                            <div class="product-infos__single">
                                <img src="/wp-content/uploads/2024/09/truck.svg" alt="Icon" />
                                <span>Dostava na adresu</span>
                            </div>
                            <!--                             <div class="product-infos__single">
                                <img src="/wp-content/uploads/2024/08/info.svg" alt="Icon" />
                                <span>Čvrsti pojas</span>
                            </div> -->
                        </div>

                        <?php
                        global $product;
                        $cross_sells = $product->get_upsell_ids();

                        if (!empty($cross_sells)) {
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => -1,
                                'post__in' => $cross_sells,
                                'orderby' => 'post__in'
                            );

                            $cross_sell_query = new WP_Query($args);

                            if ($cross_sell_query->have_posts()) { ?>
                                <hr>
                                </hr>
                                <div class="cross-sell-products">
                                    <span class="entry-cross-sell">Upotpunite izgled</span>
                                    <div class="products-cross-sell">
                                        <?php echo do_shortcode('[cuw_fbt]'); ?>
                                    </div>
                            <?php
                            }
                            wp_reset_postdata();
                        }
                            ?>
                            <hr>
                            </hr>
                            <?php $additional_product_fields = get_field('fields', 'option'); ?>
                            <?php $additional_product_fields2 = get_field('fields2'); ?>
                            <div class="woocommerce-tabs">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                Detaljnije o proizvodu
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <?php the_content(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    </hr>
                                    <?php if ($additional_product_fields2['material_&_care_content']) { ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    <?php echo $additional_product_fields2['material_&_care']; ?>
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <?php echo $additional_product_fields2['material_&_care_content']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <hr>
                                    </hr>
                                    <div class="kupovina-povrat">
                                        <a href="/kupovina-i-povrat" style="color: black;display: flex;align-items: center;justify-content: space-between;width: 100%;">
                                            <h2>Kupovina i zamjena</h2>
                                            <div class="icon povrat">
                                                <img src="/wp-content/uploads/2024/09/Property-1chevron-right-1-1.svg" alt="Chevron down" />
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                                </div>
                    </div>
                    <?php do_action('woocommerce_after_single_product'); ?>
                </div>
            </div>
        </div>


        <section class="new-products">
            <div class="container">
                <div class="new-products__heading-wrapper">
                    <?php
                    $related_products = wc_get_related_products(get_the_ID());
                    if (!empty($related_products)) { ?>
                        <h2 class="w-400 hm-2">Povezani proizvodi</h2>
                    <?php } ?>
                </div>
                <div class="new-products__slider">
                    <div class="new-products__wrapper">
                        <?php
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 4,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'post__not_in' => array($post->ID),
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'slug',
                                    'terms' => 'novo',
                                ),
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'term_id',
                                    'terms' => wp_get_post_terms($post->ID, 'product_cat', array('fields' => 'ids')), // Get categories of current product
                                    'operator' => 'IN',
                                ),
                            ),
                        );
                        $loop = new WP_Query($args);
                        while ($loop->have_posts()) :
                            $loop->the_post();
                            global $product;

                            if ($product->is_type('variable')) {
                                $variations = $product->get_available_variations();

                                foreach ($variations as $variation) {
                                    $variation_id = $variation['variation_id'];
                                    $variation_product = new WC_Product_Variation($variation_id);

                                    // Get the color slug
                                    $color_slug = isset($variation['attributes']['attribute_pa_boja']) ? $variation['attributes']['attribute_pa_boja'] : '';

                                    // Get the color term and name
                                    $color_term = get_term_by('slug', $color_slug, 'pa_boja');
                                    $color_name = $color_term ? $color_term->name : '';

                                    // Get the ACF field value associated with the color term
                                    $boja = $color_term ? get_field('realnameattribute', 'term_' . $color_term->term_id) : '';

                                    // If you have a specific logic to decide which variation to show, implement it here
                                    // For this example, let's assume we want the first available variation
                                    break;
                                }
                            }
                        ?>
                            <div class="new-products__product" data-product-id="<?php echo $product->get_id(); ?>" data-color-slug="<?php echo esc_attr($color_slug); ?>">
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
                                        <a href="#" class="wishlist-icon" data-product-id="<?php echo $product->get_id(); ?>">
                                            <img src="/wp-content/uploads/2024/07/<?php echo $is_in_wishlist ? 'heart-fill-svgrepo-com.svg' : 'heart-svgrepo-com.svg'; ?>" alt="Wishlist" />
                                        </a>


                                        <?php
                                        if (has_term('novo', 'product_cat', $product->get_id())) {
                                            echo '<span class="new-label w-700 color-is-white">Novo</span>';
                                        }

                                        if ($product->is_type('variable')) {
                                            // Get the variations of the current color
                                            $variations_for_color = $filtered_variations[$color_slug] ?? [];
                                            $displayed_discount = false; // Track if the sale label is displayed for this specific color

                                            foreach ($variations_for_color as $variation_product) {
                                                $regular_price = $variation_product->get_regular_price();
                                                $sale_price = $variation_product->get_sale_price();

                                                // Only calculate discount for variations that are on sale
                                                if ($sale_price && $regular_price && $regular_price > $sale_price) {
                                                    $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);

                                                    // Display the sale badge only once per color group
                                                    if (!$displayed_discount) {
                                                        echo '<span class="new-label w-700 color-is-white black">-' . $discount_percentage . '%</span>';
                                                        $displayed_discount = true;
                                                    }
                                                }
                                            }
                                        } else {
                                            // For simple products
                                            $regular_price = $product->get_regular_price();
                                            $sale_price = $product->get_sale_price();

                                            if ($regular_price && $sale_price) {
                                                $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                                                echo '<span class="new-label w-700 color-is-white black">-' . $discount_percentage . '%</span>';
                                            }
                                        }
                                        ?>
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
                                        <?php echo esc_html($boja ? $boja : $color_name); ?>
                                    </p>
                                    <span class="price w-700 color-is-neutral-900"><?php echo $variation_product->get_price_html(); ?></span>
                                </div>
                            </div>

                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        </section>

        <script>
            jQuery(document).ready(function($) {
                function updateVariationPrice() {
                    var $priceContainer = $('#variation-price-container');
                    var $priceElement = $('#variation-price');
                    var selectedVariation = $('.single_variation .price');

                    if (selectedVariation.length) {
                        $priceElement.html(selectedVariation.html());
                    }
                }

                $(document).on('found_variation', updateVariationPrice);
                $(document).on('wc_variation_form', function() {
                    updateVariationPrice();
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const sizeChart = document.getElementById('size-chart');
                const showSizeChart = document.querySelector('.show-size-chart');
                const closeChart = document.getElementById('close-chart');
                const overlay = document.querySelector('.chart-overlay');
                const body = document.body;

                function showChart() {
                    showSizeChart.style.display = 'block';
                    showSizeChart.classList.add('chart-active');
                    overlay.classList.add('overlay-active');
                    body.classList.add('no-scroll');
                }

                function hideChart() {
                    showSizeChart.style.display = 'none';
                    showSizeChart.classList.remove('chart-active');
                    overlay.classList.remove('overlay-active');
                    body.classList.remove('no-scroll');
                }

                sizeChart.addEventListener('click', showChart);

                closeChart.addEventListener('click', function(event) {
                    event.stopPropagation();
                    hideChart();
                });

                document.addEventListener('click', function(event) {
                    if (!showSizeChart.contains(event.target) && event.target !== sizeChart) {
                        hideChart();
                    }
                });
            });


            jQuery(document).ready(function($) {
                // Trigger on variation found
                $('form.variations_form').on('found_variation', function(event, variation) {
                    var variation_id = variation.variation_id;

                    // Hide all stock statuses and the button by default
                    $('.variation-stock').hide();
                    $('.btn-disabled').hide();

                    // Show the stock status for the selected variation
                    var $stockStatus = $('.variation-stock[data-variation-id="' + variation_id + '"]');

                    if (!$stockStatus.length) {
                        return;
                    }

                    $stockStatus.show();

                    let groupedByColor = {};

                    $('.variation-stock[data-atts-color]').each(function() {
                        let color = $(this).data('atts-color');
                        let atts = $(this).data('atts');
                        let stock = parseInt($(this).data('qty'), 10) > 0;

                        if (color && color.trim() !== "") {
                            if (!groupedByColor[color]) {
                                groupedByColor[color] = [];
                            }

                            groupedByColor[color].push({
                                atts,
                                stock
                            });
                        }
                    });

                    var atts = $stockStatus.data('atts');
                    var attColor = $stockStatus.data('atts-color');

                    $(".variable-item").removeClass("no-stock");

                    if (attColor && groupedByColor[attColor]) {
                        groupedByColor[attColor].forEach(function(item) {
                            if (item.stock) {
                                return;
                            }

                            setTimeout(function() {
                                var toSelect = null;

                                Object.keys(item.atts).map(function(key) {
                                    var element = $(".variable-items-wrapper[data-attribute_name='attribute_" + key + "'] .variable-item[data-value='" + item.atts[key] + "']");

                                    if (element.length) {
                                        element.addClass("no-stock");
                                    }

                                    toSelect = $(".variable-items-wrapper[data-attribute_name='attribute_" + key + "']");
                                });

                                setTimeout(function() {
                                    toSelect = toSelect.find(">.variable-item:not(.no-stock)");

                                    if (toSelect.length > 0) {
                                        if (!toSelect.hasClass("selected")) toSelect.eq(0).trigger('click');
                                    }

                                }, 10)



                            }, 10);
                        });
                    }

                    // Check if stock status contains "In Stock: 0" and show the btn-disabled if true
                    if (parseInt($stockStatus.data('qty'), 10) <= 0) {
                        $('.btn-disabled').show();
                    }
                });

                // Trigger on variation reset
                $('form.variations_form').on('reset_data', function() {
                    $('.variation-stock').hide(); // Hide all stock statuses when reset
                    $('.btn-disabled').hide(); // Hide the btn-disabled by default on reset
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                const targetDiv = document.querySelector('.rtwpvg-images');
                if (!targetDiv) return;

                if (window.innerWidth <= 599) {
                    // Apply the transition after the page loads
                    setTimeout(function() {
                        targetDiv.style.transition = 'opacity 0.5s ease'; // Smooth transition
                        targetDiv.style.opacity = 1;
                    }, 500); // Delay of 1 second
                }
            });
        </script>

        <style>
            .variable-item.no-stock {
                pointer-events: none;
                background-color: white !important;
            }

            #variation-stock-status {
                display: none;
            }

            .btn-disabled {
                all: unset;
                display: flex;
                gap: 10px;
                justify-content: center;
                align-items: center;
                border-radius: 2px;
                background-color: #d6d6d6;
                text-decoration: none;
                border: 0;
                line-height: 20px;
                font-style: normal;
                font-weight: 700;
                font-family: var(--secondary-font);
                transition: var(--transition);
                width: auto;
                color: black;
                text-transform: uppercase;
                padding: var(--padding-small);
                font-size: var(--font-size-sm);
                cursor: pointer;
                margin-top: -44px;
                position: relative;
            }

            .is-disabled {
                background-color: #e1e1e1 !important;
            }

            .is-disabled .variable-item-contents::before {
                content: '';
                display: block;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: url(/wp-content/uploads/2024/08/Vector-5.svg);
                background-size: cover;
                pointer-events: none;
                background-repeat: no-repeat;
            }

            .single-product .product-section .rtwpvg-product .product-single-wrapper .summary-product .entry-summary .variations_form div table tbody tr .woo-variation-items-wrapper .button-variable-items-wrapper .button-variable-item {
                width: 85px;
            }
        </style>