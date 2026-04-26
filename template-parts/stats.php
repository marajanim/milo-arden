<?php
/**
 * Dark stats / numbers section partial.
 * Values editable via Appearance → Customize → Stats Section.
 *
 * @package MiloArden
 */

$stats = array(
        array(
        'num' => get_theme_mod('milo_stat_1_number', '64<span class="u">+</span>'),
        'label' => get_theme_mod('milo_stat_1_label', 'Projects shipped end-to-end since 2018'),
        'delay' => '',
    ),
        array(
        'num' => get_theme_mod('milo_stat_2_number', '28'),
        'label' => get_theme_mod('milo_stat_2_label', 'Teams and founders I\'ve collaborated with'),
        'delay' => 'd1',
    ),
        array(
        'num' => get_theme_mod('milo_stat_3_number', '3<span class="u">×</span>'),
        'label' => get_theme_mod('milo_stat_3_label', 'Awwwards recognitions for design + craft'),
        'delay' => 'd2',
    ),
);
?>
<div class="stats-dark">
  <div class="stats-inner">

    <div class="stats-head reveal">
      <div class="eyebrow on-dark"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('By the numbers', 'milo-arden'); ?></div>
      <h2><?php esc_html_e('Seven years, measured.', 'milo-arden'); ?></h2>
      <p class="lede"><?php esc_html_e("Work I've been proud to put my name on, and the teams I've put it on with.", 'milo-arden'); ?></p>
    </div>

    <div class="stats-row">
      <?php foreach ($stats as $stat): ?>
        <div class="stat reveal <?php echo esc_attr($stat['delay']); ?>">
          <div class="num"><?php echo wp_kses_post($stat['num']); ?></div>
          <div class="lbl"><?php echo esc_html($stat['label']); ?></div>
        </div>
      <?php
endforeach; ?>
    </div>

  </div>
</div>
