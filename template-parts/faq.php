<?php
/**
 * FAQ section partial.
 * Uses native <details>/<summary> — zero JS needed.
 * TODO: Replace hardcoded items with WP_Query on 'milo_faq' CPT.
 *
 * @package MiloArden
 */

$faqs = array(
        array(
        'q' => 'How do you typically work with teams?',
        'a' => 'I work as a one-person senior team — embedded for a stretch (usually six to twelve weeks), with a clear outcome agreed up front. Async by default, weekly sync, Friday demos. Nothing exotic.',
    ),
        array(
        'q' => 'What does an engagement cost?',
        'a' => 'Pricing is per engagement rather than hourly — typically $18–45k depending on scope and shape. I try to quote tightly and won\'t take a project I don\'t think will succeed.',
    ),
        array(
        'q' => 'Do you work with designers, or only as a solo?',
        'a' => 'Both. I\'ve led small teams, embedded as a +1 in existing ones, and worked as the only designer-engineer in early-stage companies. Happy to flex into what you need.',
    ),
        array(
        'q' => 'What\'s your stack?',
        'a' => 'React, TypeScript, and Tailwind for most product work. Figma for design. Framer Motion or GSAP for motion. Comfortable across the stack, and will pick up whatever the team is already using.',
    ),
        array(
        'q' => 'When can you start?',
        'a' => 'Right now, I have capacity from Q3 2026. I usually book one project at a time so focus doesn\'t get split. Happy to run a short scoping session before any commitment.',
    ),
);
?>
<section class="section tight" id="faq">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Questions', 'milo-arden'); ?></div>
    <h2><?php esc_html_e('Common questions.', 'milo-arden'); ?></h2>
  </div>

  <div class="faq-wrap">
    <?php foreach ($faqs as $faq): ?>
      <details class="faq-item reveal">
        <summary>
          <?php echo esc_html($faq['q']); ?>
          <span class="plus" aria-hidden="true">+</span>
        </summary>
        <div class="answer"><?php echo esc_html($faq['a']); ?></div>
      </details>
    <?php
endforeach; ?>
  </div>
</section>
