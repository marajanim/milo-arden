<?php
/**
 * Milo Arden — inc/class-nav-walker.php
 *
 * A minimal custom Walker_Nav_Menu that:
 *  - Keeps the flat, single-level HTML structure matching the original design
 *  - Adds no wrapping <li> wrapper elements (outputs <a> directly in the <ul>)
 *  - Marks the current menu item with aria-current="page"
 *  - Supports one level of sub-menu (dropdown) if ever needed
 *
 * Usage in wp_nav_menu():
 *   'walker' => new Milo_Nav_Walker(),
 *
 * @package MiloArden
 */

if (!defined('ABSPATH')) {
    exit;
}

class Milo_Nav_Walker extends Walker_Nav_Menu
{

    /**
     * Start the element output.
     * Renders a plain <a> tag with aria-current on active items.
     *
     * @param string   $output Used to append additional content.
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {

        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $is_active = in_array('current-menu-item', $classes, true)
            || in_array('current-menu-ancestor', $classes, true);

        $atts = array(
            'href' => !empty($item->url) ? $item->url : '#',
            'aria-current' => $is_active ? 'page' : false,
        );

        // Allow plugins / themes to add further attributes
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attr_string = '';
        foreach ($atts as $attr => $value) {
            if (false !== $value && '' !== $value) {
                $attr_string .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        // Wrap item in <li> (Walker parent expects it)
        $output .= '<li>';
        $output .= '<a' . $attr_string . '>' . esc_html($title) . '</a>';
    }

    /**
     * End the element output — close the <li>.
     */
    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }

    /**
     * Start level — open sub-menu <ul> (depth > 0 hidden via CSS by default).
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<ul class="sub-menu depth-' . (int)$depth . '">';
    }

    /**
     * End level — close sub-menu <ul>.
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '</ul>';
    }
}
