<?php
/**
 * The template for displaying single Case Study
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Abacus_Plus
 */
$case_study_intro = get_field('case_study_intro');
get_header(); ?>

<section class="cs-section">
    <h1 class="color-is-white w-500"><?php echo the_title(); ?></h1>
    <div class="cs-section__intro">
        <div class="year">
            <p class="color-is-white w-400 p-big">Year</p>
            <span class="color-is-white w-500 intro"><?php echo $case_study_intro['year']; ?></span>
        </div>
        <div class="platform">
            <p class="color-is-white w-400 p-big">Platform</p>
            <span class="color-is-white w-500 intro"><?php echo $case_study_intro['platform']; ?></span>
        </div>
        <div class="project-scope">
            <p class="color-is-white w-400 p-big">Platform</p>
            <span class="color-is-white w-500 intro"><?php echo $case_study_intro['project_scope']; ?></span>
        </div>
    </div>
    <div class="cs-section__content">
        <?php echo the_content(); ?>
    </div>
</section>