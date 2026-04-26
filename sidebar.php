<?php
/**
 * Milo Arden — sidebar.php
 *
 * Optional sidebar template. Not loaded on the front page.
 * Loaded via get_sidebar() in single.php / page.php if those templates exist.
 *
 * Widget area: 'sidebar-main' — registered in functions.php.
 *
 * @package MiloArden
 */
?>
<?php if (is_active_sidebar('sidebar-main')): ?>
<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e('Sidebar', 'milo-arden'); ?>">
  <?php dynamic_sidebar('sidebar-main'); ?>
</aside>
<?php
endif; ?>
