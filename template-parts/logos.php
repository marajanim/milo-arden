<?php
/**
 * Logos / Client strip partial.
 * TODO: Replace hardcoded client names with a CPT or Customizer repeater.
 *
 * @package MiloArden
 */
?>
<section class="logos" aria-label="<?php esc_attr_e('Trusted by', 'milo-arden'); ?>">
  <div class="logos-label"><?php esc_html_e('Trusted by teams who ship', 'milo-arden'); ?></div>
  <div class="logos-row">
    <?php
$clients = array('Stripe', 'Ledger', 'Thread', 'Margin', 'Halftone', 'Fieldnote');
foreach ($clients as $client):
?>
      <div class="logo-item"><?php echo esc_html($client); ?></div>
    <?php
endforeach; ?>
  </div>
</section>
