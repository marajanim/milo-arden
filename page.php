<?php
/**
 * Milo Arden — page.php
 * Generic page template.
 *
 * @package MiloArden
 */

get_header();
?>

<main id="main" class="site-main page-content" role="main">
  <div class="container">
    <?php while (have_posts()):
    the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>

        <!-- Page header -->
        <header class="page-header reveal">
          <h1 class="page-title"><?php the_title(); ?></h1>
          <?php if (has_post_thumbnail()): ?>
            <div class="page-thumbnail reveal">
              <?php the_post_thumbnail('large'); ?>
            </div>
          <?php
    endif; ?>
        </header>

        <!-- Page body -->
        <div class="page-body reveal">
          <?php the_content(); ?>
          <?php
    wp_link_pages(array(
        'before' => '<nav class="page-links" aria-label="' . esc_attr__('Page sections', 'milo-arden') . '"><span class="page-links-label">' . __('Pages:', 'milo-arden') . '</span>',
        'after' => '</nav>',
        'link_before' => '<span>',
        'link_after' => '</span>',
    ));
?>
        </div>

        <!-- Optional edit link (admin only) -->
        <?php edit_post_link(
        sprintf(
        /* translators: %s: post title */
        __('Edit <span class="screen-reader-text">%s</span>', 'milo-arden'),
        get_the_title()
    ),
        '<footer class="page-edit-link"><span class="eyebrow"><span class="dot" aria-hidden="true"></span>',
        '</span></footer>'
    ); ?>

      </article>

    <?php
endwhile; ?>
  </div>
</main>

<?php
get_sidebar();
get_footer();
