<?php
/**
 * Milo Arden — front-page.php
 *
 * Static front-page template that loads every section in order.
 * WordPress uses this file when Settings → Reading → "A static page"
 * is set as the homepage, or as a fallback for the blog home.
 *
 * @package MiloArden
 */

get_header(); ?>

<main id="main" class="site-main" role="main">

	<?php get_template_part('template-parts/section', 'hero'); ?>

	<?php get_template_part('template-parts/section', 'logos'); ?>

	<?php get_template_part('template-parts/section', 'services'); ?>

	<?php get_template_part('template-parts/section', 'portfolio'); ?>

	<?php get_template_part('template-parts/section', 'stats'); ?>

	<?php get_template_part('template-parts/section', 'testimonials'); ?>

	<?php get_template_part('template-parts/section', 'experience'); ?>

	<?php get_template_part('template-parts/section', 'faq'); ?>

	<?php get_template_part('template-parts/section', 'contact'); ?>

</main>

<?php get_footer();
