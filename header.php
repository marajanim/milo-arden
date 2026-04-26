<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<!-- hero-wrap opens here so the absolute-positioned nav sits inside it.
     It is closed at the bottom of template-parts/hero.php -->
<div class="hero-wrap">

  <nav aria-label="<?php esc_attr_e('Primary navigation', 'milo-arden'); ?>">

    <!-- ── Logo ────────────────────────────────────────────── -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" rel="home">
      <?php if (has_custom_logo()): ?>
        <?php the_custom_logo(); ?>
      <?php
else: ?>
        <div class="mark" aria-hidden="true">m</div>
        <span><?php bloginfo('name'); ?></span>
      <?php
endif; ?>
    </a>

    <!-- ── Primary nav links ───────────────────────────────── -->
    <div class="nav-center">
      <?php
wp_nav_menu(array(
    'theme_location' => 'primary',
    'menu_class' => '', // ul class — kept empty; CSS targets nav .nav-center ul
    'container' => false, // no wrapping div/nav (we supply our own)
    'depth' => 1,
    'fallback_cb' => 'milo_nav_fallback',
));
?>
    </div>

    <!-- ── CTA pill ────────────────────────────────────────── -->
    <a href="#contact" class="nav-cta">
      <span class="dot" aria-hidden="true"></span>
      <?php esc_html_e("Let's talk", 'milo-arden'); ?>
    </a>

  </nav>

<?php
/**
 * Fallback for when no primary menu is assigned.
 * Outputs a simple list of anchor links matching the original design.
 */
function milo_nav_fallback()
{
    echo '<ul>';
    $links = array(
        '#work' => __('Work', 'milo-arden'),
        '#process' => __('Process', 'milo-arden'),
        '#words' => __('Words', 'milo-arden'),
        '#faq' => __('FAQ', 'milo-arden'),
    );
    foreach ($links as $href => $label) {
        printf('<li><a href="%s">%s</a></li>', esc_url($href), esc_html($label));
    }
    echo '</ul>';
}
