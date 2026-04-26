<?php
/**
 * Milo Arden — footer.php
 *
 * Closes #main, renders the full footer section,
 * and fires wp_footer() before </body>.
 *
 * @package MiloArden
 */
?>

</main><!-- /#main.site-main -->

<!-- ── CTA / Contact ─────────────────────────────────────────── -->
<div class="cta-wrap" id="contact">
  <section class="cta-card">
    <div class="cta-inner">

      <div class="eyebrow on-dark">
        <span class="dot" aria-hidden="true"></span>
        <?php echo milo_get('milo_cta_eyebrow', 'Ready to start?'); ?>
      </div>

      <h2><?php echo wp_kses_post(get_theme_mod('milo_cta_heading', "Let's build something that matters.")); ?></h2>

      <p class="lede">
        <?php echo milo_get('milo_cta_lede', "I'm currently booking projects for Q3 2026. Drop a line and I'll reply within a day."); ?>
      </p>

      <a href="<?php echo milo_get_url('milo_cta_button_url', 'mailto:hello@milo.studio'); ?>" class="btn">
        <?php echo milo_get('milo_cta_button_label', 'Book a call'); ?>
        <span class="arr" aria-hidden="true">→</span>
      </a>

    </div>
  </section>
</div>

<!-- ── Footer ────────────────────────────────────────────────── -->
<div class="footer-wrap">
  <footer class="footer" role="contentinfo">

    <div class="footer-grid">

      <!-- Brand column -->
      <div class="footer-brand">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="f-logo" rel="home">
          <?php if (has_custom_logo()): ?>
            <?php the_custom_logo(); ?>
          <?php
else: ?>
            <div class="mark" aria-hidden="true">m</div>
            <span><?php bloginfo('name'); ?></span>
          <?php
endif; ?>
        </a>
        <p><?php echo milo_get('milo_footer_brand_desc', 'Independent design-engineering studio based in New York. Shipping calm, considered software for founders and small teams since 2018.'); ?></p>
      </div>

      <!-- Work column -->
      <div class="footer-col">
        <h4><?php esc_html_e('Work', 'milo-arden'); ?></h4>
        <?php
wp_nav_menu(array(
    'theme_location' => 'footer-work',
    'container' => false,
    'depth' => 1,
    'fallback_cb' => 'milo_footer_work_fallback',
));
?>
      </div>

      <!-- Contact column -->
      <div class="footer-col">
        <h4><?php esc_html_e('Contact', 'milo-arden'); ?></h4>
        <?php
wp_nav_menu(array(
    'theme_location' => 'footer-contact',
    'container' => false,
    'depth' => 1,
    'fallback_cb' => 'milo_footer_contact_fallback',
));
?>
      </div>

      <!-- Elsewhere column -->
      <div class="footer-col">
        <h4><?php esc_html_e('Elsewhere', 'milo-arden'); ?></h4>
        <?php
wp_nav_menu(array(
    'theme_location' => 'footer-elsewhere',
    'container' => false,
    'depth' => 1,
    'fallback_cb' => 'milo_footer_elsewhere_fallback',
));
?>
      </div>

    </div><!-- /.footer-grid -->

    <div class="footer-bottom">
      <div>
        <?php
printf(
    /* translators: %1$s = year, %2$s = site name */
    esc_html__('© %1$s %2$s', 'milo-arden'),
    date('Y'),
    esc_html(get_bloginfo('name'))
);
?>
      </div>
      <nav class="socials" aria-label="<?php esc_attr_e('Legal & colophon', 'milo-arden'); ?>">
        <a href="#"><?php esc_html_e('Privacy', 'milo-arden'); ?></a>
        <a href="#"><?php esc_html_e('Terms', 'milo-arden'); ?></a>
        <a href="#"><?php esc_html_e('Colophon', 'milo-arden'); ?></a>
      </nav>
    </div><!-- /.footer-bottom -->

  </footer>
</div><!-- /.footer-wrap -->

<?php wp_footer(); ?>
</body>
</html>

<?php
/* ─── Footer menu fallbacks ─────────────────────────────────── */

function milo_footer_work_fallback()
{
    $links = array(
        '#work' => __('Case studies', 'milo-arden'),
        '#process' => __('Process', 'milo-arden'),
        '#words' => __('Testimonials', 'milo-arden'),
        '#faq' => __('FAQ', 'milo-arden'),
    );
    echo '<ul>';
    foreach ($links as $href => $label) {
        printf('<li><a href="%s">%s</a></li>', esc_url($href), esc_html($label));
    }
    echo '</ul>';
}

function milo_footer_contact_fallback()
{
    $email = milo_get_url('milo_contact_email', 'hello@milo.studio');
    echo '<ul>';
    printf('<li><a href="mailto:%s">%s</a></li>', esc_attr(get_theme_mod('milo_contact_email', 'hello@milo.studio')), esc_html(get_theme_mod('milo_contact_email', 'hello@milo.studio')));
    printf('<li><a href="#">%s</a></li>', esc_html__('Book a call', 'milo-arden'));
    printf('<li><a href="#">%s</a></li>', esc_html__('Signal', 'milo-arden'));
    echo '</ul>';
}

function milo_footer_elsewhere_fallback()
{
    $links = array(
        'milo_social_readcv' => 'Read.cv',
        'milo_social_linkedin' => 'LinkedIn',
        'milo_social_github' => 'Github',
        'milo_social_arena' => 'Are.na',
    );
    echo '<ul>';
    foreach ($links as $key => $label) {
        printf(
            '<li><a href="%s">%s</a></li>',
            milo_get_url($key, '#'),
            esc_html($label)
        );
    }
    echo '</ul>';
}
