<?php



/**

 * The header for our theme

 *

 * This is the template that displays all of the <head> section and everything up until <div id="content">

 *

 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials

 *

 * @package Abacus_Plus

 */



$header = get_field('header', 'option');

?>

<!doctype html>

<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Osvijetlite svoj trening sa Lumiereom. Naša kolekcija inovativne sportske odjeće kreirana je da podigne vaše performanse i samopouzdanje, trening po trening.">
	<meta name="google-site-verification" content="dXuWZpKO6M0Bu3HvjSf9w9yk_U9ljvSNH5isTFz61JE" />
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<script type="text/javascript">
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	</script>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div class="entry-popup">
		<div class="entry-popup__overlay"></div>
		<div class="entry-popup__content">
			<img class="entry-popup__close" src="/wp-content/uploads/2024/08/x.svg" alt="Close Icons" />
			<div class="entry-popup__content-content">
				<img class="entry-popup__content-image" src="/wp-content/uploads/2024/09/IMG_4004_jpg-scaled.jpeg" alt="Image" />
				<span>Ostvarite 10% popusta!</span>
				<p>Lumierefit je pripremio izvanrednu ponudu za sve nove registrovane korisnike! Uživajte u 10% popusta na sve proizvode. Sve što trebate učiniti je kliknuti na opciju "Registruj se!", završiti proces registracije i započeti s kupovinom. Popust od 10% biće automatski primenjen u vašoj košarici.</p>
				<p style="font-style:italic; font-weight:bold;">*Napomena: Kupon je moguće iskoristiti samo jednom u roku od 30 dana. Nakon toga, ovaj popust više neće biti dostupan!</p>
				<a class="secondary-button small" href="/my-account/">Registruj se!</a>
			</div>
		</div>
	</div>

	<style>
		.entry-popup {
			display: none;
			position: fixed;
			z-index: 999;
			width: 100%;
			height: 100vh;
			align-items: center;
			justify-content: center;
		}

		.entry-popup__overlay {
			position: absolute;
			z-index: -1;
			background-color: rgba(0, 0, 0, 0.75);
			width: 100%;
			height: 100%;
		}

		.entry-popup__content {
			max-width: 500px;
			margin: 0 auto;
			background: white;
			border-radius: 6px;
			padding: 24px;
			position: relative;
		}

		.entry-popup__close {
			position: absolute;
			right: 32px;
			top: 32px;
			cursor: pointer;
			filter: invert(100%) sepia(100%) saturate(1%) hue-rotate(151deg) brightness(109%) contrast(98%);
		}

		.entry-popup__content-content {
			display: flex;
			flex-direction: column;
			align-items: center;
			gap: 24px;
		}

		.entry-popup__content-content span {
			color: #161414;
			font-weight: 400;
			text-transform: uppercase;
			line-height: 47.76px;
			letter-spacing: 1px;
			font-size: 2.5rem;
			font-family: 'Fjalla One';
			text-align: center;
		}

		.entry-popup__content-content p {
			text-align: center;
			color: #161414;
			line-height: 1.2em;
		}

		.entry-popup__content-image {
			height: 300px;
			width: 100%;
			object-fit: cover;
		}

		@media only screen and (max-width: 599px) {
			.entry-popup__content {
				max-width: 300px;
				padding: 16px;
			}

			.entry-popup__content-image {
				height: 200px;
			}

			.entry-popup__content-content {
				gap: 12px;
			}

			.entry-popup__content-content span {
				font-size: 1.5rem;
			}

			.entry-popup__content-content p {
				font-size: .875rem;
			}

			.entry-popup__close {
				top: 16px;
				right: 16px;
			}
		}
	</style>
	<header class="site-header">
		<div class="site-header__topbar">
			<div class="container">
				<div class="topbar-info">
					<?php foreach ($header['topbar_informations'] as $icon) { ?>
						<a href="<?php echo $icon['link']; ?>">
							<div class="topbar-info__inner">
								<img class="icon" src="<?php echo $icon['icon']['url']; ?>" alt="<?php echo $icon['icon']['alt']; ?>" />
								<p class="p-small color-is-neutral-900 w-400"><?php echo $icon['information']; ?></p>
							</div>
						</a>
					<?php } ?>
				</div>
			</div>
		</div>

		<div class="site-header__main">
			<div class="container">
				<div class="main-wrapper">
					<nav class="main-wrapper__main-menu desktop">
						<?php
						$args = array(
							'container' => false,
							'theme_location' => 'menu-1',
							'items_wrap' => '<ul id="%1$s" class="menu-items">%3$s</ul>',
							'add_li_class' => 'nav-item'
						);
						wp_nav_menu($args);
						?>
					</nav>
					<a class="main-wrapper__logo-link" href="/">
						<img class="main-wrapper__logo" src="<?php echo $header['logo']['url']; ?>" alt="<?php echo $header['logo']['alt']; ?>" />
					</a>
					<div class="main-wrapper__icons-wrapper">

						<img class="mobile-wrapper__search" src="/wp-content/uploads/2024/07/Component-1.svg" alt="Search Icon" />
						<form action="/" method="get" id="headersearch">
							<input type="text" id="search" name="s" placeholder="Pretražite..." />
							<img src="/wp-content/uploads/2024/07/Component-1.svg" alt="Search Icon" />
						</form>
						<div id="search-results">
						</div>
						<?php
						$counter = 1; // Initialize a counter
						foreach ($header['nav_icons'] as $nav_icons) {
							// Check if this is the second item in the array
							if ($counter == 2) {
						?>
								<a class="navigation-icon" href="<?php echo $nav_icons['url']; ?>">
									<img src="<?php echo $nav_icons['icon']['url']; ?>" alt="<?php echo $nav_icons['icon']['alt']; ?>" />
									<span class="wishlist-count">0</span> <!-- Add the span here -->
								</a>
							<?php
							} else {
							?>
								<a class="navigation-icon" href="<?php echo $nav_icons['url']; ?>">
									<img src="<?php echo $nav_icons['icon']['url']; ?>" alt="<?php echo $nav_icons['icon']['alt']; ?>" />
								</a>
						<?php
							}
							$counter++; // Increment the counter
						}
						?>
						<?php echo do_shortcode('[fk_cart_menu]'); ?>
					</div>
				</div>
				<nav class="main-wrapper__main-menu mobile">
					<div class="category-tabs">
						<ul class="tab-list">
							<li class="tab-item active" data-tab="zene-tab">Žene</li>
							<li class="tab-item" data-tab="muskarci-tab">Muškarci</li>
							<img class="close" id="close" src="/wp-content/uploads/2024/08/x.svg" alt="Close Icon" />
						</ul>
						<div class="tab-content">
							<!-- Žene Tab Content -->
							<div class="tab-pane active" id="zene-tab">
								<ul class="menu-items">
									<?php
									$zene_categories = get_categories(array(
										'taxonomy' => 'product_cat',
										'parent' => get_term_by('slug', 'zene', 'product_cat')->term_id,
										'hide_empty' => false,
									));


									function display_child_categories($categories, $parent_slug = '', $is_top_level = false)
									{
										echo '<ul>';
										foreach ($categories as $category) {
											// Determine if it's a top-level category or not
											if ($is_top_level) {
												// For top-level categories, append the parent slug and current category slug
												$link = '/shop/?categories=' . $parent_slug . ',' . $category->slug;
											} else {
												// For child categories, only append the parent and the child category slug, skipping intermediates
												$link = '/shop/?categories=' . $parent_slug . ',' . $category->slug;
											}

											// Get child categories to check if the current category is a parent
											$child_categories = get_categories(array(
												'taxonomy' => 'product_cat',
												'parent' => $category->term_id,
												'hide_empty' => false,
											));

											// Add 'parent' class if it's a top-level category and has children
											$a_class = ($is_top_level && !empty($child_categories)) ? 'parent' : '';

											echo '<li class="nav-item"><a href="' . esc_url($link) . '" class="' . esc_attr($a_class) . '">' . esc_html($category->name) . '</a>';

											// For child categories, pass the original parent slug but only append the child slug
											if (!empty($child_categories)) {
												display_child_categories($child_categories, $parent_slug);  // Don't pass intermediary category slug
											}

											echo '</li>';
										}
										echo '</ul>';
									}





									// Start with top-level categories
									display_child_categories($zene_categories, 'zene', true);
									?>
								</ul>
							</div>


							<!-- Muškarci Tab Content -->
							<div class="tab-pane" id="muskarci-tab">
								<ul class="menu-items parent">
									<?php
									$muskarci_categories = get_categories(array(
										'taxonomy' => 'product_cat',
										'parent' => get_term_by('slug', 'muskarci', 'product_cat')->term_id,
										'hide_empty' => false,
									));

									display_child_categories($muskarci_categories, 'muskarci', true);
									?>
								</ul>
							</div>
						</div>

						<div class="mobilemenu-wrapper">
							<?php
							$args = array(
								'container' => false,
								'theme_location' => 'menu-mobile',
								'items_wrap' => '<ul id="%1$s" class="menu-items">%3$s</ul>',
								'add_li_class' => 'nav-item'
							);
							wp_nav_menu($args);
							?>
						</div>
					</div>
				</nav>




				<div class="mobile-wrapper">
					<div class="mobile-wrapper__menu-toggle">
						<div class="bar1"></div>
						<div class="bar2"></div>
						<div class="bar3"></div>
					</div>
					<img class="mobile-wrapper__search" src="/wp-content/uploads/2024/07/Component-1.svg" alt="Search Icon" />
					<a href="/">
						<img class="mobile-wrapper__logo" src="<?php echo $header['logo']['url']; ?>" alt="<?php echo $header['logo']['alt']; ?>" />
					</a>
					<a class="mobile-wrapper__link" href="/lista-zelja">
						<img src="/wp-content/uploads/2024/07/Component-3.svg" alt="Wishlist" />
						<span class="wishlist-count">0</span>
					</a>
					<?php echo do_shortcode('[fk_cart_menu]'); ?>
				</div>
			</div>
		</div>

		<div class="search-popup" id="searchPopup">
			<div class="search-popup__content">
				<form action="/" method="get" id="mobile-search">
					<input type="text" id="search-mobile" name="s" placeholder="Pretražite..." />
					<img src="/wp-content/uploads/2024/07/Component-1.svg" alt="Search Icon" />
					<img class="close2" id="close2" src="/wp-content/uploads/2024/08/x.svg" alt="Close Icon" />
				</form>

				<div id="search-results-mobile"></div>
			</div>
		</div>
	</header>

	<style>
		@media (min-width: 768px) and (max-width: 1024px) and (orientation: portrait) {

			/* Apply desktop main menu style */
			.main-wrapper__main-menu.desktop {
				display: flex;
			}

			/* Hide the search form */
			#headersearch {
				display: none;
			}

			/* Show the mobile search icon */
			.mobile-wrapper__search {
				display: block;
			}

			/* Adjust other styles as needed */
		}
	</style>

	<script>
		jQuery(document).ready(function($) {
			$('#search-results').hide();
			$('#search-results-mobile').hide();

			// Desktop Search
			$('#search').on('keyup', function() {
				var searchQuery = $(this).val();

				if (searchQuery.length >= 3) {
					$.ajax({

						url: '/wp-admin/admin-ajax.php',
						type: 'GET',
						data: {
							action: 'woocommerce_product_search',
							query: searchQuery
						}

						,
						success: function(data) {
							$('#search-results').html(data).show();
							$('body').addClass('no-scroll');
						}
					});
				} else {
					$('#search-results').empty().hide();

				}
			});

			// Mobile Search
			$('#search-mobile').on('keyup', function() {
				var searchQuery = $(this).val();

				if (searchQuery.length >= 3) {
					$.ajax({

						url: '/wp-admin/admin-ajax.php',
						type: 'GET',
						data: {
							action: 'woocommerce_product_search',
							query: searchQuery
						}

						,
						success: function(data) {
							$('#search-results-mobile').html(data).show();
							$('body').addClass('no-scroll');

						}
					});
				} else {
					$('#search-results-mobile').empty().hide();
				}
			});

			// Escape key handler for desktop and mobile
			$(document).on('keydown', function(e) {
				if (e.key === 'Escape' || e.keyCode === 27) {
					$('#search-desktop').val('');
					$('#search-mobile').val('');
					$('#search-results-desktop').empty().hide();
					$('#search-results-mobile').empty().hide();
					$('body').removeClass('no-scroll');
				}
			});

			// Toggle Menu
			const menuToggle = $('.mobile-wrapper__menu-toggle');
			const mainMenu = $('.main-wrapper__main-menu');

			menuToggle.on('click', function() {
				mainMenu.toggleClass('active');
				$('body').addClass('no-scroll');
			});

			// Search Popup
			const searchIcon = $('.mobile-wrapper__search');
			const searchPopup = $('#searchPopup');

			searchIcon.on('click', function() {
				searchPopup.toggleClass('active');
			});

			// Close Search Popup on Outside Click
			searchPopup.on('click', function(event) {
				if (event.target === searchPopup[0]) {
					searchPopup.removeClass('active');
				}
			});
		});

		jQuery(document).ready(function($) {
			$('.tab-item').on('click', function() {
				var tabId = $(this).data('tab');

				$('.tab-item').removeClass('active');
				$(this).addClass('active');

				$('.tab-pane').removeClass('active');
				$('#' + tabId).addClass('active');
			});

			$('#close').on('click', function() {
				$('.main-wrapper__main-menu').removeClass('active');
				$('body').removeClass('no-scroll');
			});

			$('#close2').on('click', function() {
				$('.search-popup').removeClass('active');
				$('body').removeClass('no-scroll');
			});
		});
		var $ = jQuery.noConflict();

		$(document).ready(function() {
			$(document).on('click', '#close3', function() {
				console.log('Close button clicked');
				$('#search-results').css('display', 'none');
				$('body').removeClass('no-scroll');
			});
		});

		document.querySelectorAll('.tab-item').forEach(item => {
			item.addEventListener('click', function() {
				// Remove active class from all tabs and panes
				document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
				document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));

				// Add active class to the clicked tab and corresponding pane
				this.classList.add('active');
				document.getElementById(this.getAttribute('data-tab')).classList.add('active');
			});
		});
	</script>

	<?php if (is_front_page() && !is_user_logged_in()) : ?>
		<script>
			jQuery(document).ready(function($) {
				// Function to set a cookie
				function setCookie(name, value, days) {
					var expires = "";
					if (days) {
						var date = new Date();
						date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
						expires = "; expires=" + date.toUTCString();
					}
					document.cookie = name + "=" + (value || "") + expires + "; path=/";
				}

				// Function to get a cookie
				function getCookie(name) {
					var nameEQ = name + "=";
					var ca = document.cookie.split(';');
					for (var i = 0; i < ca.length; i++) {
						var c = ca[i];
						while (c.charAt(0) == ' ') c = c.substring(1, c.length);
						if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
					}
					return null;
				}

				// Check if the popup has already been shown
				if (!getCookie('popup_shown')) {
					// Initially hide the popup
					$('.entry-popup').css('display', 'none');

					// Show the popup after 1000ms
					setTimeout(function() {
						$('.entry-popup').css('display', 'flex');
					}, 1000);

					// Close the popup when the close button is clicked
					$('.entry-popup__close').click(function() {
						$('.entry-popup').css('display', 'none');
						// Set a cookie to expire in 24 hours
						setCookie('popup_shown', 'true', 1);
					});
				}
			});
		</script>
	<?php endif; ?>
</body>

</html>