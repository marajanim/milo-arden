<?php
/**
 * Section: Logos / Client Strip
 *
 * Displays trusted-by client names. Currently driven by a Customizer
 * repeater-style comma-separated setting. Can be upgraded to a CPT
 * or ACF repeater field for richer data (logos, URLs).
 *
 * @package MiloArden
 */

// Editable from Customizer → "Logos Section"
$logos_label = get_theme_mod('milo_logos_label', 'Trusted by teams who ship');
$logos_csv = get_theme_mod('milo_logos_names', 'Stripe,Ledger,Thread,Margin,Halftone,Fieldnote');
$logos = array_map('trim', explode(',', $logos_csv));
?>

<section class="logos" aria-label="<?php esc_attr_e('Trusted by', 'milo-arden'); ?>">
  <div class="logos-label"><?php echo esc_html($logos_label); ?></div>
  <div class="logos-row">
    <?php foreach ($logos as $name): ?>
      <div class="logo-item"><?php echo esc_html($name); ?></div>
    <?php
endforeach; ?>
  </div>
</section>
