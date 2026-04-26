<?php
/**
 * Hero section partial.
 *
 * Opened inside .hero-wrap (started in header.php).
 * This file closes the .hero-wrap div.
 *
 * @package MiloArden
 */
?>
  <section class="hero" aria-label="<?php esc_attr_e('Introduction', 'milo-arden'); ?>">

    <!-- Left: copy -->
    <div class="hero-left">

      <div class="eyebrow on-dark">
        <span class="dot" aria-hidden="true"></span>
        <?php echo milo_get('milo_hero_eyebrow', 'Available · Q3 2026'); ?>
      </div>

      <h1>
        <?php echo milo_get('milo_hero_heading_before', 'Design-engineering for teams that'); ?>
        <span class="accent"><?php echo milo_get('milo_hero_heading_accent', 'ship'); ?></span><?php echo milo_get('milo_hero_heading_after', '.'); ?>
      </h1>

      <p class="lede"><?php echo milo_get('milo_hero_lede', 'Independent designer & front-end engineer. I help founders turn rough product ideas into polished, fast, considered software — from first sketch to production.'); ?></p>

      <div class="cta-row">
        <a href="<?php echo milo_get_url('milo_hero_cta_primary_url', '#contact'); ?>" class="btn">
          <?php echo milo_get('milo_hero_cta_primary_label', 'Book a call'); ?>
          <span class="arr" aria-hidden="true">→</span>
        </a>
        <a href="<?php echo milo_get_url('milo_hero_cta_ghost_url', '#work'); ?>" class="btn ghost">
          <?php echo milo_get('milo_hero_cta_ghost_label', 'See the work'); ?>
          <span class="arr" aria-hidden="true">↓</span>
        </a>
      </div>

      <div class="hero-trust">
        <div class="stars" aria-label="<?php esc_attr_e('5 stars', 'milo-arden'); ?>">
          <?php for ($i = 0; $i < 5; $i++): ?>
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.4H22l-6 4.3 2.3 7.3L12 16.6 5.7 21l2.3-7.3-6-4.3h7.6z"/></svg>
          <?php
endfor; ?>
        </div>
        <div class="meta">
          <strong><?php echo milo_get('milo_hero_star_rating', '5.0 rating'); ?></strong>
          · <?php echo milo_get('milo_hero_collaborators', 'from 34 collaborators'); ?>
        </div>
      </div>

    </div><!-- /.hero-left -->

    <!-- Right: decorative mockup card -->
    <div class="hero-right" aria-hidden="true">
      <div class="mockup-card">
        <div class="mockup-bar">
          <span class="dot-bar"></span>
          <span class="dot-bar"></span>
          <span class="dot-bar"></span>
          <span class="url">studio.miloarden.com</span>
        </div>
        <div class="mockup-body">
          <div class="mockup-header">
            <div class="title">Project overview</div>
            <div class="badge">LIVE</div>
          </div>
          <div class="mockup-kpis">
            <div class="kpi">
              <div class="lbl">Projects</div>
              <div class="val">64</div>
              <div class="trend">↑ 12 this year</div>
            </div>
            <div class="kpi highlight">
              <div class="lbl">On-time ship</div>
              <div class="val">98%</div>
              <div class="trend">↑ 3% QoQ</div>
            </div>
          </div>
          <div class="mockup-chart">
            <svg viewBox="0 0 300 80" preserveAspectRatio="none">
              <path class="draw" d="M0,60 C30,50 50,55 80,30 C110,10 140,45 170,25 C200,10 230,35 260,15 L300,10" fill="none" stroke="#0E2B1A" stroke-width="1.5"/>
              <path d="M0,60 C30,50 50,55 80,30 C110,10 140,45 170,25 C200,10 230,35 260,15 L300,10 L300,80 L0,80 Z" fill="rgba(14,43,26,0.08)"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="mockup-float">
        <div class="gauge"><span>87%</span></div>
        <div class="txt">
          <strong>Velocity</strong>
          <span>Above target</span>
        </div>
      </div>
    </div><!-- /.hero-right -->

  </section><!-- /.hero -->

</div><!-- /.hero-wrap (opened in header.php) -->
