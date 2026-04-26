<?php
/**
 * Milo Arden — 404.php
 * Custom "Not Found" page.
 *
 * @package MiloArden
 */

get_header();
?>

<main id="main" class="site-main error-404-content" role="main">

  <div class="stats-dark error-404-card">
    <div class="stats-inner error-404-inner">

      <div class="stats-head reveal">
        <div class="eyebrow on-dark">
          <span class="dot" aria-hidden="true"></span>
          <?php esc_html_e('404 — Not Found', 'milo-arden'); ?>
        </div>
        <h1 style="color:#fff; font-size: clamp(64px,12vw,140px); letter-spacing:-0.05em; line-height:1; margin: 16px 0 24px;">
          404
        </h1>
        <p class="lede" style="color:rgba(255,255,255,0.7); max-width:48ch; margin: 0 auto 36px;">
          <?php esc_html_e('The page you\'re looking for has moved, been renamed, or never existed. Try the search below, or head home.', 'milo-arden'); ?>
        </p>
      </div>

      <!-- Search form -->
      <div class="error-404-search reveal">
        <?php get_search_form(); ?>
      </div>

      <!-- Home CTA -->
      <div class="cta-row reveal" style="justify-content:center; margin-top: 32px;">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn">
          <?php esc_html_e('Back home', 'milo-arden'); ?>
          <span class="arr" aria-hidden="true">→</span>
        </a>
      </div>

    </div>
  </div>

</main>

<?php get_footer(); ?>
