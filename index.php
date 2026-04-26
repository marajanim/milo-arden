<?php
/**
 * Milo Arden — index.php / front-page.php skeleton
 *
 * WordPress falls back to this file for any non-matched template.
 * For the landing page, create front-page.php (identical structure).
 *
 * @package MiloArden
 */

get_header(); ?>

<main id="main" class="site-main">

	<?php get_template_part('template-parts/hero'); ?>

	<?php get_template_part('template-parts/logos'); ?>

	<?php get_template_part('template-parts/what-i-build'); ?>

	<?php get_template_part('template-parts/portfolio'); ?>

	<?php get_template_part('template-parts/stats'); ?>

	<?php get_template_part('template-parts/testimonials'); ?>

	<?php get_template_part('template-parts/experience'); ?>

	<?php get_template_part('template-parts/faq'); ?>

	<?php get_template_part('template-parts/cta'); ?>

</main>

<?php get_footer();
