<?php
/**
 * Section: Portfolio / Selected Work
 *
 * ACF Repeater: milo_portfolio_items on Front Page.
 * Falls back to hardcoded PHP array when ACF is absent or repeater is empty.
 *
 * Visual type dispatch: each card renders a CSS-only mockup based on
 * the visual_type field (dashboard, inbox, editor, brand, phone, archive).
 *
 * @package MiloArden
 */

// Section header (Customizer)
$eyebrow = get_theme_mod('milo_portfolio_eyebrow', 'Selected work');
$heading = get_theme_mod('milo_portfolio_heading', 'Where ideas take shape.');
$lede = get_theme_mod('milo_portfolio_lede', 'Five recent projects that show how design and engineering meet on my desk.');

// ── ACF Front Page ID ────────────────────────────────────────
$front_id = (int)get_option('page_on_front');

// ── Hardcoded fallback projects ──────────────────────────────
$fallback_projects = array(
    array(
    'visual_type' => 'dashboard',
    'title' => 'Ledger',
    'year' => '2025',
    'description' => 'A calm revenue dashboard that collapses six SaaS tools into one interface.',
    'tags' => 'Product, UI System, Motion',
    'delay_class' => '',
    'brand_text' => '',
    'brand_accent_letter' => '',
  ),
    array(
    'visual_type' => 'inbox',
    'title' => 'Thread',
    'year' => '2025',
    'description' => 'Rebuilt the support inbox around conversation state, not ticket state.',
    'tags' => 'Product, Research',
    'delay_class' => 'd1',
    'brand_text' => '',
    'brand_accent_letter' => '',
  ),
    array(
    'visual_type' => 'editor',
    'title' => 'Margin',
    'year' => '2024',
    'description' => 'Collaborative annotation for long-form writing. Real-time, typographically correct.',
    'tags' => 'Editor, Realtime',
    'delay_class' => '',
    'brand_text' => '',
    'brand_accent_letter' => '',
  ),
    array(
    'visual_type' => 'brand',
    'title' => 'Halftone',
    'year' => '2024',
    'description' => 'A zine-first publishing platform for writers who care about typography.',
    'tags' => 'Brand, Type',
    'delay_class' => 'd1',
    'brand_text' => 'Halftone',
    'brand_accent_letter' => 'f',
  ),
    array(
    'visual_type' => 'phone',
    'title' => 'Fieldnote',
    'year' => '2023',
    'description' => 'A voice-first memory aid for people with aphasia, built with Mercy Hospital.',
    'tags' => 'Research, A11y',
    'delay_class' => '',
    'brand_text' => '',
    'brand_accent_letter' => '',
  ),
    array(
    'visual_type' => 'archive',
    'title' => '',
    'year' => '',
    'description' => 'Twenty-something more case studies, from side projects to client work.',
    'tags' => '',
    'delay_class' => 'd1',
    'brand_text' => '',
    'brand_accent_letter' => '',
  ),
);

// ── Build projects array: ACF → fallback ─────────────────────
$use_acf = milo_acf_has_rows('milo_portfolio_items', $front_id);
$projects = array();

if ($use_acf) {
  while (have_rows('milo_portfolio_items', $front_id)):
    the_row();
    $projects[] = array(
      'visual_type' => get_sub_field('visual_type'),
      'title' => get_sub_field('title'),
      'year' => get_sub_field('year'),
      'description' => get_sub_field('description'),
      'tags' => get_sub_field('tags'),
      'delay_class' => get_sub_field('delay_class'),
      'brand_text' => get_sub_field('brand_text'),
      'brand_accent_letter' => get_sub_field('brand_accent_letter'),
    );
  endwhile;
}

if (empty($projects)) {
  $projects = $fallback_projects;
}
?>

<section class="section tight" id="work">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php echo esc_html($eyebrow); ?></div>
    <h2><?php echo esc_html($heading); ?></h2>
    <p class="lede"><?php echo esc_html($lede); ?></p>
  </div>

  <div class="projects-grid">

    <?php foreach ($projects as $p):
  $type = $p['visual_type'];
  $delay = !empty($p['delay_class']) ? esc_attr($p['delay_class']) : '';

  // ── Archive CTA card (special case) ─────────────────
  if ($type === 'archive'): ?>
        <div class="p-card reveal <?php echo $delay; ?>" style="justify-content: center; align-items: center; text-align: center;">
          <h3 style="margin-bottom: 16px;"><?php esc_html_e('More in the archive', 'milo-arden'); ?></h3>
          <p class="p-desc" style="margin-bottom: 24px;"><?php echo esc_html($p['description']); ?></p>
          <a href="<?php echo esc_url(get_post_type_archive_link('milo_project') ?: '#'); ?>" class="btn dark">
            <?php esc_html_e('Browse all', 'milo-arden'); ?>
            <span class="arr" aria-hidden="true">→</span>
          </a>
        </div>
      <?php continue;
  endif; ?>

      <!-- ─── Standard project card ─── -->
      <div class="p-card reveal <?php echo $delay; ?>">

        <?php // ── Visual mockup dispatch ──────────────────────
  switch ($type):

    case 'dashboard': ?>
            <div class="p-visual pv-dashboard" aria-hidden="true">
              <div class="mini">
                <div class="ln w"></div>
                <div class="ln wa"></div>
                <div class="bars">
                  <div class="bar"></div><div class="bar"></div><div class="bar"></div>
                  <div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div>
                </div>
              </div>
            </div>
            <?php break;

    case 'inbox': ?>
            <div class="p-visual pv-inbox" aria-hidden="true">
              <div class="row"><span class="p u">URGENT</span><span>Refund stuck on invoice #2841</span></div>
              <div class="row"><span class="p n">PENDING</span><span>Seat count mismatch in billing</span></div>
              <div class="row"><span class="p n">RESOLVED</span><span>SSO config for Acme.co</span></div>
              <div class="row"><span class="p u">URGENT</span><span>Webhook failing — prod</span></div>
            </div>
            <?php break;

    case 'editor': ?>
            <div class="p-visual pv-editor" aria-hidden="true">
              <div class="page">
                <p>The best interfaces don't ask to be noticed. They hold the weight of the content they carry.</p>
                <p class="hl">A good interface still has a point of view — it just wears it lightly.</p>
                <p>The craft is in the restraint. Every choice is a vote against a louder one.</p>
              </div>
            </div>
            <?php break;

    case 'brand':
      $brand_text = !empty($p['brand_text']) ? $p['brand_text'] : $p['title'];
      $accent = !empty($p['brand_accent_letter']) ? $p['brand_accent_letter'] : '';
      // Split brand text around the accent letter
      if ($accent && strpos($brand_text, $accent) !== false) {
        $parts = explode($accent, $brand_text, 2);
        $before = $parts[0];
        $after = $parts[1];
      }
      else {
        $before = $brand_text;
        $accent = '';
        $after = '';
      }
?>
            <div class="p-visual pv-brand" aria-hidden="true">
              <?php echo esc_html($before); ?><?php if ($accent): ?><span class="x"><?php echo esc_html($accent); ?></span><?php
      endif; ?><?php echo esc_html($after); ?>
            </div>
            <?php break;

    case 'phone': ?>
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
            <?php break;

  endswitch; ?>

        <div class="p-arrow" aria-hidden="true">→</div>
        <div class="p-head">
          <div class="p-title"><?php echo esc_html($p['title']); ?></div>
          <div class="p-year"><?php echo esc_html($p['year']); ?></div>
        </div>
        <p class="p-desc"><?php echo esc_html($p['description']); ?></p>

        <?php
  $tags = array_map('trim', explode(',', $p['tags']));
  if (!empty($tags[0])): ?>
          <div class="p-tags">
            <?php foreach ($tags as $tag): ?>
              <span class="p-tag"><?php echo esc_html($tag); ?></span>
            <?php
    endforeach; ?>
          </div>
        <?php
  endif; ?>

      </div>

    <?php
endforeach; ?>

  </div>
</section>
