<?php
/**
 * Experience / Background section partial.
 * TODO: Replace hardcoded rows with WP_Query on 'milo_experience' CPT.
 *
 * @package MiloArden
 */

$experience = array(
        array('company' => 'Field Studio', 'note' => '(Independent)', 'role' => 'Design Engineer · Lead', 'years' => '2023 — Now'),
        array('company' => 'Ledger', 'note' => '', 'role' => 'Founding Designer', 'years' => '2022 — 2023'),
        array('company' => 'Halftone', 'note' => '(Contract)', 'role' => 'Product & Brand', 'years' => '2021 — 2022'),
        array('company' => 'Mercy Accessibility Lab', 'note' => '', 'role' => 'Research Fellow', 'years' => '2020 — 2021'),
        array('company' => 'Stripe', 'note' => '', 'role' => 'Front-End Engineer · Platform', 'years' => '2018 — 2020'),
);
?>
<section class="section tight">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Background', 'milo-arden'); ?></div>
    <h2><?php esc_html_e("Where I've been.", 'milo-arden'); ?></h2>
  </div>

  <div class="exp-wrap">
    <?php foreach ($experience as $entry): ?>
      <div class="exp-row reveal">
        <div class="co">
          <?php echo esc_html($entry['company']); ?>
          <?php if ($entry['note']): ?>
            <span class="note"><?php echo esc_html($entry['note']); ?></span>
          <?php
    endif; ?>
        </div>
        <div class="role"><?php echo esc_html($entry['role']); ?></div>
        <div class="yr"><?php echo esc_html($entry['years']); ?></div>
      </div>
    <?php
endforeach; ?>
  </div>
</section>
