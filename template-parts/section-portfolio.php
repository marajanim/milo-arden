<?php
/**
 * Section: Portfolio / Selected Work
 *
 * All 5 project cards + 1 "archive" card, faithfully ported from the
 * original HTML. Each card's visual slot uses a CSS-only mockup (no images).
 *
 * Dynamic version: replace the $projects array with a WP_Query on
 * the 'milo_project' CPT and use get_post_meta() for per-card data.
 *
 * @package MiloArden
 */

// Section header — Editable from Customizer
$eyebrow = get_theme_mod('milo_portfolio_eyebrow', 'Selected work');
$heading = get_theme_mod('milo_portfolio_heading', 'Where ideas take shape.');
$lede = get_theme_mod('milo_portfolio_lede', 'Five recent projects that show how design and engineering meet on my desk.');
?>

<section class="section tight" id="work">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php echo esc_html($eyebrow); ?></div>
    <h2><?php echo esc_html($heading); ?></h2>
    <p class="lede"><?php echo esc_html($lede); ?></p>
  </div>

  <div class="projects-grid">

    <?php
/**
 * Dynamic loop — uncomment when milo_project CPT has data:
 *
 * $projects_query = new WP_Query( array(
 *     'post_type'      => 'milo_project',
 *     'posts_per_page' => 6,
 *     'orderby'        => 'menu_order',
 *     'order'          => 'ASC',
 * ) );
 * if ( $projects_query->have_posts() ) :
 *   $idx = 0;
 *   while ( $projects_query->have_posts() ) : $projects_query->the_post();
 *     $year        = get_post_meta( get_the_ID(), 'milo_project_year', true );
 *     $visual_type = get_post_meta( get_the_ID(), 'milo_project_visual', true );
 *     $tags        = get_the_terms( get_the_ID(), 'milo_project_tag' );
 *     $delay       = ( $idx % 2 !== 0 ) ? 'd1' : '';
 *     // ... render card ...
 *     $idx++;
 *   endwhile;
 *   wp_reset_postdata();
 * endif;
 */
?>

    <!-- ─── Card 1: Ledger ─── -->
    <div class="p-card reveal">
      <div class="p-visual pv-dashboard" aria-hidden="true">
        <div class="mini">
          <div class="ln w"></div>
          <div class="ln wa"></div>
          <div class="bars">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
          </div>
        </div>
      </div>
      <div class="p-arrow" aria-hidden="true">→</div>
      <div class="p-head">
        <div class="p-title"><?php esc_html_e('Ledger', 'milo-arden'); ?></div>
        <div class="p-year">2025</div>
      </div>
      <p class="p-desc"><?php esc_html_e('A calm revenue dashboard that collapses six SaaS tools into one interface.', 'milo-arden'); ?></p>
      <div class="p-tags">
        <span class="p-tag"><?php esc_html_e('Product', 'milo-arden'); ?></span>
        <span class="p-tag"><?php esc_html_e('UI System', 'milo-arden'); ?></span>
        <span class="p-tag"><?php esc_html_e('Motion', 'milo-arden'); ?></span>
      </div>
    </div>

    <!-- ─── Card 2: Thread ─── -->
    <div class="p-card reveal d1">
      <div class="p-visual pv-inbox" aria-hidden="true">
        <div class="row"><span class="p u">URGENT</span><span><?php esc_html_e('Refund stuck on invoice #2841', 'milo-arden'); ?></span></div>
        <div class="row"><span class="p n">PENDING</span><span><?php esc_html_e('Seat count mismatch in billing', 'milo-arden'); ?></span></div>
        <div class="row"><span class="p n">RESOLVED</span><span><?php esc_html_e('SSO config for Acme.co', 'milo-arden'); ?></span></div>
        <div class="row"><span class="p u">URGENT</span><span><?php esc_html_e('Webhook failing — prod', 'milo-arden'); ?></span></div>
      </div>
      <div class="p-arrow" aria-hidden="true">→</div>
      <div class="p-head">
        <div class="p-title"><?php esc_html_e('Thread', 'milo-arden'); ?></div>
        <div class="p-year">2025</div>
      </div>
      <p class="p-desc"><?php esc_html_e('Rebuilt the support inbox around conversation state, not ticket state.', 'milo-arden'); ?></p>
      <div class="p-tags">
        <span class="p-tag"><?php esc_html_e('Product', 'milo-arden'); ?></span>
        <span class="p-tag"><?php esc_html_e('Research', 'milo-arden'); ?></span>
      </div>
    </div>

    <!-- ─── Card 3: Margin ─── -->
    <div class="p-card reveal">
      <div class="p-visual pv-editor" aria-hidden="true">
        <div class="page">
          <p>The best interfaces don't ask to be noticed. They hold the weight of the content they carry.</p>
          <p class="hl">A good interface still has a point of view — it just wears it lightly.</p>
          <p>The craft is in the restraint. Every choice is a vote against a louder one.</p>
        </div>
      </div>
      <div class="p-arrow" aria-hidden="true">→</div>
      <div class="p-head">
        <div class="p-title"><?php esc_html_e('Margin', 'milo-arden'); ?></div>
        <div class="p-year">2024</div>
      </div>
      <p class="p-desc"><?php esc_html_e('Collaborative annotation for long-form writing. Real-time, typographically correct.', 'milo-arden'); ?></p>
      <div class="p-tags">
        <span class="p-tag"><?php esc_html_e('Editor', 'milo-arden'); ?></span>
        <span class="p-tag"><?php esc_html_e('Realtime', 'milo-arden'); ?></span>
      </div>
    </div>

    <!-- ─── Card 4: Halftone ─── -->
    <div class="p-card reveal d1">
      <div class="p-visual pv-brand" aria-hidden="true">
        Hal<span class="x">f</span>tone
      </div>
      <div class="p-arrow" aria-hidden="true">→</div>
      <div class="p-head">
        <div class="p-title"><?php esc_html_e('Halftone', 'milo-arden'); ?></div>
        <div class="p-year">2024</div>
      </div>
      <p class="p-desc"><?php esc_html_e('A zine-first publishing platform for writers who care about typography.', 'milo-arden'); ?></p>
      <div class="p-tags">
        <span class="p-tag"><?php esc_html_e('Brand', 'milo-arden'); ?></span>
        <span class="p-tag"><?php esc_html_e('Type', 'milo-arden'); ?></span>
      </div>
    </div>

    <!-- ─── Card 5: Fieldnote ─── -->
    <div class="p-card reveal">
      <div class="p-visual pv-phone" aria-hidden="true">
        <div class="ph">
          <div class="scr">
            <div class="item">
              <div class="lbl">YESTERDAY · 4:12 PM</div>
              <div>Coffee with Sam. Talked about the garden.</div>
            </div>
            <div class="item">
              <div class="lbl">MON · 11:02 AM</div>
              <div>Dr. Ng, 2nd floor.</div>
            </div>
            <div class="item">
              <div class="lbl">LAST FRI</div>
              <div>Milk, bread, lemons.</div>
            </div>
          </div>
        </div>
      </div>
      <div class="p-arrow" aria-hidden="true">→</div>
      <div class="p-head">
        <div class="p-title"><?php esc_html_e('Fieldnote', 'milo-arden'); ?></div>
        <div class="p-year">2023</div>
      </div>
      <p class="p-desc"><?php esc_html_e('A voice-first memory aid for people with aphasia, built with Mercy Hospital.', 'milo-arden'); ?></p>
      <div class="p-tags">
        <span class="p-tag"><?php esc_html_e('Research', 'milo-arden'); ?></span>
        <span class="p-tag"><?php esc_html_e('A11y', 'milo-arden'); ?></span>
      </div>
    </div>

    <!-- ─── Card 6: Archive link ─── -->
    <div class="p-card reveal d1" style="justify-content: center; align-items: center; text-align: center;">
      <h3 style="margin-bottom: 16px;"><?php esc_html_e('More in the archive', 'milo-arden'); ?></h3>
      <p class="p-desc" style="margin-bottom: 24px;"><?php esc_html_e('Twenty-something more case studies, from side projects to client work.', 'milo-arden'); ?></p>
      <a href="<?php echo esc_url(get_post_type_archive_link('milo_project') ?: '#'); ?>" class="btn dark">
        <?php esc_html_e('Browse all', 'milo-arden'); ?>
        <span class="arr" aria-hidden="true">→</span>
      </a>
    </div>

  </div>
</section>
