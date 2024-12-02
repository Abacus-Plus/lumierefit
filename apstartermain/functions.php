<?php



/**



 * Abacus Plus functions and definitions



 *



 * @link https://developer.wordpress.org/themes/basics/theme-functions/



 *



 * @package Abacus_Plus



 */







if (!defined('_S_VERSION')) {



	// Replace the version number of the theme on each release.



	define('_S_VERSION', '1.0.0');
}







/**



 * Sets up theme defaults and registers support for various WordPress features.



 *



 * Note that this function is hooked into the after_setup_theme hook, which



 * runs before the init hook. The init hook is too late for some features, such



 * as indicating support for post thumbnails.



 */



function abacusplus_setup()
{



	/*



			  * Make theme available for translation.



			  * Translations can be filed in the /languages/ directory.



			  * If you're building a theme based on Abacus Plus, use a find and replace



			  * to change 'abacusplus' to the name of your theme in all the template files.



			  */



	load_theme_textdomain('abacusplus', get_template_directory() . '/languages');







	// Add default posts and comments RSS feed links to head.



	add_theme_support('automatic-feed-links');







	/*



			  * Let WordPress manage the document title.



			  * By adding theme support, we declare that this theme does not use a



			  * hard-coded <title> tag in the document head, and expect WordPress to



			  * provide it for us.



			  */



	add_theme_support('title-tag');







	/*



			  * Enable support for Post Thumbnails on posts and pages.



			  *



			  * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/



			  */



	add_theme_support('post-thumbnails');







	// This theme uses wp_nav_menu() in one location.



	register_nav_menus(



		array(



			'menu-1' => esc_html__('Primary', 'abacusplus'),
			'menu-mobile' => esc_html__('Mobile menu', 'abacusplus'),




		)



	);







	/*



			  * Switch default core markup for search form, comment form, and comments



			  * to output valid HTML5.



			  */



	add_theme_support(



		'html5',



		array(



			'search-form',



			'comment-form',



			'comment-list',



			'gallery',



			'caption',



			'style',



			'script',



		)



	);







	// Set up the WordPress core custom background feature.



	add_theme_support(



		'custom-background',



		apply_filters(



			'abacusplus_custom_background_args',



			array(



				'default-color' => 'ffffff',



				'default-image' => '',



			)



		)



	);







	// Add theme support for selective refresh for widgets.



	add_theme_support('customize-selective-refresh-widgets');







	/**



	 * Add support for core custom logo.



	 *



	 * @link https://codex.wordpress.org/Theme_Logo



	 */



	add_theme_support(



		'custom-logo',



		array(



			'height' => 250,



			'width' => 250,



			'flex-width' => true,



			'flex-height' => true,



		)



	);
}



add_action('after_setup_theme', 'abacusplus_setup');







/**



 * Set the content width in pixels, based on the theme's design and stylesheet.



 *



 * Priority 0 to make it available to lower priority callbacks.



 *



 * @global int $content_width



 */



function abacusplus_content_width()
{



	$GLOBALS['content_width'] = apply_filters('abacusplus_content_width', 640);
}



add_action('after_setup_theme', 'abacusplus_content_width', 0);







/**



 * Register widget area.



 *



 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar



 */



function abacusplus_widgets_init()
{



	register_sidebar(



		array(



			'name' => esc_html__('Sidebar', 'abacusplus'),



			'id' => 'sidebar-1',



			'description' => esc_html__('Add widgets here.', 'abacusplus'),



			'before_widget' => '<section id="%1$s" class="widget %2$s">',



			'after_widget' => '</section>',



			'before_title' => '<h2 class="widget-title">',



			'after_title' => '</h2>',



		)



	);
}



add_action('widgets_init', 'abacusplus_widgets_init');







/**



 * Enqueue scripts and styles.



 */



$fonts = get_field('fonts_google_api', 'option');

$scripts = get_field('scripts', 'option');

$bootstrap = $scripts['enqueue_bootstrap'];

$slick_slider = $scripts['enqueue_slicks_slider'];



function abacusplus_scripts()
{



	global $fonts;

	global $scripts;

	global $bootstrap;

	global $slick_slider;



	wp_enqueue_style('abacusplus-google-font', $fonts, [], null);



	wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');





	wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');

	wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');

	wp_enqueue_style('abacusplus-style', get_stylesheet_uri(), array(), _S_VERSION);

	wp_style_add_data('abacusplus-style', 'rtl', 'replace');



	wp_enqueue_script('abacusplus-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	wp_enqueue_script('abacusplus-main', get_template_directory_uri() . '/js/main.js', array(), mt_rand(), true);


	wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), mt_rand(), false);





	wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), false, true);

	wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyCIxGrGOx0qwePbgKmGlX6hpD8msHyZMAE', NULL, mt_rand(), true);




	if (is_singular() && comments_open() && get_option('thread_comments')) {



		wp_enqueue_script('comment-reply');
	}
}



add_action('wp_enqueue_scripts', 'abacusplus_scripts');

if (function_exists('acf_add_options_page')) {
	acf_add_options_page([
		'page_title' => 'Hotspot',
		'position' => 3
	]);
}






/**



 * Implement the Custom Header feature.



 */



require get_template_directory() . '/inc/custom-header.php';







/**



 * Custom template tags for this theme.



 */



require get_template_directory() . '/inc/template-tags.php';







/**



 * Functions which enhance the theme by hooking into WordPress.



 */



require get_template_directory() . '/inc/template-functions.php';







/**



 * Customizer additions.



 */



require get_template_directory() . '/inc/customizer.php';







/**



 * Load Jetpack compatibility file.



 */



if (defined('JETPACK__VERSION')) {



	require get_template_directory() . '/inc/jetpack.php';
}







if (function_exists('acf_add_options_page')) {



	acf_add_options_page([



		'page_title' => 'Site Settings',



		'position' => 2



	]);
}







function enqueue_custom_styles()
{



	wp_enqueue_style('custom-styles', get_stylesheet_directory_uri() . '/sass/starter/acfstyle.scss');
	wp_enqueue_style('additional-css',  get_template_directory_uri() . '/additional.css', array(), _S_VERSION);



	/* General Tab */



	$bg_type_solid = get_field('solid', 'option');



	/* Font Tab */



	$primary_font = get_field('primary_font', 'option');



	$secondary_font = get_field('secondary_font', 'option');



	$font_sizes = get_field('font_sizes', 'option');



	$h1 = $font_sizes['h1'];



	$h2 = $font_sizes['h2'];



	$h3 = $font_sizes['h3'];



	$h4 = $font_sizes['h4'];



	$h5 = $font_sizes['h5'];



	$h6 = $font_sizes['h6'];



	$paragraph = $font_sizes['paragraph'];



	$caption = $font_sizes['caption'];



	$h1_line_height = $font_sizes['h1_line_height'];



	$h2_line_height = $font_sizes['h2_line_height'];



	$h3_line_height = $font_sizes['h3_line_height'];



	$h4_line_height = $font_sizes['h4_line_height'];



	$h5_line_height = $font_sizes['h5_line_height'];



	$h6_line_height = $font_sizes['h6_line_height'];



	$p_line_height = $font_sizes['paragraph_line_height'];



	$c_line_height = $font_sizes['caption_line_height'];







	/* Buttons Tab */



	$transition = get_field('transition', 'option');



	$primary_button = get_field('primary_button', 'option');



	$border_radius_pb = $primary_button['border_radius'];



	$border_style_pb = $primary_button['border_style'];



	$border_width_pb = $primary_button['border_width'];



	$secondary_button = get_field('secondary_button', 'option');



	$border_radius_sb = $secondary_button['border_radius'];



	$border_style_sb = $secondary_button['border_style'];



	$border_width_sb = $secondary_button['border_width'];



	$ghost_button = get_field('ghost_button', 'option');



	$border_radius_gb = $ghost_button['border_radius'];



	$border_style_gb = $ghost_button['border_style'];



	$border_width_gb = $ghost_button['border_width'];



	$small = get_field('small', 'option');



	$font_size_sm = $small['font_size'];



	$padding_small = $small['padding'];



	$medium = get_field('medium', 'option');



	$font_size_md = $medium['font_size'];



	$padding_medium = $medium['padding'];



	$large = get_field('large', 'option');



	$font_size_lg = $large['font_size'];



	$padding_large = $large['padding'];



	$button_icon = get_field('button_icon', 'option');



	$icon = $button_icon['icon'];







	/* Colors Tab */



	$primary_color = get_field('primary_color', 'option');



	$select_color_primary = $primary_color['select_color'];



	$shades_primary = $primary_color['shades'];



	$primary_100 = $shades_primary['shade_100'];



	$primary_200 = $shades_primary['shade_200'];



	$primary_300 = $shades_primary['shade_300'];



	$primary_400 = $shades_primary['shade_400'];



	$primary_600 = $shades_primary['shade_600'];



	$primary_700 = $shades_primary['shade_700'];



	$primary_800 = $shades_primary['shade_800'];



	$primary_900 = $shades_primary['shade_900'];



	$secondary_color = get_field('secondary_color', 'option');



	$select_color_secondary = $secondary_color['select_color'];



	$shades_secondary = $secondary_color['shades'];



	$secondary_100 = $shades_secondary['shade_100'];



	$secondary_200 = $shades_secondary['shade_200'];



	$secondary_300 = $shades_secondary['shade_300'];



	$secondary_400 = $shades_secondary['shade_400'];



	$secondary_600 = $shades_secondary['shade_600'];



	$secondary_700 = $shades_secondary['shade_700'];



	$secondary_800 = $shades_secondary['shade_800'];



	$secondary_900 = $shades_secondary['shade_900'];



	$grey = get_field('grey', 'option');



	$select_color_grey = $grey['select_color'];



	$shades_grey = $grey['shades'];



	$grey_100 = $shades_grey['shade_100'];



	$grey_200 = $shades_grey['shade_200'];



	$grey_300 = $shades_grey['shade_300'];



	$grey_400 = $shades_grey['shade_400'];



	$grey_600 = $shades_grey['shade_600'];



	$grey_700 = $shades_grey['shade_700'];



	$grey_800 = $shades_grey['shade_800'];



	$grey_900 = $shades_grey['shade_900'];







	/* Fields Tab */



	$input_fields_style = get_field('input_fields_style', 'option');



	$fields_border_radius = $input_fields_style['border_radius'];



	$fields_padding = $input_fields_style['padding'];



	$fields_font_size = $input_fields_style['font_size'];



	$fields_border_width = $input_fields_style['border_width'];



	$fields_border_style = $input_fields_style['border_style'];







	// Pass the values as CSS variables to the SCSS file



	wp_add_inline_style('custom-styles', "



        :root {



			--bg-type-solid: {$bg_type_solid};



            --primary-font: {$primary_font};



            --secondary-font: {$secondary_font};



            --heading-h1: {$h1};



            --heading-h2: {$h2};



            --heading-h3: {$h3};



            --heading-h4: {$h4};



            --heading-h5: {$h5};



            --heading-h6: {$h6};



            --paragraph: {$paragraph};



            --caption: {$caption};



			--heading-h1-line-height: {$h1_line_height};



			--heading-h2-line-height: {$h2_line_height};



			--heading-h3-line-height: {$h3_line_height};



			--heading-h4-line-height: {$h4_line_height};



			--heading-h5-line-height: {$h5_line_height};



			--heading-h6-line-height: {$h6_line_height};



			--paragraph-line-height: {$p_line_height};



			--caption-line-height: {$c_line_height};



            --transition: {$transition};



            --border-radius-pb: {$border_radius_pb};



            --border-style-pb: {$border_style_pb};



            --border-width-pb: {$border_width_pb};



            --border-radius-sb: {$border_radius_sb};



            --border-style-sb: {$border_style_sb};



            --border-width-sb: {$border_width_sb};



            --border-radius-gb: {$border_radius_gb};



            --border-style-gb: {$border_style_gb};



            --border-width-gb: {$border_width_gb};



            --font-size-sm: {$font_size_sm};



            --padding-small: {$padding_small};



            --font-size-md: {$font_size_md};



            --padding-medium: {$padding_medium};



            --font-size-lg: {$font_size_lg};



            --padding-large: {$padding_large};



            --btn-icon: url('{$icon}');



            --primary-color-100: {$primary_100};



			--primary-color-200: {$primary_200};



			--primary-color-300: {$primary_300};



			--primary-color-400: {$primary_400};



			--primary-color-500: {$select_color_primary};



			--primary-color-600: {$primary_600};



			--primary-color-700: {$primary_700};



			--primary-color-800: {$primary_800};



			--primary-color-900: {$primary_900};



			--secondary-color-100: {$secondary_100};



			--secondary-color-200: {$secondary_200};



			--secondary-color-300: {$secondary_300};



			--secondary-color-400: {$secondary_400};



			--secondary-color-500: {$select_color_secondary};



			--secondary-color-600: {$secondary_600};



			--secondary-color-700: {$secondary_700};



			--secondary-color-800: {$secondary_800};



			--secondary-color-900: {$secondary_900};



			--grey-color-100: {$grey_100};



			--grey-color-200: {$grey_200};



			--grey-color-300: {$grey_300};



			--grey-color-400: {$grey_400};



			--grey-color-500: {$select_color_grey};



			--grey-color-600: {$grey_600};



			--grey-color-700: {$grey_700};



			--grey-color-800: {$grey_800};



			--grey-color-900: {$grey_900};



			--fields-border-radius: {$fields_border_radius};



			--fields-font-size: {$fields_font_size};



			--fields-border-width: {$fields_border_width};



			--fields-border-style: {$fields_border_style};



			--fields-padding: {$fields_padding};



        }



    ");
}



add_action('wp_enqueue_scripts', 'enqueue_custom_styles');



function abacus_acf_init_block_types()
{

	if (function_exists('acf_register_block_type')) {

		acf_register_block_type(
			array(

				'name' => 'before-after-block',

				'title' => 'Before After Block',

				'description' => 'Before After Block',

				'render_template' => 'blocks/before-after/before-after.php',

				'category' => 'default',

				'icon' => 'info',

			)
		);



		acf_register_block_type(
			array(

				'name' => 'palette-block',

				'title' => 'Palette Block',

				'description' => 'Palette Block',

				'render_template' => 'blocks/palette/palette.php',

				'category' => 'default',

				'icon' => 'info',

			)
		);
	}
}



add_action('init', 'abacus_acf_init_block_types');



add_action('admin_enqueue_scripts', function () {

	$css_version = filemtime(get_stylesheet_directory() . '/admin.css');

	wp_enqueue_style('abacusplus-admin-style', get_stylesheet_directory_uri() . '/admin.css', null, $css_version);
});
function register_my_menus()
{
	register_nav_menus(
		array(
			'footer-menu' => __('Footer Menu'),
		)
	);
}
add_action('init', 'register_my_menus');

// Enqueue scripts
function enqueue_wishlist_scripts()
{
	wp_enqueue_script('wishlist-js', get_template_directory_uri() . '/js/wishlist.js', array('jquery'), '1.0', true);
	wp_localize_script(
		'wishlist-js',
		'wishlist_params',
		array(
			'ajax_url' => admin_url('admin-ajax.php')
		)
	);
}
add_action('wp_enqueue_scripts', 'enqueue_wishlist_scripts');

add_action('wp_ajax_toggle_wishlist', 'toggle_wishlist');
add_action('wp_ajax_nopriv_toggle_wishlist', 'toggle_wishlist');

function toggle_wishlist()
{
	// Retrieve the current user ID
	$user_id = get_current_user_id();

	if (isset($_POST['wishlist_ids'])) {
		// Decode the JSON array from the request
		$wishlist_json = stripslashes($_POST['wishlist_ids']);
		$wishlist = json_decode($wishlist_json, true);

		// Debug: Check if JSON decoding is successful
		if (json_last_error() !== JSON_ERROR_NONE) {
			wp_send_json_error('JSON Decode Error: ' . json_last_error_msg());
		}

		// Ensure that wishlist is an array
		if (!is_array($wishlist)) {
			$wishlist = [];
		}

		// Save the wishlist for logged-in users in user meta
		if ($user_id) {
			update_user_meta($user_id, 'wishlist', implode(',', $wishlist));
		} else {
			// Save the wishlist in cookies for guest users
			setcookie('wishlist_ids', json_encode($wishlist), time() + (86400 * 30), '/'); // 30 days
		}

		wp_send_json_success('Wishlist updated successfully.');
	}

	wp_send_json_error('No wishlist IDs provided.');
}



function custom_enqueue_scripts()
{
	wp_enqueue_script('custom-add-to-cart', get_template_directory_uri() . '/js/custom-add-to-cart.js', array('jquery'), null, true);
	wp_localize_script(
		'custom-add-to-cart',
		'custom_add_to_cart_params',
		array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('custom_add_to_cart_nonce'),
		)
	);
}
add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');

function custom_add_to_cart()
{
	if (!check_ajax_referer('custom_add_to_cart_nonce', 'nonce', false)) {
		wp_send_json_error(array('message' => __('Invalid nonce!', 'your-textdomain')));
		return;
	}

	$product_id = absint($_POST['product_id']);
	$size = sanitize_text_field($_POST['size']);
	$color = sanitize_text_field($_POST['color']);

	// Helper function to transliterate specific characters
	function transliterate($string)
	{
		$transliteration_table = array(
			'Đ' => 'D',
			'đ' => 'd',
			'Dž' => 'Dz',
			'dž' => 'dz',
			'Š' => 'S',
			'š' => 's',
			'Ž' => 'Z',
			'ž' => 'z',
			'Č' => 'C',
			'č' => 'c',
			'Ć' => 'C',
			'ć' => 'c'
		);
		return strtr($string, $transliteration_table);
	}

	// Transliterate size and color
	$size = transliterate($_POST['size']);
	$color = transliterate($_POST['color']);


	error_log('Received data: Product ID - ' . $product_id . ', Size - ' . $size . ', Color - ' . $color);

	$product = wc_get_product($product_id);
	$variation_id = 0;

	if ($product && $product->is_type('variable')) {
		$variations = $product->get_available_variations();
		foreach ($variations as $variation) {
			$variation_size = isset($variation['attributes']['attribute_pa_velicina']) ? $variation['attributes']['attribute_pa_velicina'] : '';
			$variation_color = isset($variation['attributes']['attribute_pa_boja']) ? $variation['attributes']['attribute_pa_boja'] : '';
			error_log('Variation attributes: ' . print_r($variation['attributes'], true));
			error_log('Checking variation attributes before transliteration: Size - ' . $variation_size . ', Color - ' . $variation_color);

			// Transliterate and compare
			$variation_size = strtolower(transliterate($variation_size));
			$variation_color = strtolower(transliterate($variation_color));

			error_log('Checking variation attributes after transliteration: Size - ' . $variation_size . ', Color - ' . $variation_color);
			error_log('User input attributes: Size - ' . $size . ', Color - ' . $color);
			if (
				$variation['attributes']['attribute_pa_velicina'] === $_POST['size'] &&
				$variation['attributes']['attribute_pa_boja'] === $_POST['color']
			) {
				$variation_id = $variation['variation_id'];
				error_log('Found matching variation: Variation ID - ' . $variation_id);
				break;
			}
		}
	} else {
		error_log('Product is not a variable product or product not found.');
	}

	if (empty($variation_id)) {
		error_log('Variation ID not found for product ID: ' . $product_id . ', Size: ' . $size . ', Color: ' . $color);
		wp_send_json_error(array('message' => __('Variation ID not found!', 'your-textdomain')));
		return;
	}

	$cart_item_key = WC()->cart->add_to_cart($product_id, 1, $variation_id);
	if ($cart_item_key) {
		wp_send_json_success(array('message' => __('Product added to cart!', 'your-textdomain')));
	} else {
		error_log('Failed to add product to cart for product ID: ' . $product_id . ', Variation ID: ' . $variation_id);
		wp_send_json_error(array('message' => __('Failed to add product to cart!', 'your-textdomain')));
	}
}
add_action('wp_ajax_custom_add_to_cart', 'custom_add_to_cart');
add_action('wp_ajax_nopriv_custom_add_to_cart', 'custom_add_to_cart');


function woocommerce_product_search()
{
	$query = sanitize_text_field($_GET['query']);

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 8,
		's' => $query,
		'meta_key' => 'total_sales',
		'orderby' => 'meta_value_num',
		'order' => 'DESC'
	);

	$products = new WP_Query($args);

	if ($products->have_posts()) { ?>
		<div class="new-products__heading-wrapper">
			<h2 class="w-400 hm-2">Rezultati pretraživanja</h2>
			<img class="close3" id="close3" src="/wp-content/uploads/2024/08/x.svg" alt="Close Icon" />
		</div>
		<div class="new-products__wrapper">
			<?php
			while ($products->have_posts()) {
				$products->the_post();
				$product = wc_get_product(get_the_ID());

				if ($product->is_type('variable')) {
					$variations = $product->get_available_variations();
					$default_variation = null;

					// Loop through each variation to find the color and attributes
					foreach ($variations as $variation) {
						$variation_id = $variation['variation_id'];
						$variation_product = new WC_Product_Variation($variation_id);

						// Get variation attributes, including the color
						$attributes = $variation['attributes'];

						// Fetch the color slug from the attributes
						$color_slug = isset($attributes['attribute_pa_boja']) ? $attributes['attribute_pa_boja'] : '';

						// Fetch the color term and name from the slug
						$color_term = get_term_by('slug', $color_slug, 'pa_boja');
						$color_name = $color_term ? $color_term->name : '';

						// Optionally fetch additional ACF field if needed (optional)
						$boja = $color_term ? get_field('realnameattribute', 'term_' . $color_term->term_id) : '';

						// Use the first matching variation
						$default_variation = $variation_product;
						break; // You can adjust this break logic if you want to loop over all variations
					}

					// If no variation is found, use the first available variation as a fallback
					if (!$default_variation && !empty($variations)) {
						$default_variation = wc_get_product($variations[0]['variation_id']);
					}
				} else {
					// For simple products, the product itself is used as the default
					$default_variation = $product;
					$color_name = ''; // No color for simple products
				}

			?>
				<div class="new-products__product" data-product-id="<?php echo esc_attr($product->get_id()); ?>" data-color-slug="<?php echo esc_attr($color_slug); ?>">
					<div class="wishlist">
						<div class="wishlist__wrapper">
							<a href="#" class="wishlist-icon" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
								<img src="/wp-content/uploads/2024/07/heart-svgrepo-com.svg" alt="Wishlist" />
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

							// Get the product's available variations
							$available_variations = $product->get_available_variations();

							// For debugging: print variations data
							// echo '<pre>' . print_r($available_variations, true) . '</pre>';
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

											// Debug: print the variation being checked
											// echo '<pre>Checking variation: ' . print_r($variation_attributes, true) . '</pre>';

											if (isset($variation_attributes['attribute_pa_velicina']) && $variation_attributes['attribute_pa_velicina'] === $size_slug) {
												$variation_product = new WC_Product_Variation($variation['variation_id']);
												if ($variation_product->is_in_stock()) {
													$is_in_stock = true;
												}
												break; // Exit loop once the match is found
											}
										}

										// Apply the 'disabled' class if out of stock
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
			<?php
			}
			?>
		</div>
	<?php
	} else {
		echo '<div class="new-products__heading-wrapper">';
		echo '<p class="nosearhresults">Nema proizvoda.</p>';
		echo '<img class="close3" id="close3" src="/wp-content/uploads/2024/08/x.svg" alt="Close Icon" />';
		echo '</div>';
	}

	wp_die();
}
add_action('wp_ajax_woocommerce_product_search', 'woocommerce_product_search');
add_action('wp_ajax_nopriv_woocommerce_product_search', 'woocommerce_product_search');


add_theme_support('woocommerce');

add_action('wp', function () {
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
});

add_action('wp', function () {
	remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
});

function custom_single_product_summary_hooks()
{

	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	add_action('woocommerce_single_product_summary', 'custom_display_variation_price', 10);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
}

add_action('wp', 'custom_single_product_summary_hooks');

function custom_display_variation_price()
{
	global $product;
	if ($product->is_type('variable')) {
	?>
		<div id="variation-price-container">
			<p class="price" id="variation-price"><?php echo wc_price($product->get_variation_price('min', true)); ?></p>
		</div>
		<?php
	}
}

function get_wishlist_count()
{
	if (isset($_COOKIE['wishlist'])) {
		$wishlist = json_decode(stripslashes($_COOKIE['wishlist']), true);
		$count = is_array($wishlist) ? count($wishlist) : 0;
	} else {
		$count = 0;
	}
	wp_send_json_success(['count' => $count]);
}
add_action('wp_ajax_get_wishlist_count', 'get_wishlist_count');
add_action('wp_ajax_nopriv_get_wishlist_count', 'get_wishlist_count');

add_action('woocommerce_before_checkout_form', 'add_custom_container_before_checkout', 10);
function add_custom_container_before_checkout()
{
	echo '<div class="container">';
}

add_action('woocommerce_after_checkout_form', 'close_custom_container_after_checkout', 10);
function close_custom_container_after_checkout()
{
	echo '</div>';
}

function my_acf_google_map_api($api)

{

	$api['key'] = 'AIzaSyCIxGrGOx0qwePbgKmGlX6hpD8msHyZMAE';

	return $api;
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');



// Method 2: Setting.

function my_acf_init()

{

	acf_update_setting('google_api_key', 'AIzaSyCIxGrGOx0qwePbgKmGlX6hpD8msHyZMAE');
}

add_action('acf/init', 'my_acf_init');


function my_custom_function_after_title()
{
	echo '</div>';
}
add_action('woocommerce_single_product_summary', 'my_custom_function_after_title', 6);


function wcbv_variation_is_active($active, $variation)
{
	if (! $variation->is_in_stock()) {
		return false;
	}
	return $active;
}
add_filter('woocommerce_variation_is_active', 'wcbv_variation_is_active', 10, 2);

function display_acf_instead_of_attribute_name($term_name, $term = null, $args = array())
{
	// Get the term ID.
	$term_id = $term ? $term->term_id : null;

	// Retrieve the ACF field value if term ID is available.
	if ($term_id) {
		$acf_value = get_field('realnameattribute', 'term_' . $term_id);

		if ($acf_value) {
			// Modify the HTML to display the ACF value.
			return esc_html($acf_value);
		}
	}

	// Return original term name if ACF field is not available.
	return $term_name;
}
add_filter('woocommerce_variation_option_name', 'display_acf_instead_of_attribute_name', 10, 3);

add_action('template_redirect', 'replace_privacy_text');
function replace_privacy_text()
{
	ob_start('wps_replace_privacy_text');
}

function wps_replace_privacy_text($buffer)
{
	$buffer = str_replace(
		'Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our',
		'Vaši lični podaci će se koristiti za podršku vašem iskustvu na ovoj web stranici, za upravljanje pristupom vašem računu i za druge svrhe opisane u našoj',
		$buffer
	);
	return $buffer;
}
add_action('wp', function () {
	if (is_product()) {
		// Get the selected color from the URL
		$selected_color = isset($_GET['selected_color']) ? sanitize_text_field($_GET['selected_color']) : '';

		// If a color is selected, enqueue a script to select it
		if ($selected_color) {
			add_action('wp_footer', function () use ($selected_color) {
		?>
				<script>
					document.addEventListener('DOMContentLoaded', function() {
						const colorSelectElement = document.querySelector('select[name="attribute_pa_boja"]');
						if (colorSelectElement) {
							colorSelectElement.value = "<?php echo esc_js($selected_color); ?>";
							colorSelectElement.dispatchEvent(new Event('change')); // Trigger change event to update variation
						}
					});
				</script>
		<?php
			});
		}
	}
});

// Add to your single product template or relevant template file
add_action('woocommerce_single_product_summary', 'display_variation_stock', 25);

function display_variation_stock()
{
	global $product;

	// Get the available variations
	$available_variations = $product->get_available_variations();

	// Display the stock info for each variation
	if (!empty($available_variations)) {
		?>
		<div id="variation-stock-status">
			<?php foreach ($available_variations as $variation) : ?>
				<?php
				$variation_obj = wc_get_product($variation['variation_id']);
				$stock_quantity = $variation_obj->get_stock_quantity();
				$is_in_stock = $variation_obj->is_in_stock();

				$atts = $variation_obj->get_attributes();
				$color = $atts['pa_boja'] ?? '';
				unset($atts['pa_boja']);
				?>
				<div class="variation-stock" data-atts-color="<?php echo esc_attr($color); ?>" data-atts="<?php echo esc_attr(json_encode($atts)); ?>" data-qty="<?php echo $stock_quantity; ?>" data-variation-id="<?php echo $variation['variation_id']; ?>" style="display:none;">
					<?php if ($is_in_stock) : ?>
						<span class="in-stock">In Stock: <?php echo $stock_quantity; ?></span>
					<?php else : ?>
						<span class="out-of-stock">Out of Stock</span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
<?php
	}
}

add_filter('woocommerce_variation_is_active', '__return_true');

add_action('woocommerce_calculated_total', 'round_discounted_price', 10, 2);

function round_discounted_price($total)
{
    $rounded = round($total * 20) / 20;
    return number_format($rounded, 2, '.', '');
}

add_filter('woocommerce_order_amount_total', 'round_order_total', 10, 2);

function round_order_total($total, $order)
{
    $rounded = round($total * 20) / 20;
    return number_format($rounded, 2, '.', '');
}

add_action('woocommerce_order_status_cancelled', 'send_cancelled_order_email_to_customer', 10, 1);

function send_cancelled_order_email_to_customer($order_id) {
    $order = wc_get_order($order_id);
    
    if (!$order) {
        return;
    }

    $customer_email = $order->get_billing_email();

    $subject = 'Vaša narudžba je otkazana';
    $message = 'Poštovani ' . $order->get_billing_first_name() . ',<br><br>';
    $message .= 'Informišemo Vas da je narudžba #' . $order->get_order_number() . ' otkazana.<br>';
    $message .= 'Ukoliko imate bilo kakvih pitanja kontaktirajte nas.<br><br>';
    $message .= 'Hvala na razumijevanju.<br><br>';
    $message .= 'S poštovanjem,<br>';
    $message .= 'Lumierefit';

    $headers = array('Content-Type: text/html; charset=UTF-8');
	$headers[] = 'From: Lumiere shop <info@lumierefit.ba>';

    wp_mail($customer_email, $subject, $message, $headers);
}

add_filter('woocommerce_registration_redirect', function ($redirect_to) {
    $user = wp_get_current_user();
    if (in_array('customer', (array) $user->roles)) {
        $user->set_role('newcustomers');
    }
    return $redirect_to;
});

add_action('woocommerce_thankyou', 'change_user_role_after_first_order', 10, 1);

function change_user_role_after_first_order($order_id) {
    $order = wc_get_order($order_id);

    $user_id = $order->get_user_id();

    if ($user_id) {
        $user = new WP_User($user_id);

        if (in_array('newcustomers', (array) $user->roles)) {
            $user->set_role('customer');
        }
    }
}

add_action('user_register', 'schedule_role_change_after_registration', 10, 1);

function schedule_role_change_after_registration($user_id) {
    $time = time() + (30 * DAY_IN_SECONDS);
    wp_schedule_single_event($time, 'change_role_after_registration', array($user_id));
}

add_action('change_role_after_registration', 'change_role_after_registration', 10, 1);

function change_role_after_registration($user_id) {
    $user = new WP_User($user_id);

    if (in_array('newcustomers', (array) $user->roles)) {
        $user->set_role('customer');
    }
}

add_filter('woocommerce_product_single_add_to_cart_text', 'custom_add_to_cart_text_single');

function custom_add_to_cart_text_single($text) {
    return __('Dodaj u korpu', 'abacusplus');
}

