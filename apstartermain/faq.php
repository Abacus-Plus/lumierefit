<?php
//Template Name: Faq page
$faq = get_field('faq');
get_header() ?>
<section class="faq-wrapper">
    <div class="container">
        <div class="hero-contact__title">
            <h1 class="w-400 color-is-black hm-1">
                Često postavljana pitanja
            </h1>
        </div>
        <div class="faq">
            <?php if (have_rows('faq')): ?>
                <div class="accordion" id="faqAccordion">
                    <?php
                    $faq_index = 0;
                    while (have_rows('faq')): the_row();
                        $faq_index++;
                        $question = get_sub_field('title');
                        $answer = get_sub_field('body');
                    ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?php echo $faq_index; ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $faq_index; ?>" aria-expanded="false" aria-controls="collapse<?php echo $faq_index; ?>">
                                    <?php echo esc_html($question); ?>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $faq_index; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $faq_index; ?>" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <?php echo wp_kses_post($answer); ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php get_footer() ?>