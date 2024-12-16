<?php

/**
 * The template for displaying Homepage 
 * Template Name: Homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Abacus_Plus

 */
$hero = get_field('hero_section');
$parallax = get_field('parallax_section');
$newsletter = get_field('newsletter');
$tisch_konfigurator_content = get_field('tisch_konfigurator_content', 'option');
$hotspot_content = get_field('tisch_konfigurator', 'option');

get_header();
?>
<section class="hero-section">
    <?php if (!empty($hero['slides'])) : ?>
        <div class="hero-slider">
            <?php foreach ($hero['slides'] as $slide) : ?>
                <div class="slide">
                    <div class="overlay"></div>

                    <?php
                    // Detect if it's a mobile device (basic example, you can use more robust solutions if needed)
                    $is_mobile = wp_is_mobile();

                    // Extract the mobile image URL if available
                    $mobile_image_url = !empty($slide['slika_za_mobitel']['url']) ? $slide['slika_za_mobitel']['url'] : null;

                    // Determine the image to use
                    $image_url = $is_mobile && $mobile_image_url ? $mobile_image_url : $slide['image'];
                    ?>

                    <?php if ($slide['background_type'] === false) { ?>
                        <img class="hero-section__image" src="<?php echo $image_url; ?>" loading="eager" alt="Background Image" />
                    <?php } elseif ($slide['background_type'] === true) { ?>
                        <video style="width:100%; height: 100%; object-fit:cover;" autoplay playsinline loop muted preload="auto">
                            <source src="<?php echo $slide['video']['url']; ?>" type="video/mp4" />
                        </video>
                    <?php } ?>
                    <div class="container">
                        <div class="hero-section__main-wrapper text-<?php echo $slide['poravnanje']; ?>">
                            <div class="content">
                                <h1 class="w-400 color-is-white hm-1">
                                    <?php echo $slide['hero_title']; ?>
                                </h1>
                                <p class="p-big w-400 color-is-white">
                                    <?php echo $slide['hero_paragraph']; ?>
                                </p>
                                <?php if (!empty($slide['button'])) : ?>
                                    <a class="primary-button small icon-right" href="<?php echo $slide['button']['url']; ?>">
                                        <?php echo $slide['button']['title']; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>


<section class="new-products">
    <div class="container">
        <div class="new-products__heading-wrapper">
            <h2 class="w-400 hm-2">Nova izdanja</h2>
            <a href="/shop/?categories=zene" class="view-all w-400 color-is-neutral-900">
                <span>Vidi sve</span>
                <div class="underline"></div>
                <div class="icon">
                    <img src="/wp-content/uploads/2024/07/Icons.svg" alt="Chevron right" />
                </div>
            </a>
        </div>
        <div class="new-products__slider">
            <div class="new-products__wrapper">
                <?php
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 12,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => 'novo',
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


<section class="konfigurator-section">
    <div class="container">
        <div class="konfigurator-section__wrapper">
            <img src="<?php echo $tisch_konfigurator_content['background_image']; ?>" alt="Tisch konfigurator" />
            <div class="hotspot-content-custom">
                <?php
                foreach ($hotspot_content as $hotspot) { ?>
                    <div style="top: <?php echo $hotspot['position_top']; ?>%; left: <?php echo $hotspot['position_left']; ?>%" class="single-hotspot">
                        <div class="number">
                            <?php echo $hotspot['number']; ?>
                        </div>
                        <div class="content">
                            <div class="title-and-close">
                                <span class="hotspot-title">
                                    <?php echo $hotspot['title']; ?>
                                </span>
                                <span class="close-icon"><img class="x-icon" src="/wp-content/uploads/2024/07/Vector-1.svg" alt="Close" /></span>
                            </div>
                            <p class="hotspot-subtitle">
                                <?php echo $hotspot['subtitle']; ?>
                            </p>
                            <div class="other-options-wrapper">
                                <?php
                                $options = explode(',', $hotspot['other_options']);
                                foreach ($options as $option) {
                                    echo '<a class="none" href="' . $hotspot['linkodproizvoda'] . '">';
                                    echo '<span class="hotspot-other-options">' . esc_html(trim($option)) . '</span>';
                                    echo '</a>';
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="konfigurator-section__wrapper-mobile">
            <img src="<?php echo $tisch_konfigurator_content['background_image']; ?>" alt="Tisch konfigurator" />
            <div class="hotspot-content-custom">
                <?php foreach ($hotspot_content as $hotspot) { ?>
                    <div class="single-hotspot" style="top: <?php echo $hotspot['adjust_mobile'] ? $hotspot['mobile_top'] : $hotspot['position_top']; ?>%; left: <?php echo $hotspot['adjust_mobile'] ? $hotspot['mobile_left'] : $hotspot['position_left']; ?>%;">
                        <div style="top: <?php echo $hotspot['adjust_mobile'] ? $hotspot['mobile_top'] : $hotspot['position_top']; ?>%; left: <?php echo $hotspot['adjust_mobile'] ? $hotspot['mobile_left'] : $hotspot['position_left']; ?>%;" class="number">
                            <?php echo $hotspot['number']; ?>
                        </div>
                        <div class="content">
                            <div class="title-and-close">
                                <span class="hotspot-title"><?php echo $hotspot['title']; ?></span>
                                <span class="close-icon"><img class="x-icon" src="/wp-content/uploads/2024/07/Vector-1.svg" alt="Close" /></span>
                            </div>
                            <p class="hotspot-subtitle"><?php echo $hotspot['subtitle']; ?></p>
                            <div class="other-options-wrapper">
                                <?php
                                $options = explode(',', $hotspot['other_options']);
                                foreach ($options as $option) {
                                    echo '<a class="none" href="' . $hotspot['linkodproizvoda'] . '">';
                                    echo '<span class="hotspot-other-options">' . esc_html(trim($option)) . '</span>';
                                    echo '</a>';
                                } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<section class="new-products">
    <div class="container">
        <div class="new-products__heading-wrapper">
            <h2 class="w-400 hm-2">Najprodavanije</h2>
            <a href="/shop/?categories=zene" class="view-all w-400 color-is-neutral-900">
                <span>Vidi sve</span>
                <div class="underline"></div>
                <div class="icon">
                    <img src="/wp-content/uploads/2024/07/Icons.svg" alt="Chevron right" />
                </div>
            </a>
        </div>
        <div class="new-products__slider">
            <div class="new-products__wrapper">
                <?php
                $args = array(
                    'post_type' => 'product',
                    'meta_key' => 'total_sales',
                    'posts_per_page' => 12,
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC'
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


<section class="reviews">
    <div class="container">
        <h2 class="w-400 hm-2">Recenzije</h2>

        <?php echo do_shortcode('[trustindex no-registration=google]'); ?>
    </div>
</section>
<section class="instagram">
    <div class="container">
        <h2 class="w-400 hm-2">Instagram</h2>
        <div class="instagram__wrapper">
            <?php echo do_shortcode('[instagram-feed feed=2]'); ?>
        </div>
    </div>
</section>

<section class="parallax" style="background-image: url('<?php echo $parallax['image']; ?>'); min-height: 800px; background-attachment: scroll; background-position-x: center; background-position-y: 40%; background-repeat: no-repeat; background-size: cover;">
    <div class="overlay"></div>
    <div class="container">
        <div class="parallax__content">
            <h2 class="color-is-white w-400 hm-2"><?php echo $parallax['title'] ?></h2>
            <p class="p-big w-400 color-is-white"><?php echo $parallax['paragraph'] ?></p>
            <a class="primary-button small icon-right" href="<?php echo $parallax['button']['url'] ?>">
                <?php echo $parallax['button']['title'] ?>
            </a>
        </div>
    </div>

</section>
<section class="newsletter">
    <div class="container">
        <div class="newsletter__center">
            <h3 class="color-is-neutral-900 w-400 hm-3"><?php echo $newsletter['title'] ?></h3>
            <p class="color-is-neutral-900 w-400 p-big"><?php echo $newsletter['paragraph'] ?></p>
            <?php echo do_shortcode('[contact-form-7 id="6372b5e" title="Newsletter"]'); ?>
        </div>
    </div>
</section>
<?php
get_footer(); ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var hotspots = document.querySelectorAll('.single-hotspot');

        hotspots.forEach(function(hotspot, index) {
            var number = hotspot.querySelector('.number');
            var content = hotspot.querySelector('.content');
            var closeIcon = hotspot.querySelector('.close-icon');

            number.addEventListener('click', function() {

                var currentlyOpen = document.querySelector('.single-hotspot.open');
                if (currentlyOpen && currentlyOpen !== hotspot) {
                    currentlyOpen.querySelector('.content').style.opacity = '0';
                    setTimeout(function() {

                        currentlyOpen.querySelector('.content').style.visibility = 'hidden';
                        currentlyOpen.classList.remove('open');
                    }, 0);
                }

                if (content.style.opacity === '0' || content.style.opacity === '') {
                    content.style.opacity = '1';
                    content.style.visibility = 'visible';
                    hotspot.classList.add('open');
                } else {
                    content.style.opacity = '0';
                    setTimeout(function() {

                        content.style.visibility = 'hidden';
                    }, 500);
                    hotspot.classList.remove('open');
                }
            });

            closeIcon.addEventListener('click', function(event) {
                event.stopPropagation();
                hotspot.classList.remove('open');
                content.style.opacity = '0';
                setTimeout(function() {

                    content.style.visibility = 'hidden';
                }, 0);
            });

            if (index === 0) {
                content.style.opacity = '1';
                content.style.visibility = 'visible';
                hotspot.classList.add('open');
            }
        });
    });
</script>