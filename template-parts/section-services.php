<?php
/**
 * Section: Services / "What I Build" — Process + Feature Grid
 *
 * Left card: stat + description. Right card: pull-quote testimonial.
 * All text driven by Customizer settings.
 *
 * @package MiloArden
 */

// Section header — Editable from Customizer
$eyebrow = get_theme_mod('milo_services_eyebrow', 'What I build');
$heading = get_theme_mod('milo_services_heading', 'Everything you need to take a product from idea to ship.');
$lede = get_theme_mod('milo_services_lede', 'I work as a small, senior team of one — research, design, and engineering under a single person. Less handoff, more craft.');

// Stat card — Editable from Customizer
$card_eyebrow = get_theme_mod('milo_services_card_eyebrow', 'Foundation');
$card_title = get_theme_mod('milo_services_card_title', 'Product design & systems');
$card_desc = get_theme_mod('milo_services_card_desc', 'Design systems, component libraries, and full product flows that stay consistent as teams scale.');
$card_number = get_theme_mod('milo_services_card_number', '64');
$card_unit = get_theme_mod('milo_services_card_unit', '+');
$card_chip = get_theme_mod('milo_services_card_chip', 'Shipped');

// Quote card — Editable from Customizer
$quote_text = get_theme_mod('milo_services_quote', '"The kind of collaborator you build a company around."');
$quote_desc = get_theme_mod('milo_services_quote_desc', 'Seven years of work across startups, labs, and agencies — shipped, documented, and loved.');
$quote_name = get_theme_mod('milo_services_quote_name', 'Elena Vasquez');
$quote_role = get_theme_mod('milo_services_quote_role', 'Founder, Ledger');
?>

<section class="section" id="process">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php echo esc_html($eyebrow); ?></div>
    <h2><?php echo wp_kses_post($heading); ?></h2>
    <p class="lede"><?php echo esc_html($lede); ?></p>
  </div>

  <div class="feature-grid">

    <!-- Stat card -->
    <div class="feature-card reveal">
      <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php echo esc_html($card_eyebrow); ?></div>
      <h3><?php echo esc_html($card_title); ?></h3>
      <p class="desc"><?php echo esc_html($card_desc); ?></p>
      <div class="number"><?php echo esc_html($card_number); ?><span class="unit"><?php echo esc_html($card_unit); ?></span></div>
      <div class="chip"><span class="d" aria-hidden="true"></span> <?php echo esc_html($card_chip); ?></div>
    </div>

    <!-- Quote card -->
    <div class="feature-card quote-card reveal d1">
      <div class="eyebrow on-dark"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Words', 'milo-arden'); ?></div>
      <h3><?php echo esc_html($quote_text); ?></h3>
      <p class="desc"><?php echo esc_html($quote_desc); ?></p>
      <div class="avatar-row">
        <div class="avatar" aria-hidden="true"></div>
        <div class="av-info">
          <strong><?php echo esc_html($quote_name); ?></strong>
          <span><?php echo esc_html($quote_role); ?></span>
        </div>
      </div>
    </div>

  </div>
</section>
