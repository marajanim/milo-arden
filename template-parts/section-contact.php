<?php
/**
 * Section: Contact / CTA
 *
 * Dark call-to-action card with heading, lede, and mailto button.
 * All text driven by Customizer settings registered in functions.php.
 *
 * @package MiloArden
 */

// All fields — Editable from Customizer → "CTA / Contact Section"
$eyebrow = get_theme_mod('milo_cta_eyebrow', 'Ready to start?');
$heading = get_theme_mod('milo_cta_heading', "Let's build something that matters.");
$lede = get_theme_mod('milo_cta_lede', "I'm currently booking projects for Q3 2026. Drop a line and I'll reply within a day.");
$button_label = get_theme_mod('milo_cta_button_label', 'Book a call');
$button_url = get_theme_mod('milo_cta_button_url', 'mailto:hello@milo.studio');
?>

<div class="cta-wrap" id="contact">
  <section class="cta-card">
    <div class="cta-inner">

      <div class="eyebrow on-dark">
        <span class="dot" aria-hidden="true"></span>
        <?php echo esc_html($eyebrow); ?>
      </div>

      <h2><?php echo wp_kses_post(nl2br($heading)); ?></h2>

      <p class="lede"><?php echo esc_html($lede); ?></p>

      <a href="<?php echo esc_url($button_url); ?>" class="btn">
        <?php echo esc_html($button_label); ?>
        <span class="arr" aria-hidden="true">→</span>
      </a>

    </div>
  </section>
</div>
