<?php
//Template Name: Prodavnice

$hero = get_field('hero');
$slika = get_field('slika');
$cards = get_field('cards');
$forma = get_field('forma');
$lokacijakontent = get_field('lokacija_kontent');
$lokacija = get_field('map');
$video = get_field('video');
get_header();
?>

<section class="hero-contact">
    <div class="container">
        <div class="hero-contact__title">
            <h1 class="w-400 color-is-black hm-2">
                <?php echo $hero['hero_titile']; ?>
            </h1>
            <p class="p-big w-400 color-is-black">
                <?php echo $hero['hero_paragraph']; ?>
            </p>
        </div>


        <img class="hero-section__image" src="<?php echo $slika; ?>" alt="Background Image" />
    </div>
</section>
<section class="contact-form">
    <div class="container">
        <div class="contact-form__inner">
            <h3 class="w-400 color-is-black hm-1">
                <?php echo $forma['title']; ?>
            </h3>
            <p class="p-small w-400 color-is-black">
                <?php echo $forma['paragraph']; ?>
            </p>
            <div class="contact-form__wrapper">
                <div class="card-contact__wrapper">
                    <?php foreach ($cards as $card) { ?>
                        <div class="card-contact__inner">
                            <div class="card-contact__icon">
                                <img src="<?php echo $card['icon']; ?>" alt="info" />
                            </div>
                            <div class="card-contact__content">
                                <h4 class="w-400 color-is-black hm-1">
                                    <?php echo $card['title']; ?>
                                </h4>
                                <p class="p-small w-400 color-is-black">
                                    <?php echo $card['paragraph']; ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="lokacija">
    <div class="container">
        <div class="lokacija__inner">
            <div class="lokacija__content">
                <h3 class="w-400 color-is-black hm-2">
                    <?php echo $lokacijakontent['title']; ?>
                </h3>
                <p class="p-small w-400 color-is-black">
                    <?php echo $lokacijakontent['paragraph']; ?>
                </p>
            </div>
        </div>

        <section class="video">
            <div class="video__inner">
                <?php if ($video['background_type'] === false) { ?>
                    <video style="width:100%; height: 100%; object-fit:cover;" autoplay playsinline loop muted preload="auto">
                        <source src="<?php echo $video['video_upload']; ?>" type="video/mp4" />
                    </video>
                <?php } elseif ($video['background_type'] === true) { ?>
                    <div class="ember-cointainer">
                        <div class="ember-video">
                            <?php echo $video['youtube_video']; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>

        <div class="acf-map" data-zoom="18">
            <div class="marker" data-lat="<?php echo esc_attr($lokacija['lat']); ?>" data-lng="<?php echo esc_attr($lokacija['lng']); ?>"></div>
        </div>
    </div>
</section>
<?php get_footer(); ?>

<script>
    (function($) {

        /**
         * initMap
         *
         * Renders a Google Map onto the selected jQuery element
         *
         * @date    22/10/19
         * @since   5.8.6
         *
         * @param   jQuery $el The jQuery element.
         * @return  object The map instance.
         */
        function initMap($el) {

            // Find marker elements within map.
            var $markers = $el.find('.marker');

            // Create gerenic map.
            var mapArgs = {
                zoom: $el.data('zoom') || 16,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map($el[0], mapArgs);

            // Add markers.
            map.markers = [];
            $markers.each(function() {
                initMarker($(this), map);
            });

            // Center map based on markers.
            centerMap(map);

            // Return map instance.
            return map;
        }

        /**
         * initMarker
         *
         * Creates a marker for the given jQuery element and map.
         *
         * @date    22/10/19
         * @since   5.8.6
         *
         * @param   jQuery $el The jQuery element.
         * @param   object The map instance.
         * @return  object The marker instance.
         */
        function initMarker($marker, map) {

            // Get position from marker.
            var lat = $marker.data('lat');
            var lng = $marker.data('lng');
            var latLng = {
                lat: parseFloat(lat),
                lng: parseFloat(lng)
            };

            // Create marker instance.
            var marker = new google.maps.Marker({
                position: latLng,
                map: map
            });

            // Append to reference for later use.
            map.markers.push(marker);

            // If marker contains HTML, add it to an infoWindow.
            if ($marker.html()) {

                // Create info window.
                var infowindow = new google.maps.InfoWindow({
                    content: $marker.html()
                });

                // Show info window when marker is clicked.
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map, marker);
                });
            }
        }

        /**
         * centerMap
         *
         * Centers the map showing all markers in view.
         *
         * @date    22/10/19
         * @since   5.8.6
         *
         * @param   object The map instance.
         * @return  void
         */
        function centerMap(map) {

            // Create map boundaries from all map markers.
            var bounds = new google.maps.LatLngBounds();
            map.markers.forEach(function(marker) {
                bounds.extend({
                    lat: marker.position.lat(),
                    lng: marker.position.lng()
                });
            });

            // Case: Single marker.
            if (map.markers.length == 1) {
                map.setCenter(bounds.getCenter());

                // Case: Multiple markers.
            } else {
                map.fitBounds(bounds);
            }
        }

        // Render maps on page load.
        $(document).ready(function() {
            $('.acf-map').each(function() {
                var map = initMap($(this));
            });
        });

    })(jQuery);
</script>