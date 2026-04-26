<?php
/**
 * Milo Arden — comments.php
 * Comments list + form template.
 * Loaded via comments_template() in single.php.
 *
 * @package MiloArden
 */

/*
 * If the current post is password-protected and the comment form requires
 * approval, don't show anything.
 */
if (post_password_required()) {
    return;
}
?>

<section id="comments" class="comments-area reveal">

  <?php if (have_comments()): ?>
    <header class="comments-header">
      <div class="eyebrow"><span class="dot" aria-hidden="true"></span>
        <?php
    printf(
        /* translators: %d: comment count */
        esc_html(_n('%d Comment', '%d Comments', get_comments_number(), 'milo-arden')),
        number_format_i18n(get_comments_number())
    );
?>
      </div>
    </header>

    <ol class="comment-list">
      <?php
    wp_list_comments(array(
        'style' => 'ol',
        'short_ping' => true,
        'avatar_size' => 40,
        'callback' => 'milo_comment_template',
    ));
?>
    </ol>

    <?php
    // Comment navigation for paginated comments
    the_comments_navigation(array(
        'prev_text' => '← ' . __('Older comments', 'milo-arden'),
        'next_text' => __('Newer comments', 'milo-arden') . ' →',
    ));
?>
  <?php
endif; ?>

  <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')): ?>
    <p class="no-comments lede"><?php esc_html_e('Comments are closed.', 'milo-arden'); ?></p>
  <?php
endif; ?>

  <!-- Comment form -->
  <?php
comment_form(array(
    'title_reply' => __('Leave a reply', 'milo-arden'),
    'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title"><div class="eyebrow"><span class="dot" aria-hidden="true"></span>',
    'title_reply_after' => '</div></h3>',
    'cancel_reply_link' => __('Cancel reply', 'milo-arden'),
    'label_submit' => __('Post comment', 'milo-arden'),
    'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s btn">%4$s <span class="arr" aria-hidden="true">→</span></button>',
    'class_submit' => 'submit',
    'comment_notes_before' => '',
    'comment_notes_after' => '',
));
?>

</section>

<?php
/**
 * Custom comment template callback.
 * Outputs a single comment styled to match the testimonial card aesthetic.
 *
 * @param WP_Comment $comment Comment object.
 * @param array      $args    Comment list args.
 * @param int        $depth   Comment depth.
 */
function milo_comment_template($comment, $args, $depth)
{
    $tag = ('li' === $args['style']) ? 'li' : 'li';
?>
  <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('t-card comment-card', $comment); ?>>
    <article class="comment-body">

      <div class="comment-author who">
        <div class="avatar" aria-hidden="true">
          <?php echo get_avatar($comment, $args['avatar_size']); ?>
        </div>
        <div class="info">
          <strong><?php comment_author_link($comment); ?></strong>
          <span>
            <time datetime="<?php comment_date('c'); ?>"><?php comment_date(); ?></time>
            <?php if ('0' === $comment->comment_approved): ?>
              &nbsp; <em class="comment-awaiting"><?php esc_html_e('Awaiting moderation', 'milo-arden'); ?></em>
            <?php
    endif; ?>
          </span>
        </div>
        <?php
    comment_reply_link(array_merge($args, array(
        'depth' => $depth,
        'max_depth' => $args['max_depth'],
        'before' => '<span class="reply-link">',
        'after' => '</span>',
    )));
?>
      </div>

      <div class="comment-content txt">
        <?php comment_text(); ?>
      </div>

    </article>
  <?php // Closing tag handled by wp_list_comments
}
