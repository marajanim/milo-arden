<?php
/**
 * Milo Arden — archive.php
 * Blog listing / archive page.
 *
 * @package MiloArden
 */

get_header();
?>

<main id="main" class="site-main archive-content" role="main">
  <div class="container">

    <!-- Archive header -->
    <header class="archive-header section-head reveal">
      <?php if (is_home() && !is_front_page()): ?>
        <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Blog', 'milo-arden'); ?></div>
        <h1><?php single_post_title(); ?></h1>

      <?php
elseif (is_category()): ?>
        <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Category', 'milo-arden'); ?></div>
        <h1><?php single_cat_title(); ?></h1>
        <?php if (category_description()): ?>
          <p class="lede"><?php echo wp_kses_post(category_description()); ?></p>
        <?php
    endif; ?>

      <?php
elseif (is_tag()): ?>
        <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Tag', 'milo-arden'); ?></div>
        <h1><?php single_tag_title(); ?></h1>
        <?php if (tag_description()): ?>
          <p class="lede"><?php echo wp_kses_post(tag_description()); ?></p>
        <?php
    endif; ?>

      <?php
elseif (is_author()): ?>
        <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Author', 'milo-arden'); ?></div>
        <h1><?php the_author(); ?></h1>
        <?php $author_desc = get_the_author_meta('description'); ?>
        <?php if ($author_desc): ?>
          <p class="lede"><?php echo esc_html($author_desc); ?></p>
        <?php
    endif; ?>

      <?php
elseif (is_year()): ?>
        <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Archive', 'milo-arden'); ?></div>
        <h1><?php echo esc_html(get_the_date('Y')); ?></h1>

      <?php
elseif (is_month()): ?>
        <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Archive', 'milo-arden'); ?></div>
        <h1><?php echo esc_html(get_the_date('F Y')); ?></h1>

      <?php
else: ?>
        <div class="eyebrow"><span class="dot" aria-hidden="true"></span> <?php esc_html_e('Archive', 'milo-arden'); ?></div>
        <h1><?php the_archive_title(); ?></h1>
      <?php
endif; ?>
    </header><!-- /.archive-header -->

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
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                <?php if (has_category()): ?>
                  &nbsp;·&nbsp; <?php the_category(', '); ?>
                <?php
        endif; ?>
              </div>

              <h2 class="archive-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>

              <?php if (has_excerpt()): ?>
                <p class="archive-excerpt"><?php the_excerpt(); ?></p>
              <?php
        endif; ?>

              <a class="btn ghost archive-read" href="<?php the_permalink(); ?>">
                <?php esc_html_e('Read more', 'milo-arden'); ?>
                <span class="arr" aria-hidden="true">→</span>
              </a>
            </div>

          </article>

        <?php
    endwhile; ?>
      </div><!-- /.archive-grid -->

      <!-- Pagination -->
      <nav class="archive-pagination reveal" aria-label="<?php esc_attr_e('Posts navigation', 'milo-arden'); ?>">
        <?php
    the_posts_pagination(array(
        'mid_size' => 2,
        'prev_text' => '← ' . __('Newer', 'milo-arden'),
        'next_text' => __('Older', 'milo-arden') . ' →',
    ));
?>
      </nav>

    <?php
else: ?>

      <div class="no-results reveal">
        <p class="lede"><?php esc_html_e('Nothing here yet.', 'milo-arden'); ?></p>
      </div>

    <?php
endif; ?>

  </div>
</main>

<?php
get_sidebar();
get_footer();
