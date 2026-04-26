<?php
/**
 * Section: Testimonials / "Kind Words"
 *
 * Three testimonial cards faithfully ported from the HTML.
 * Includes a commented-out WP_Query block for the milo_testimonial CPT.
 *
 * Expected CPT custom fields (via ACF or register_meta):
 *   - milo_testimonial_company   (text)
 *   - milo_testimonial_name      (text)
 *   - milo_testimonial_role      (text)
 *   - milo_testimonial_avatar    (text class suffix: '', 'b', 'c')
 *
 * @package MiloArden
 */

// Section header — Editable from Customizer
$eyebrow = get_theme_mod('milo_testimonials_eyebrow', 'Kind words');
$heading = get_theme_mod('milo_testimonials_heading', 'Loved by the teams I work with.');
$lede = get_theme_mod('milo_testimonials_lede', "A few lines from founders and collaborators I've shipped with.");

// Hardcoded starter data — replace with WP_Query when CPT is populated
$testimonials = array(
        array(
        'company' => 'Ledger',
        'quote' => 'Milo has the rare ability to hold both ends of a problem at once. They argue system architecture at lunch and push pixels by dinner. The kind of person you build a company around.',
        'name' => 'Elena Vasquez',
        'role' => 'Founder, Ledger',
        'avatar' => '', // CSS gradient variant: '' | 'b' | 'c'
        'delay' => '',
    ),
        array(
        'company' => 'Field Studio',
        'quote' => 'Hundreds of collaborators in my career. Milo sits firmly in the top five. Impeccable taste, structural thinking, and they actually ship the work.',
        'name' => 'Hasan Yüce',
        'role' => 'Principal, Field Studio',
        'avatar' => 'b',
        'delay' => 'd1',
    ),
        array(
        'company' => 'Thread',
        'quote' => 'I gave Milo a half-formed brief and an impossible deadline. They returned something better than I could have specified. Then made it faster.',
        'name' => 'Priya Srinivasan',
        'role' => 'Head of Product, Thread',
        'avatar' => 'c',
        'delay' => 'd2',
    ),
);
?>

<section class="section" id="words">
  <div class="section-head reveal">
    <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php echo esc_html($eyebrow); ?></div>
    <h2><?php echo esc_html($heading); ?></h2>
    <p class="lede"><?php echo esc_html($lede); ?></p>
  </div>

  <div class="test-grid">

    <?php
/**
 * Dynamic loop — uncomment when milo_testimonial CPT has data:
 *
 * $tq = new WP_Query( array(
 *     'post_type'      => 'milo_testimonial',
 *     'posts_per_page' => 3,
 *     'orderby'        => 'menu_order',
 *     'order'          => 'ASC',
 * ) );
 * $delays = array( '', 'd1', 'd2' );
 * $idx    = 0;
 * if ( $tq->have_posts() ) :
 *   while ( $tq->have_posts() ) : $tq->the_post();
 *     $company = get_post_meta( get_the_ID(), 'milo_testimonial_company', true );
 *     $name    = get_post_meta( get_the_ID(), 'milo_testimonial_name', true );
 *     $role    = get_post_meta( get_the_ID(), 'milo_testimonial_role', true );
 *     $avatar  = get_post_meta( get_the_ID(), 'milo_testimonial_avatar', true );
 *     $delay   = $delays[ $idx ] ?? '';
 *     // ... render .t-card ...
 *     $idx++;
 *   endwhile;
 *   wp_reset_postdata();
 * endif;
 */
?>

    <?php foreach ($testimonials as $t): ?>
      <div class="t-card reveal <?php echo esc_attr($t['delay']); ?>">
        <div class="logo"><?php echo esc_html($t['company']); ?></div>
        <p class="txt"><?php echo esc_html($t['quote']); ?></p>
        <div class="who">
          <div class="avatar <?php echo esc_attr($t['avatar']); ?>" aria-hidden="true"></div>
          <div class="info">
            <strong><?php echo esc_html($t['name']); ?></strong>
            <span><?php echo esc_html($t['role']); ?></span>
          </div>
        </div>
      </div>
    <?php
endforeach; ?>

  </div>
</section>
