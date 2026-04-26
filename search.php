<?php
/**
 * Milo Arden — search.php
 * Search results page.
 *
 * @package MiloArden
 */

get_header();
?>

<main id="main" class="site-main search-content" role="main">
  <div class="container">

    <!-- Search header -->
    <header class="archive-header section-head reveal">
      <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Search results', 'milo-arden'); ?></div>
      <h1>
        <?php
printf(
    /* translators: %s: search query */
    esc_html__('Results for: %s', 'milo-arden'),
    '<mark class="search-term">' . esc_html(get_search_query()) . '</mark>'
);
?>
      </h1>
      <?php if (have_posts()): ?>
        <p class="lede">
          <?php
    printf(
        /* translators: %d: result count */
        esc_html(_n('%d result found.', '%d results found.', (int)$wp_query->found_posts, 'milo-arden')),
        (int)$wp_query->found_posts
    );
?>
        </p>
      <?php
endif; ?>

      <!-- Inline search refinement -->
      <div class="search-refine" style="margin-top:24px;">
        <?php get_search_form(); ?>
      </div>
    </header>

    <?php if (have_posts()): ?>

      <div class="archive-grid">
        <?php while (have_posts()):
        the_post(); ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class('archive-card reveal'); ?>>

            <?php if (has_post_thumbnail()): ?>
              <a class="archive-thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                <?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
              </a>
            <?php
        endif; ?>

            <div class="archive-card-body">
              <div class="archive-meta eyebrow">
                <span class="dot" aria-hidden="true"></span>
                <span class="post-type-label"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></span>
                &nbsp;·&nbsp;
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
              </div>
              <h2 class="archive-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>
              <?php if (has_excerpt()): ?>
                <p class="archive-excerpt"><?php the_excerpt(); ?></p>
              <?php
        endif; ?>
              <a class="btn ghost archive-read" href="<?php the_permalink(); ?>">
                <?php esc_html_e('View', 'milo-arden'); ?>
                <span class="arr" aria-hidden="true">→</span>
              </a>
            </div>

          </article>

        <?php
    endwhile; ?>
      </div>

      <!-- Pagination -->
      <nav class="archive-pagination reveal" aria-label="<?php esc_attr_e('Search results pages', 'milo-arden'); ?>">
        <?php
    the_posts_pagination(array(
        'mid_size' => 2,
        'prev_text' => '← ' . __('Previous', 'milo-arden'),
        'next_text' => __('Next', 'milo-arden') . ' →',
    ));
?>
      </nav>

    <?php
else: ?>

      <div class="no-results reveal" style="text-align:center; padding: 60px 0;">
        <p class="lede" style="margin-bottom:28px;">
          <?php
    printf(
        /* translators: %s: search query */
        esc_html__('Nothing matched "%s". Try a different search.', 'milo-arden'),
        esc_html(get_search_query())
    );
?>
        </p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn ghost">
          <?php esc_html_e('Back home', 'milo-arden'); ?>
          <span class="arr" aria-hidden="true">→</span>
        </a>
      </div>

    <?php
endif; ?>

  </div>
</main>

<?php
get_sidebar();
get_footer();
