<?php
/**
 * Section: FAQ
 *
 * ACF Repeater: milo_faq_items on Front Page.
 * Falls back to hardcoded PHP array when ACF is absent or repeater is empty.
 * Uses native <details>/<summary> — pure CSS accordion, zero JS.
 *
 * @package MiloArden
 */

// Section header (Customizer)
$eyebrow = get_theme_mod('milo_faq_eyebrow', 'Questions');
$heading = get_theme_mod('milo_faq_heading', 'Common questions.');

// ── ACF Front Page ID ────────────────────────────────────────
$front_id = (int)get_option('page_on_front');

// ── Hardcoded fallback data ──────────────────────────────────
$fallback_faqs = array(
    array(
    'question' => 'How do you typically work with teams?',
    'answer' => 'I work as a one-person senior team — embedded for a stretch (usually six to twelve weeks), with a clear outcome agreed up front. Async by default, weekly sync, Friday demos. Nothing exotic.',
  ),
    array(
    'question' => 'What does an engagement cost?',
    'answer' => 'Pricing is per engagement rather than hourly — typically $18–45k depending on scope and shape. I try to quote tightly and won\'t take a project I don\'t think will succeed.',
  ),
    array(
    'question' => 'Do you work with designers, or only as a solo?',
    'answer' => 'Both. I\'ve led small teams, embedded as a +1 in existing ones, and worked as the only designer-engineer in early-stage companies. Happy to flex into what you need.',
  ),
    array(
    'question' => 'What\'s your stack?',
    'answer' => 'React, TypeScript, and Tailwind for most product work. Figma for design. Framer Motion or GSAP for motion. Comfortable across the stack, and will pick up whatever the team is already using.',
  ),
    array(
    'question' => 'When can you start?',
    'answer' => 'Right now, I have capacity from Q3 2026. I usually book one project at a time so focus doesn\'t get split. Happy to run a short scoping session before any commitment.',
  ),
);

// ── Build FAQ array: ACF → fallback ──────────────────────────
$use_acf = milo_acf_has_rows('milo_faq_items', $front_id);
$faqs = array();

if ($use_acf) {
  while (have_rows('milo_faq_items', $front_id)):
    the_row();
    $faqs[] = array(
      'question' => get_sub_field('question'),
      'answer' => get_sub_field('answer'),
    );
  endwhile;
}

if (empty($faqs)) {
  $faqs = $fallback_faqs;
}
?>

<section class="section tight" id="faq">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php echo esc_html($eyebrow); ?></div>
    <h2><?php echo esc_html($heading); ?></h2>
  </div>

  <div class="faq-wrap">
    <?php foreach ($faqs as $faq): ?>
      <details class="faq-item reveal">
        <summary>
          <?php echo esc_html($faq['question']); ?>
          <span class="plus" aria-hidden="true">+</span>
        </summary>
        <div class="answer"><?php echo esc_html($faq['answer']); ?></div>
      </details>
    <?php
endforeach; ?>
  </div>
</section>
