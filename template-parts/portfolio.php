<?php
/**
 * Portfolio / Selected Work section partial.
 * TODO: Replace static cards with WP_Query on 'milo_project' CPT.
 *
 * @package MiloArden
 */
?>
<section class="section tight" id="work">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Selected work', 'milo-arden'); ?></div>
    <h2><?php esc_html_e('Where ideas take shape.', 'milo-arden'); ?></h2>
    <p class="lede"><?php esc_html_e('Five recent projects that show how design and engineering meet on my desk.', 'milo-arden'); ?></p>
  </div>

  <div class="projects-grid">
    <!-- TODO: Replace with WP_Query loop over milo_project CPT -->
    <div class="p-card reveal">
      <div class="p-visual pv-dashboard" aria-hidden="true">
        <div class="mini">
          <div class="ln w"></div><div class="ln wa"></div>
          <div class="bars"><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div></div>
        </div>
      </div>
      <div class="p-arrow" aria-hidden="true">→</div>
      <div class="p-head">
        <div class="p-title">Ledger</div>
        <div class="p-year">2025</div>
      </div>
      <p class="p-desc"><?php esc_html_e('A calm revenue dashboard that collapses six SaaS tools into one interface.', 'milo-arden'); ?></p>
      <div class="p-tags">
        <span class="p-tag">Product</span>
        <span class="p-tag">UI System</span>
        <span class="p-tag">Motion</span>
      </div>
    </div>

    <!-- Placeholder: add remaining project cards or loop here -->

    <div class="p-card reveal d1" style="justify-content:center;align-items:center;text-align:center;">
      <h3 style="margin-bottom:16px;"><?php esc_html_e('More in the archive', 'milo-arden'); ?></h3>
      <p class="p-desc" style="margin-bottom:24px;"><?php esc_html_e('Twenty-something more case studies, from side projects to client work.', 'milo-arden'); ?></p>
      <a href="<?php echo esc_url(get_post_type_archive_link('milo_project')); ?>" class="btn dark">
        <?php esc_html_e('Browse all', 'milo-arden'); ?>
        <span class="arr" aria-hidden="true">→</span>
      </a>
    </div>
  </div>
</section>
