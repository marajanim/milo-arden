<?php
/**
 * Section: Testimonials / "Kind Words"
 *
 * ACF Repeater: milo_testimonial_items on Front Page.
 * Falls back to hardcoded PHP array when ACF is absent or repeater is empty.
 *
 * @package MiloArden
 */

// Section header (Customizer)
$eyebrow = get_theme_mod('milo_testimonials_eyebrow', 'Kind words');
$heading = get_theme_mod('milo_testimonials_heading', 'Loved by the teams I work with.');
$lede = get_theme_mod('milo_testimonials_lede', "A few lines from founders and collaborators I've shipped with.");

// ── ACF Front Page ID ────────────────────────────────────────
$front_id = (int)get_option('page_on_front');

// ── Hardcoded fallback data ──────────────────────────────────
$fallback_testimonials = array(
    array(
    'company' => 'Ledger',
    'quote' => 'Milo has the rare ability to hold both ends of a problem at once. They argue system architecture at lunch and push pixels by dinner. The kind of person you build a company around.',
    'author_name' => 'Elena Vasquez',
    'author_role' => 'Founder, Ledger',
    'avatar_variant' => '',
    'delay_class' => '',
  ),
    array(
    'company' => 'Field Studio',
    'quote' => 'Hundreds of collaborators in my career. Milo sits firmly in the top five. Impeccable taste, structural thinking, and they actually ship the work.',
    'author_name' => 'Hasan Yüce',
    'author_role' => 'Principal, Field Studio',
    'avatar_variant' => 'b',
    'delay_class' => 'd1',
  ),
    array(
    'company' => 'Thread',
    'quote' => 'I gave Milo a half-formed brief and an impossible deadline. They returned something better than I could have specified. Then made it faster.',
    'author_name' => 'Priya Srinivasan',
    'author_role' => 'Head of Product, Thread',
    'avatar_variant' => 'c',
    'delay_class' => 'd2',
  ),
);

// ── Build testimonials array: ACF → fallback ─────────────────
$use_acf = milo_acf_has_rows('milo_testimonial_items', $front_id);
$testimonials = array();

if ($use_acf) {
  while (have_rows('milo_testimonial_items', $front_id)):
    the_row();
    $testimonials[] = array(
      'company' => get_sub_field('company'),
      'quote' => get_sub_field('quote'),
      'author_name' => get_sub_field('author_name'),
      'author_role' => get_sub_field('author_role'),
      'avatar_variant' => get_sub_field('avatar_variant'),
      'delay_class' => get_sub_field('delay_class'),
    );
  endwhile;
}

if (empty($testimonials)) {
  $testimonials = $fallback_testimonials;
}
?>

<section class="section" id="words">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php echo esc_html($eyebrow); ?></div>
    <h2><?php echo esc_html($heading); ?></h2>
    <p class="lede"><?php echo esc_html($lede); ?></p>
  </div>

  <div class="test-grid">
    <?php foreach ($testimonials as $t): ?>
      <div class="t-card reveal <?php echo esc_attr($t['delay_class']); ?>">
        <div class="logo"><?php echo esc_html($t['company']); ?></div>
        <p class="txt"><?php echo esc_html($t['quote']); ?></p>
        <div class="who">
          <div class="avatar <?php echo esc_attr($t['avatar_variant']); ?>" aria-hidden="true"></div>
          <div class="info">
            <strong><?php echo esc_html($t['author_name']); ?></strong>
            <span><?php echo esc_html($t['author_role']); ?></span>
          </div>
        </div>
      </div>
    <?php
endforeach; ?>
  </div>
</section>
