<?php



/**

 * The template for displaying the footer

 *

 * Contains the closing of the #content div and all content after.

 *

 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials

 *

 * @package Abacus_Plus

 */



$footer = get_field('footer', 'option');

$year = date('Y');

?>



<footer class="section-footer">
	<div class="container">
		<div class="row">
			<div class="section-footer__logo col-lg-4">
				<img src="<?php echo $footer['logo']; ?>" alt="Logo" />
				<p class="p-small w-400 color-is-neutral-900"><?php echo $footer['about_company']; ?></p>
				<div class="section-footer__socials">
					<?php
					foreach ($footer['useful_links'] as $social) { ?>
						<a href="<?php echo $social['link']; ?>">
							<img src="<?php echo $social['banner']; ?>" alt="Social Icon" />
						</a>
					<?php } ?>
				</div>
			</div>
			<div class="section-footer__about col-lg-2">
				<span class="section-footer__title">O nama</span>
				<ul class="section-footer__list">
					<?php
					foreach ($footer['o_nama'] as $about) { ?>
						<li>
							<a href="<?php echo $about['link']; ?>">
								<?php echo $about['title']; ?>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
			<div class="section-footer__useful-links col-lg-3">
				<span class="section-footer__title">Podrška</span>
				<?php
				wp_nav_menu(array(
					'theme_location' => 'footer-menu',
					'container' => 'nav',
					'container_class' => 'footer-menu',
					'menu_class' => 'section-footer__list',
					'fallback_cb' => false
				));
				?>
			</div>
			<div class="section-footer__contact col-lg-3">
				<span class="section-footer__title">Kontakt</span>
				<ul class="section-footer__list">
					<?php
					foreach ($footer['contact_informations'] as $contact) { ?>
						<li>
							<a href="<?php echo $contact['link']; ?>">
								<?php echo $contact['title']; ?><?php echo $contact['information']; ?>
							</a>
						</li>
					<?php } ?>
				</ul>
				<span class="section-footer__title2">Radno vrijeme</span>
				<ul class="section-footer__list">
					<li>
						Ponedeljak - Petak: 11 - 20 h
					</li>
					<li>
						Subota : 12-17 h
					</li>
					<li>
						Nedjelja : Zatvoreno
					</li>
				</ul>
			</div>
			<div class="section-footer__copyright">
				<p class="p-small w-400 color-is-neutral-900"><?php echo $year; ?> © LUMIERE Sva prava zadržana. Created by Abacus Plus</p>
				<div class="payment-wrapper">
					<?php foreach ($footer['payments'] as $payments) { ?>
						<img src="<?php echo $payments['payment']['url']; ?>" alt="<?php echo $payments['payment']['alt']; ?>" />
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</footer>



<?php wp_footer(); ?>



</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all variation images with the 'variation-image' class
    const variationImages = document.querySelectorAll('.variation-image');

    variationImages.forEach(function(image) {
        image.addEventListener('click', function(e) {
            e.preventDefault();

            // Get the color slug from the clicked image
            const colorSlug = this.getAttribute('data-color-slug');

            // Get the product URL
            const productUrl = this.getAttribute('href');

            // Construct the URL to include the selected color in query parameters
            const updatedUrl = new URL(productUrl);
            updatedUrl.searchParams.set('selected_color', colorSlug);

            // Redirect to the updated URL
            window.location.href = updatedUrl.href;
        });
    });
});





	
jQuery(function($) {
    function modifyAttributeText() {
        const spanElement = $('.wc-block-components-product-details__boja .wc-block-components-product-details__value');
        if (spanElement.length) {
            const originalText = spanElement.text();
            const modifiedText = originalText.replace(/^\S+\s/, ''); // Removes the first word
            spanElement.text(modifiedText); // Update the span content
        }
    }

    // Run on initial page load
    modifyAttributeText();

    // Listen for updates on the checkout page
    $(document.body).on('updated_cart_totals updated_checkout wc_fragments_loaded', function() {
        modifyAttributeText();
    });

    // Extra: Ensure it works when AJAX updates happen in other WooCommerce components
    $(document.body).on('wc_cart_button_updated', function() {
        modifyAttributeText();
    });
});



</script>

</html>