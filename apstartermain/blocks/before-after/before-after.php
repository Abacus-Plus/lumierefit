<?php

/*
 ** Block Name: Before After
 */

if (is_admin()) {
    include __DIR__ . '/admin.php';
    return;
}
$image_before = get_field('image_before');
$image_after = get_field('image_after');
?>

<section class="image-comparison" data-component="image-comparison-slider">
    <div class="image-comparison__slider-wrapper">
        <input type="range" min="0" max="100" value="50" class="image-comparison__range" id="image-compare-range"
            data-image-comparison-range="">

        <div class="image-comparison__image-wrapper  image-comparison__image-wrapper--overlay"
            data-image-comparison-overlay="">
            <figure class="image-comparison__figure image-comparison__figure--overlay">
                <picture class="image-comparison__picture">
                    <img src="<?php echo $image_before['url']; ?>" alt="<?php echo $image_before['alt']; ?>"
                        class="image-comparison__image">
                </picture>
            </figure>
        </div>

        <div class="image-comparison__slider" data-image-comparison-slider="">
            <span class="image-comparison__thumb" data-image-comparison-thumb="">
                <img src="/wp-content/uploads/2024/06/Group-35.svg" alt="Slider Control" />
            </span>
        </div>

        <div class="image-comparison__image-wrapper">
            <figure class="image-comparison__figure">
                <picture class="image-comparison__picture">
                    <img src="<?php echo $image_after['url']; ?>" alt="<?php echo $image_after['alt']; ?>"
                        class="image-comparison__image">
                </picture>
            </figure>
        </div>
    </div>
</section>

<script>
    document.querySelectorAll('[data-component="image-comparison-slider"]').forEach(init);

    function setSliderstate(e, element) {
        const sliderRange = element.querySelector('[data-image-comparison-range]');

        if (e.type === 'input') {
            sliderRange.classList.add('image-comparison__range--active');
            return;
        }

        sliderRange.classList.remove('image-comparison__range--active');
        element.removeEventListener('mousemove', moveSliderThumb);
    }

    function moveSliderThumb(e) {
        const sliderRange = document.querySelector('[data-image-comparison-range]');
        const thumb = document.querySelector('[data-image-comparison-thumb]');
        let position = e.layerY - 20;

        if (e.layerY <= sliderRange.offsetTop) {
            position = -20;
        }

        if (e.layerY >= sliderRange.offsetHeight) {
            position = sliderRange.offsetHeight - 20;
        }

        thumb.style.top = `${position}px`;
    }

    function moveSliderRange(e, element) {
        const value = e.target.value;
        const slider = element.querySelector('[data-image-comparison-slider]');
        const imageWrapperOverlay = element.querySelector('[data-image-comparison-overlay]');

        slider.style.left = `${value}%`;
        imageWrapperOverlay.style.width = `${value}%`;

        element.addEventListener('mousemove', moveSliderThumb);
        setSliderstate(e, element);
    }

    function init(element) {
        const sliderRange = element.querySelector('[data-image-comparison-range]');

        if ('ontouchstart' in window === false) {
            sliderRange.addEventListener('mouseup', e => setSliderstate(e, element));
            sliderRange.addEventListener('mousedown', moveSliderThumb);
        }

        sliderRange.addEventListener('input', e => moveSliderRange(e, element));
        sliderRange.addEventListener('change', e => moveSliderRange(e, element));
    }

    init(imageComparisonSlider);
</script>