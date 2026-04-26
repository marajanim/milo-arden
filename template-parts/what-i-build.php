<?php
/**
 * "What I Build" — Process / Feature section partial.
 * TODO: Wire quote-card fields to CPT Testimonials or Customizer.
 *
 * @package MiloArden
 */
?>
<section class="section" id="process">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('What I build', 'milo-arden'); ?></div>
    <h2><?php esc_html_e('Everything you need to take a product from idea to ship.', 'milo-arden'); ?></h2>
    <p class="lede"><?php esc_html_e('I work as a small, senior team of one — research, design, and engineering under a single person. Less handoff, more craft.', 'milo-arden'); ?></p>
  </div>

  <div class="feature-grid">

    <!-- Stat card -->
    <div class="feature-card reveal">
      <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Foundation', 'milo-arden'); ?></div>
      <h3><?php esc_html_e('Product design & systems', 'milo-arden'); ?></h3>
      <p class="desc"><?php esc_html_e('Design systems, component libraries, and full product flows that stay consistent as teams scale.', 'milo-arden'); ?></p>
      <div class="number">64<span class="unit">+</span></div>
      <div class="chip"><span class="d" aria-hidden="true"></span> <?php esc_html_e('Shipped', 'milo-arden'); ?></div>
    </div>

    <!-- Quote card -->
    <div class="feature-card quote-card reveal d1">
      <div class="eyebrow on-dark"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Words', 'milo-arden'); ?></div>
      <h3><?php esc_html_e('"The kind of collaborator you build a company around."', 'milo-arden'); ?></h3>
      <p class="desc"><?php esc_html_e('Seven years of work across startups, labs, and agencies — shipped, documented, and loved.', 'milo-arden'); ?></p>
      <div class="avatar-row">
        <div class="avatar" aria-hidden="true"></div>
        <div class="av-info">
          <strong>Elena Vasquez</strong>
          <span><?php esc_html_e('Founder, Ledger', 'milo-arden'); ?></span>
        </div>
      </div>
    </div>

  </div>
</section>
