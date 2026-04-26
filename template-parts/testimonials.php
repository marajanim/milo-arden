<?php
/**
 * Testimonials / "Kind Words" section partial.
 * TODO: Replace hardcoded cards with WP_Query on 'milo_testimonial' CPT.
 *
 * @package MiloArden
 */
?>
<section class="section" id="words">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Kind words', 'milo-arden'); ?></div>
    <h2><?php esc_html_e('Loved by the teams I work with.', 'milo-arden'); ?></h2>
    <p class="lede"><?php esc_html_e('A few lines from founders and collaborators I\'ve shipped with.', 'milo-arden'); ?></p>
  </div>

  <div class="test-grid">
    <!-- TODO: Replace with WP_Query loop over milo_testimonial CPT -->

    <div class="t-card reveal">
      <div class="logo">Ledger</div>
      <p class="txt"><?php esc_html_e('Milo has the rare ability to hold both ends of a problem at once. They argue system architecture at lunch and push pixels by dinner. The kind of person you build a company around.', 'milo-arden'); ?></p>
      <div class="who">
        <div class="avatar" aria-hidden="true"></div>
        <div class="info">
          <strong>Elena Vasquez</strong>
          <span><?php esc_html_e('Founder, Ledger', 'milo-arden'); ?></span>
        </div>
      </div>
    </div>

    <div class="t-card reveal d1">
      <div class="logo">Field Studio</div>
      <p class="txt"><?php esc_html_e('Hundreds of collaborators in my career. Milo sits firmly in the top five. Impeccable taste, structural thinking, and they actually ship the work.', 'milo-arden'); ?></p>
      <div class="who">
        <div class="avatar b" aria-hidden="true"></div>
        <div class="info">
          <strong>Hasan Yüce</strong>
          <span><?php esc_html_e('Principal, Field Studio', 'milo-arden'); ?></span>
        </div>
      </div>
    </div>

    <div class="t-card reveal d2">
      <div class="logo">Thread</div>
      <p class="txt"><?php esc_html_e('I gave Milo a half-formed brief and an impossible deadline. They returned something better than I could have specified. Then made it faster.', 'milo-arden'); ?></p>
      <div class="who">
        <div class="avatar c" aria-hidden="true"></div>
        <div class="info">
          <strong>Priya Srinivasan</strong>
          <span><?php esc_html_e('Head of Product, Thread', 'milo-arden'); ?></span>
        </div>
      </div>
    </div>

  </div>
</section>
