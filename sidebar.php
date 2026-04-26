<?php
/**
 * Milo Arden — sidebar.php
 *
 * Widget area template. Loaded via get_sidebar() from page.php,
 * single.php, archive.php, and search.php.
 * Only renders if widgets are actually assigned in Appearances → Widgets.
 *
 * Widget area ID: 'sidebar-main' — registered in functions.php.
 *
 * @package MiloArden
 */

if (!is_active_sidebar('sidebar-main')) {
    return;
}
?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e('Sidebar', 'milo-arden'); ?>">
  <?php dynamic_sidebar('sidebar-main'); ?>
</aside>
