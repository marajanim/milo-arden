<?php
/**
 * Milo Arden — footer.php
 *
 * Closes </main>, renders the footer grid, and fires wp_footer().
 * The CTA / contact section is now loaded separately via
 * template-parts/section-contact.php in front-page.php.
 *
 * @package MiloArden
 */
?>

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
        <p><?php echo esc_html(get_theme_mod('milo_footer_brand_desc', 'Independent design-engineering studio based in New York. Shipping calm, considered software for founders and small teams since 2018.')); ?></p>
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

if (!function_exists('milo_footer_work_fallback')):  function milo_footer_work_fallback()
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
    echo '</ul>';  }
endif;

if (!function_exists('milo_footer_contact_fallback')):  function milo_footer_contact_fallback()
  {
    echo '<ul>';
    $email = get_theme_mod('milo_contact_email', 'hello@milo.studio');
    printf('<li><a href="mailto:%s">%s</a></li>', esc_attr($email), esc_html($email));
    printf('<li><a href="#">%s</a></li>', esc_html__('Book a call', 'milo-arden'));
    printf('<li><a href="#">%s</a></li>', esc_html__('Signal', 'milo-arden'));
    echo '</ul>';  }
endif;

if (!function_exists('milo_footer_elsewhere_fallback')):  function milo_footer_elsewhere_fallback()
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
        esc_url(get_theme_mod($key, '#')),
        esc_html($label)
      );
    }
    echo '</ul>';  }
endif;
