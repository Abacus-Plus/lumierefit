<?php

/**
 * The template for displaying Privacy policy
 * Template Name: Privacy policy
 **/
get_header();
?>
<section class="privacy-template">
    <div class="container">
        <h1 w-400 hm-1><?php the_title(); ?></h1>
        <div style="
    padding-top: 30px;">
            <?php the_content(); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>