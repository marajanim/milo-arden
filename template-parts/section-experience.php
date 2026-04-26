<?php
/**
 * Section: Experience / Background
 *
 * ACF Repeater: milo_experience_items on Front Page.
 * Falls back to hardcoded PHP array when ACF is absent or repeater is empty.
 *
 * @package MiloArden
 */

// Section header (Customizer)
$eyebrow = get_theme_mod('milo_experience_eyebrow', 'Background');
$heading = get_theme_mod('milo_experience_heading', "Where I've been.");

// ── ACF Front Page ID ────────────────────────────────────────
$front_id = (int)get_option('page_on_front');

// ── Hardcoded fallback data ──────────────────────────────────
$fallback_experience = array(
    array('company' => 'Field Studio', 'note' => '(Independent)', 'role' => 'Design Engineer · Lead', 'years' => '2023 — Now'),
    array('company' => 'Ledger', 'note' => '', 'role' => 'Founding Designer', 'years' => '2022 — 2023'),
    array('company' => 'Halftone', 'note' => '(Contract)', 'role' => 'Product &amp; Brand', 'years' => '2021 — 2022'),
    array('company' => 'Mercy Accessibility Lab', 'note' => '', 'role' => 'Research Fellow', 'years' => '2020 — 2021'),
    array('company' => 'Stripe', 'note' => '', 'role' => 'Front-End Engineer · Platform', 'years' => '2018 — 2020'),
);

// ── Build experience array: ACF → fallback ───────────────────
$use_acf = milo_acf_has_rows('milo_experience_items', $front_id);
$experience = array();

if ($use_acf) {
  while (have_rows('milo_experience_items', $front_id)):
    the_row();
    $experience[] = array(
      'company' => get_sub_field('company'),
      'note' => get_sub_field('note'),
      'role' => get_sub_field('role'),
      'years' => get_sub_field('years'),
    );
  endwhile;
}

if (empty($experience)) {
  $experience = $fallback_experience;
}
?>

<section class="section tight">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php echo esc_html($eyebrow); ?></div>
    <h2><?php echo esc_html($heading); ?></h2>
  </div>

  <div class="exp-wrap">
    <?php foreach ($experience as $entry): ?>
      <div class="exp-row reveal">
        <div class="co">
          <?php echo esc_html($entry['company']); ?>
          <?php if (!empty($entry['note'])): ?>
            <span class="note"><?php echo esc_html($entry['note']); ?></span>
          <?php
  endif; ?>
        </div>
        <div class="role"><?php echo wp_kses_post($entry['role']); ?></div>
        <div class="yr"><?php echo esc_html($entry['years']); ?></div>
      </div>
    <?php
endforeach; ?>
  </div>
</section>
