<?php
/**
 * Section: Experience / Background
 *
 * Work-history timeline rows. Hardcoded PHP array as starter data
 * that mirrors the original HTML. Replace with WP_Query on
 * 'milo_experience' CPT when populated.
 *
 * @package MiloArden
 */

// Section header — Editable from Customizer
$eyebrow = get_theme_mod('milo_experience_eyebrow', 'Background');
$heading = get_theme_mod('milo_experience_heading', "Where I've been.");

// Starter data — replace with WP_Query loop on milo_experience CPT
$experience = array(
        array('company' => 'Field Studio', 'note' => '(Independent)', 'role' => 'Design Engineer · Lead', 'years' => '2023 — Now'),
        array('company' => 'Ledger', 'note' => '', 'role' => 'Founding Designer', 'years' => '2022 — 2023'),
        array('company' => 'Halftone', 'note' => '(Contract)', 'role' => 'Product &amp; Brand', 'years' => '2021 — 2022'),
        array('company' => 'Mercy Accessibility Lab', 'note' => '', 'role' => 'Research Fellow', 'years' => '2020 — 2021'),
        array('company' => 'Stripe', 'note' => '', 'role' => 'Front-End Engineer · Platform', 'years' => '2018 — 2020'),
);
?>

<section class="section tight">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php echo esc_html($eyebrow); ?></div>
    <h2><?php echo esc_html($heading); ?></h2>
  </div>

  <div class="exp-wrap">

    <?php
/**
 * Dynamic loop — uncomment when milo_experience CPT has data:
 *
 * $eq = new WP_Query( array(
 *     'post_type'      => 'milo_experience',
 *     'posts_per_page' => -1,
 *     'orderby'        => 'menu_order',
 *     'order'          => 'ASC',
 * ) );
 * if ( $eq->have_posts() ) :
 *   while ( $eq->have_posts() ) : $eq->the_post();
 *     $company = get_the_title();
 *     $note    = get_post_meta( get_the_ID(), 'milo_exp_note', true );
 *     $role    = get_post_meta( get_the_ID(), 'milo_exp_role', true );
 *     $years   = get_post_meta( get_the_ID(), 'milo_exp_years', true );
 *     // ... render .exp-row ...
 *   endwhile;
 *   wp_reset_postdata();
 * endif;
 */
?>

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
