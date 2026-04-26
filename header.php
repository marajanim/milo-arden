<?php
/**
 * Milo Arden — header.php
 *
 * Outputs <head>, body opening, and the floating nav bar.
 * NOTE: .hero-wrap is opened here (not closed until section-hero.php).
 *
 * @package MiloArden
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- hero-wrap opens here so the absolute-positioned nav sits inside the dark card.
     It is closed at the bottom of template-parts/section-hero.php -->
<div class="hero-wrap">

  <nav aria-label="<?php esc_attr_e('Primary navigation', 'milo-arden'); ?>">

    <!-- ── Logo ──────────────────────────────────────────────── -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" rel="home">
      <?php
$custom_logo_id = get_theme_mod('custom_logo');
if ($custom_logo_id): ?>
          <?php echo wp_get_attachment_image($custom_logo_id, 'thumbnail', false, array(
    'class' => 'custom-logo',
    'alt' => get_bloginfo('name'),
  )); ?>
      <?php
else: ?>
          <div class="mark" aria-hidden="true">m</div>
          <span><?php bloginfo('name'); ?></span>
      <?php
endif; ?>
    </a>

    <!-- ── Primary nav links (Milo_Nav_Walker for aria-current + clean markup) -->
    <div class="nav-center">
      <?php
wp_nav_menu(array(
  'theme_location' => 'primary',
  'menu_class' => '', // ul class — kept empty; CSS targets nav .nav-center ul
  'container' => false, // no extra wrapping element
  'depth' => 2, // support one level of dropdowns if ever added
  'walker' => new Milo_Nav_Walker(),
  'fallback_cb' => 'milo_nav_fallback',
));
?>
    </div>

    <!-- ── CTA pill ──────────────────────────────────────────── -->
    <a href="<?php echo esc_url(get_theme_mod('milo_cta_button_url', '#contact')); ?>" class="nav-cta">
      <span class="dot" aria-hidden="true"></span>
      <?php echo esc_html(get_theme_mod('milo_nav_cta_label', "Let's talk")); ?>
    </a>

  </nav>

<?php
/**
 * Fallback for the primary menu when no menu is assigned in WP Admin.
 * Outputs a plain <ul> of anchor links matching the original design.
 */
if (!function_exists('milo_nav_fallback')):
  function milo_nav_fallback()
  {
    $links = array(
      '#work' => __('Work', 'milo-arden'),
      '#process' => __('Process', 'milo-arden'),
      '#words' => __('Words', 'milo-arden'),
      '#faq' => __('FAQ', 'milo-arden'),
    );
    echo '<ul>';
    foreach ($links as $href => $label) {
      printf('<li><a href="%s">%s</a></li>', esc_url($href), esc_html($label));
    }
    echo '</ul>';
  }
endif;
