<?php
/**
 * Milo Arden — single.php
 * Single blog post template.
 *
 * @package MiloArden
 */

get_header();
?>

<main id="main" class="site-main post-content" role="main">
  <div class="container">
    <?php while (have_posts()):
    the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class('single-article'); ?>>

        <!-- Post header -->
        <header class="post-header reveal">
          <div class="post-meta">
            <span class="eyebrow">
              <span class="dot" aria-hidden="true"></span>
              <?php echo esc_html(get_the_date()); ?>
              <?php if (has_category()): ?>
                &nbsp;·&nbsp;
                <?php the_category(', '); ?>
              <?php
    endif; ?>
            </span>
          </div>
          <h1 class="post-title"><?php the_title(); ?></h1>
          <?php if (has_excerpt()): ?>
            <p class="lede post-excerpt"><?php the_excerpt(); ?></p>
          <?php
    endif; ?>
        </header>

        <!-- Featured image -->
        <?php if (has_post_thumbnail()): ?>
          <div class="post-thumbnail reveal">
            <?php the_post_thumbnail('large', array('loading' => 'eager')); ?>
          </div>
        <?php
    endif; ?>

        <!-- Post body -->
        <div class="post-body entry-content reveal">
          <?php the_content(); ?>
          <?php
    wp_link_pages(array(
        'before' => '<nav class="page-links" aria-label="' . esc_attr__('Post pages', 'milo-arden') . '">',
        'after' => '</nav>',
    ));
?>
        </div>

        <!-- Post footer: tags + author -->
        <footer class="post-footer reveal">
          <?php if (has_tag()): ?>
            <div class="post-tags">
              <?php the_tags('<span class="tags-label eyebrow"><span class="dot" aria-hidden="true"></span>' . __('Tagged:', 'milo-arden') . '&nbsp;</span>', ', ', ''); ?>
            </div>
          <?php
    endif; ?>

          <div class="post-author-card">
            <?php echo get_avatar(get_the_author_meta('ID'), 48, '', get_the_author(), array('class' => 'author-avatar')); ?>
            <div class="author-info">
              <strong><?php the_author(); ?></strong>
              <span><?php echo esc_html(get_the_author_meta('description') ?: __('Author', 'milo-arden')); ?></span>
            </div>
          </div>

          <?php edit_post_link(
        __('Edit post', 'milo-arden'),
        '<span class="edit-link eyebrow"><span class="dot" aria-hidden="true"></span>',
        '</span>'
    ); ?>
        </footer>

        <!-- Post navigation -->
        <nav class="post-nav reveal" aria-label="<?php esc_attr_e('Post navigation', 'milo-arden'); ?>">
          <?php
    the_post_navigation(array(
        'prev_text' => '<span class="post-nav-dir">' . __('Previous', 'milo-arden') . '</span><span class="post-nav-title">%title</span>',
        'next_text' => '<span class="post-nav-dir">' . __('Next', 'milo-arden') . '</span><span class="post-nav-title">%title</span>',
    ));
?>
        </nav>

      </article>

      <!-- Comments -->
      <?php if (comments_open() || get_comments_number()): ?>
        <?php comments_template(); ?>
      <?php
    endif; ?>

    <?php
endwhile; ?>
  </div>
</main>

<?php
get_sidebar();
get_footer();
