<?php
/**
 * Milo Arden — One-Click Demo Importer
 *
 * Registers an admin page under Appearance → Import Demo Data.
 * Provides AJAX-driven import of:
 *   1. XML content (pages, posts, menus) via WP_Import
 *   2. Widgets
 *   3. Customizer settings (theme_mods)
 *   4. ACF repeater field values
 *   5. Reading settings + menu locations + rewrite flush
 *
 * Also provides an "undo" action that removes all imported content.
 *
 * @package MiloArden
 */

if (!defined('ABSPATH')) {
    exit;
}

class Milo_Demo_Importer
{

    /** @var string Path to the demo/ directory inside the theme. */
    private $demo_dir;

    /** @var string Option key that stores IDs of imported content for undo. */
    const UNDO_KEY = 'milo_demo_imported_ids';

    /** @var array Runtime map of original filename => new attachment ID. */
    private $attachment_map = array();

    /* ================================================================
     BOOTSTRAP
     ================================================================ */

    public function __construct()
    {
        $this->demo_dir = MILO_DIR . '/demo';

        add_action('admin_menu', array($this, 'register_page'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_ajax_milo_import_demo', array($this, 'ajax_import'));
        add_action('wp_ajax_milo_undo_demo', array($this, 'ajax_undo'));
    }

    /* ================================================================
     ADMIN PAGE
     ================================================================ */

    /**
     * Register the submenu page under Appearance.
     */
    public function register_page()
    {
        add_theme_page(
            __('Import Demo Data', 'milo-arden'),
            __('Import Demo Data', 'milo-arden'),
            'manage_options',
            'milo-demo-import',
            array($this, 'render_page')
        );
    }

    /**
     * Enqueue JS + inline CSS only on our admin page.
     */
    public function enqueue_assets($hook)
    {
        if ('appearance_page_milo-demo-import' !== $hook) {
            return;
        }

        wp_enqueue_script(
            'milo-demo-import',
            MILO_URI . '/assets/js/demo-import.js',
            array('jquery'),
            MILO_VERSION,
            true
        );

        wp_localize_script('milo-demo-import', 'miloDemoImport', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'importNonce' => wp_create_nonce('milo_import_demo'),
            'undoNonce' => wp_create_nonce('milo_undo_demo'),
            'siteUrl' => home_url('/'),
            'strings' => array(
                'confirm' => __('This will import demo content and may overwrite existing settings. Continue?', 'milo-arden'),
                'confirmUndo' => __('This will delete ALL imported demo content. This cannot be undone. Continue?', 'milo-arden'),
                'importing' => __('Importing…', 'milo-arden'),
                'complete' => __('Demo imported successfully!', 'milo-arden'),
                'failed' => __('Import encountered errors. Check the log below.', 'milo-arden'),
                'undoing' => __('Removing demo content…', 'milo-arden'),
                'undone' => __('Demo content removed.', 'milo-arden'),
            ),
        ));
    }

    /**
     * Render the admin page HTML.
     */
    public function render_page()
    {
        $has_imported = (bool)get_option(self::UNDO_KEY, false);
        $screenshot = MILO_URI . '/screenshot.png';
?>
		<div class="wrap milo-demo-wrap">
			<h1><?php esc_html_e('Import Demo Data', 'milo-arden'); ?></h1>

			<div class="milo-demo-card">

				<!-- Preview -->
				<div class="milo-demo-preview">
					<img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Demo preview', 'milo-arden'); ?>" />
				</div>

				<!-- Warning -->
				<div class="milo-demo-notice notice notice-warning inline">
					<p>
						<strong><?php esc_html_e('⚠ Warning:', 'milo-arden'); ?></strong>
						<?php esc_html_e('Importing demo data will add pages, posts, menus, widgets, and Customizer settings. It is recommended to use this on a fresh WordPress installation.', 'milo-arden'); ?>
					</p>
				</div>

				<!-- Checkboxes -->
				<fieldset class="milo-demo-options">
					<legend><?php esc_html_e('Choose what to import:', 'milo-arden'); ?></legend>
					<label><input type="checkbox" name="milo_import[]" value="content"    checked /> <?php esc_html_e('Content (pages, posts, attachments)', 'milo-arden'); ?></label>
					<label><input type="checkbox" name="milo_import[]" value="widgets"    checked /> <?php esc_html_e('Widgets', 'milo-arden'); ?></label>
					<label><input type="checkbox" name="milo_import[]" value="customizer" checked /> <?php esc_html_e('Customizer Settings', 'milo-arden'); ?></label>
					<label><input type="checkbox" name="milo_import[]" value="acf"        checked /> <?php esc_html_e('ACF Data (repeater fields)', 'milo-arden'); ?></label>
					<label><input type="checkbox" name="milo_import[]" value="menus"      checked /> <?php esc_html_e('Menus', 'milo-arden'); ?></label>
					<label><input type="checkbox" name="milo_import[]" value="homepage"   checked /> <?php esc_html_e('Set Homepage (static front page)', 'milo-arden'); ?></label>
				</fieldset>

				<!-- Buttons -->
				<div class="milo-demo-actions">
					<button id="milo-import-btn" class="button button-primary button-hero">
						<?php esc_html_e('🚀 Import Demo Data', 'milo-arden'); ?>
					</button>

					<?php if ($has_imported): ?>
						<button id="milo-undo-btn" class="button button-link-delete">
							<?php esc_html_e('↩ Undo / Remove Demo Content', 'milo-arden'); ?>
						</button>
					<?php
        endif; ?>
				</div>

				<!-- Progress -->
				<div id="milo-progress" class="milo-demo-progress" style="display:none;">
					<div class="milo-progress-bar-wrap">
						<div id="milo-progress-bar" class="milo-progress-bar" style="width:0%"></div>
					</div>
					<div id="milo-progress-log" class="milo-progress-log"></div>
				</div>

				<!-- Visit Site (shown after success) -->
				<div id="milo-complete" style="display:none;">
					<a id="milo-visit-site" href="<?php echo esc_url(home_url('/')); ?>" class="button button-primary button-hero" target="_blank">
						<?php esc_html_e('🎉 Visit Site', 'milo-arden'); ?>
					</a>
				</div>

			</div><!-- /.milo-demo-card -->

			<style>
				.milo-demo-wrap { max-width: 720px; }
				.milo-demo-card { background: #fff; border: 1px solid #c3c4c7; border-radius: 8px; padding: 28px; margin-top: 20px; }
				.milo-demo-preview { margin-bottom: 20px; border-radius: 6px; overflow: hidden; border: 1px solid #ddd; }
				.milo-demo-preview img { width: 100%; height: auto; display: block; }
				.milo-demo-options { margin: 20px 0; }
				.milo-demo-options legend { font-weight: 600; margin-bottom: 10px; }
				.milo-demo-options label { display: block; margin-bottom: 6px; cursor: pointer; }
				.milo-demo-actions { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin: 24px 0 0; }
				.milo-demo-progress { margin-top: 24px; }
				.milo-progress-bar-wrap { background: #f0f0f1; border-radius: 999px; height: 20px; overflow: hidden; }
				.milo-progress-bar { height: 100%; background: linear-gradient(90deg, #0E2B1A, #C6F25D); border-radius: 999px; transition: width 0.4s ease; }
				.milo-progress-log { margin-top: 16px; max-height: 260px; overflow-y: auto; font-family: monospace; font-size: 12px; line-height: 1.6; background: #f6f7f7; border: 1px solid #ddd; border-radius: 4px; padding: 12px; }
				.milo-progress-log .step-ok { color: #0e2b1a; }
				.milo-progress-log .step-err { color: #d63638; }
				.milo-progress-log .step-info { color: #666; }
				#milo-complete { margin-top: 20px; text-align: center; }
			</style>
		</div>
		<?php
    }

    /* ================================================================
     AJAX — IMPORT
     ================================================================ */

    /**
     * Main AJAX import handler. Runs selected steps sequentially,
     * reports progress as a JSON response.
     */
    public function ajax_import()
    {
        check_ajax_referer('milo_import_demo', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'milo-arden'));
        }

        // Increase limits for large imports
        @set_time_limit(300);
        wp_raise_memory_limit('admin');

        $steps = isset($_POST['steps']) ? array_map('sanitize_text_field', (array)$_POST['steps']) : array();
        $log = array();
        $errors = 0;
        $ids = get_option(self::UNDO_KEY, array());
        if (!is_array($ids)) {
            $ids = array();
        }

        // Step 1 — Content (XML)
        if (in_array('content', $steps, true)) {
            $result = $this->import_content();
            $log = array_merge($log, $result['log']);
            if (!empty($result['ids'])) {
                $ids = array_merge($ids, $result['ids']);
            }
            if ($result['error']) {
                $errors++;
            }
        }

        // Step 1b — Local images (always runs when content is selected)
        if (in_array('content', $steps, true)) {
            $result = $this->import_images();
            $log = array_merge($log, $result['log']);
            if (!empty($result['ids'])) {
                $ids = array_merge($ids, $result['ids']);
            }
            if ($result['error']) {
                $errors++;
            }

            // Step 1c — Set featured images
            $result = $this->set_featured_images();
            $log = array_merge($log, $result['log']);
            if ($result['error']) {
                $errors++;
            }
        }

        // Step 2 — Widgets
        if (in_array('widgets', $steps, true)) {
            $result = $this->import_widgets();
            $log = array_merge($log, $result['log']);
            if ($result['error']) {
                $errors++;
            }
        }

        // Step 3 — Customizer
        if (in_array('customizer', $steps, true)) {
            $result = $this->import_customizer();
            $log = array_merge($log, $result['log']);
            if ($result['error']) {
                $errors++;
            }
        }

        // Step 4 — ACF Fields
        if (in_array('acf', $steps, true)) {
            $result = $this->import_acf();
            $log = array_merge($log, $result['log']);
            if ($result['error']) {
                $errors++;
            }
        }

        // Step 5 — Menus
        if (in_array('menus', $steps, true)) {
            $result = $this->assign_menus();
            $log = array_merge($log, $result['log']);
            if ($result['error']) {
                $errors++;
            }
        }

        // Step 6 — Homepage settings
        if (in_array('homepage', $steps, true)) {
            $result = $this->set_homepage();
            $log = array_merge($log, $result['log']);
            if ($result['error']) {
                $errors++;
            }
        }

        // Flush rewrite rules
        flush_rewrite_rules();
        $log[] = array('type' => 'ok', 'msg' => __('Rewrite rules flushed.', 'milo-arden'));

        // Save IDs for undo
        update_option(self::UNDO_KEY, $ids);

        wp_send_json_success(array(
            'log' => $log,
            'errors' => $errors,
        ));
    }

    /* ================================================================
     STEP 1 — XML CONTENT
     ================================================================ */

    private function import_content()
    {
        $log = array();
        $ids = array();
        $error = false;
        $file = $this->demo_dir . '/demo-content.xml';

        if (!file_exists($file)) {
            return array('log' => array(array('type' => 'err', 'msg' => __('demo-content.xml not found.', 'milo-arden'))), 'ids' => array(), 'error' => true);
        }

        // Ensure WP Importer is available
        if (!class_exists('WP_Import')) {
            $log[] = array('type' => 'info', 'msg' => __('WordPress Importer not found. Attempting install…', 'milo-arden'));

            $installed = $this->install_wp_importer();
            if (is_wp_error($installed)) {
                $log[] = array('type' => 'err', 'msg' => sprintf(__('Could not install WP Importer: %s', 'milo-arden'), $installed->get_error_message()));
                $log[] = array('type' => 'info', 'msg' => __('Falling back to manual XML parsing…', 'milo-arden'));

                // Fallback: manual parse
                $manual = $this->manual_import_xml($file);
                return array('log' => array_merge($log, $manual['log']), 'ids' => $manual['ids'], 'error' => $manual['error']);
            }
            $log[] = array('type' => 'ok', 'msg' => __('WordPress Importer installed and loaded.', 'milo-arden'));
        }

        // Run WP_Import
        if (class_exists('WP_Import')) {
            $log[] = array('type' => 'info', 'msg' => __('Importing XML content…', 'milo-arden'));

            $importer = new WP_Import();
            $importer->fetch_attachments = true;

            // Capture output
            ob_start();
            $importer->import($file);
            $output = ob_get_clean();

            // Collect imported post IDs
            if (!empty($importer->processed_posts)) {
                $ids = array_merge($ids, array_values($importer->processed_posts));
            }
            if (!empty($importer->processed_terms)) {
            // store term IDs separately for undo
            }

            $count = count($ids);
            $log[] = array('type' => 'ok', 'msg' => sprintf(__('XML import complete — %d items imported.', 'milo-arden'), $count));
        }
        else {
            // use manual fallback
            $manual = $this->manual_import_xml($file);
            $log = array_merge($log, $manual['log']);
            $ids = $manual['ids'];
            $error = $manual['error'];
        }

        return array('log' => $log, 'ids' => $ids, 'error' => $error);
    }

    /**
     * Attempt to install and activate the WordPress Importer plugin silently.
     *
     * @return true|WP_Error
     */
    private function install_wp_importer()
    {
        include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader-skin.php';

        $api = plugins_api('plugin_information', array(
            'slug' => 'wordpress-importer',
            'fields' => array('sections' => false),
        ));

        if (is_wp_error($api)) {
            return $api;
        }

        $skin = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader($skin);
        $result = $upgrader->install($api->download_link);

        if (is_wp_error($result)) {
            return $result;
        }

        // Activate
        $activate = activate_plugin('wordpress-importer/wordpress-importer.php');
        if (is_wp_error($activate)) {
            return $activate;
        }

        // Load the class
        $plugin_file = WP_PLUGIN_DIR . '/wordpress-importer/wordpress-importer.php';
        if (file_exists($plugin_file)) {
            require_once $plugin_file;
        }

        // Try loading the class file directly
        $class_file = WP_PLUGIN_DIR . '/wordpress-importer/class-wp-import.php';
        if (file_exists($class_file) && !class_exists('WP_Import')) {
            require_once $class_file;
        }

        return true;
    }

    /**
     * Manual XML import fallback — parses WXR and creates posts/pages directly.
     * Used when the WordPress Importer plugin can't be installed.
     */
    private function manual_import_xml($file)
    {
        $log = array();
        $ids = array();
        $error = false;

        $log[] = array('type' => 'info', 'msg' => __('Parsing XML manually…', 'milo-arden'));

        $xml = simplexml_load_file($file, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (!$xml) {
            return array('log' => array(array('type' => 'err', 'msg' => __('Could not parse XML file.', 'milo-arden'))), 'ids' => array(), 'error' => true);
        }

        $ns = array(
            'content' => 'http://purl.org/rss/1.0/modules/content/',
            'excerpt' => 'http://wordpress.org/export/1.2/excerpt/',
            'wp' => 'http://wordpress.org/export/1.2/',
            'dc' => 'http://purl.org/dc/elements/1.1/',
        );

        // Import categories
        foreach ($xml->channel->children($ns['wp']) as $name => $node) {
            if ('category' === $name) {
                $cat_name = (string)$node->children($ns['wp'])->cat_name;
                $cat_slug = (string)$node->children($ns['wp'])->category_nicename;
                if (!term_exists($cat_slug, 'category')) {
                    wp_insert_term($cat_name, 'category', array('slug' => $cat_slug));
                }
            }
            if ('tag' === $name) {
                $tag_name = (string)$node->children($ns['wp'])->tag_name;
                $tag_slug = (string)$node->children($ns['wp'])->tag_slug;
                if (!term_exists($tag_slug, 'post_tag')) {
                    wp_insert_term($tag_name, 'post_tag', array('slug' => $tag_slug));
                }
            }
        }

        // Import items (pages, posts, skip nav_menu_items for now)
        foreach ($xml->channel->item as $item) {
            $wp = $item->children($ns['wp']);
            $post_type = (string)$wp->post_type;

            if ('nav_menu_item' === $post_type) {
                continue; // Menus handled separately
            }

            $title = (string)$item->title;
            $slug = (string)$wp->post_name;
            $status = (string)$wp->status;
            $content = (string)$item->children($ns['content'])->encoded;
            $excerpt = (string)$item->children($ns['excerpt'])->encoded;
            $date = (string)$wp->post_date;

            // Check if already exists
            $existing = get_page_by_path($slug, OBJECT, $post_type);
            if ($existing) {
                $ids[] = $existing->ID;
                $log[] = array('type' => 'info', 'msg' => sprintf(__('Skipped (exists): %s', 'milo-arden'), $title));
                continue;
            }

            $post_data = array(
                'post_title' => $title,
                'post_name' => $slug,
                'post_content' => $content,
                'post_excerpt' => $excerpt,
                'post_status' => $status,
                'post_type' => $post_type,
                'post_date' => $date,
                'post_author' => get_current_user_id(),
            );

            // Assign categories/tags
            $cats = array();
            $tags = array();
            foreach ($item->category as $cat) {
                $domain = (string)$cat['domain'];
                $slug_c = (string)$cat['nicename'];
                if ('category' === $domain) {
                    $term = get_term_by('slug', $slug_c, 'category');
                    if ($term) {
                        $cats[] = $term->term_id;
                    }
                }
                elseif ('post_tag' === $domain) {
                    $tags[] = (string)$cat;
                }
            }
            if ($cats) {
                $post_data['post_category'] = $cats;
            }
            if ($tags) {
                $post_data['tags_input'] = $tags;
            }

            $new_id = wp_insert_post($post_data, true);

            if (is_wp_error($new_id)) {
                $log[] = array('type' => 'err', 'msg' => sprintf(__('Failed: %s — %s', 'milo-arden'), $title, $new_id->get_error_message()));
                $error = true;
            }
            else {
                $ids[] = $new_id;
                $log[] = array('type' => 'ok', 'msg' => sprintf(__('Imported: %s (ID %d)', 'milo-arden'), $title, $new_id));

                // Set page template meta if present
                foreach ($wp->children($ns['wp']) as $meta_key_name => $meta_node) {
                    if ('meta_key' === $meta_key_name) {
                        $meta_key = (string)$meta_node;
                    }
                    if ('meta_value' === $meta_key_name && !empty($meta_key)) {
                        update_post_meta($new_id, $meta_key, (string)$meta_node);
                        $meta_key = '';
                    }
                }
            }
        }

        $log[] = array('type' => 'ok', 'msg' => sprintf(__('Manual import complete — %d items.', 'milo-arden'), count($ids)));

        return array('log' => $log, 'ids' => $ids, 'error' => $error);
    }

    /* ================================================================
     STEP 1b — LOCAL IMAGE IMPORT
     ================================================================ */

    /**
     * Import demo images from the bundled demo/images/ folder into
     * the WordPress media library. Builds $this->attachment_map
     * for later use by featured-image and Customizer logo steps.
     */
    private function import_images()
    {
        $log = array();
        $ids = array();
        $error = false;
        $dir = $this->demo_dir . '/images';

        if (!is_dir($dir)) {
            $log[] = array('type' => 'info', 'msg' => __('No demo/images/ folder found — skipping local image import.', 'milo-arden'));
            return array('log' => $log, 'ids' => $ids, 'error' => false);
        }

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $log[] = array('type' => 'info', 'msg' => __('Importing demo images…', 'milo-arden'));

        $files = glob($dir . '/*.{png,jpg,jpeg,webp,svg,gif}', GLOB_BRACE);
        if (empty($files)) {
            $log[] = array('type' => 'info', 'msg' => __('No image files found in demo/images/.', 'milo-arden'));
            return array('log' => $log, 'ids' => $ids, 'error' => false);
        }

        $upload_dir = wp_upload_dir();

        foreach ($files as $source_path) {
            $filename = basename($source_path);

            // Skip if an attachment with this filename already exists
            $existing = $this->get_demo_attachment_id($filename);
            if ($existing) {
                $this->attachment_map[$filename] = $existing;
                $ids[] = $existing;
                $log[] = array('type' => 'info', 'msg' => sprintf(__('Skipped (exists): %s', 'milo-arden'), $filename));
                continue;
            }

            // Copy file to uploads directory
            $dest_path = $upload_dir['path'] . '/' . $filename;
            if (!copy($source_path, $dest_path)) {
                $log[] = array('type' => 'err', 'msg' => sprintf(__('Could not copy: %s', 'milo-arden'), $filename));
                $error = true;
                continue;
            }

            // Detect MIME type
            $mime = wp_check_filetype($filename);
            if (empty($mime['type'])) {
                $mime['type'] = 'image/png';
            }

            // Build attachment data
            $attachment_data = array(
                'post_mime_type' => $mime['type'],
                'post_title' => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
                'post_content' => '',
                'post_status' => 'inherit',
            );

            $attach_id = wp_insert_attachment($attachment_data, $dest_path);

            if (is_wp_error($attach_id)) {
                $log[] = array('type' => 'err', 'msg' => sprintf(__('Failed: %s — %s', 'milo-arden'), $filename, $attach_id->get_error_message()));
                $error = true;
                continue;
            }

            // Generate thumbnails / metadata
            $metadata = wp_generate_attachment_metadata($attach_id, $dest_path);
            wp_update_attachment_metadata($attach_id, $metadata);

            $this->attachment_map[$filename] = $attach_id;
            $ids[] = $attach_id;

            $log[] = array('type' => 'ok', 'msg' => sprintf(__('Image: %s → ID %d', 'milo-arden'), $filename, $attach_id));
        }

        $log[] = array('type' => 'ok', 'msg' => sprintf(__('%d images imported.', 'milo-arden'), count($ids)));

        return array('log' => $log, 'ids' => $ids, 'error' => $error);
    }

    /**
     * Look up an attachment ID by its original demo filename.
     * Checks the runtime map first, then falls back to a DB query.
     *
     * @param  string   $filename  Original filename (e.g. "logo.png")
     * @return int|false Attachment ID or false if not found.
     */
    public function get_demo_attachment_id($filename)
    {
        // 1. Check runtime map
        if (isset($this->attachment_map[$filename])) {
            return $this->attachment_map[$filename];
        }

        // 2. Query by filename in _wp_attached_file meta
        global $wpdb;
        $like = '%' . $wpdb->esc_like($filename);
        $id = $wpdb->get_var($wpdb->prepare(
            "SELECT post_id FROM {$wpdb->postmeta}
             WHERE meta_key = '_wp_attached_file'
               AND meta_value LIKE %s
             LIMIT 1",
            $like
        ));

        if ($id) {
            $this->attachment_map[$filename] = (int)$id;
            return (int)$id;
        }

        return false;
    }

    /* ================================================================
     STEP 1c — FEATURED IMAGES
     ================================================================ */

    /**
     * Assign featured images (post thumbnails) to imported posts & pages
     * using the attachment map built by import_images().
     */
    private function set_featured_images()
    {
        $log = array();
        $error = false;

        // Map: post/page slug => demo image filename
        $thumbnail_map = array(
            // Blog posts
            'why-i-design-in-the-browser' => 'post-design-browser.png',
            'building-calm-software' => 'post-calm-software.png',
            'practical-guide-to-design-tokens' => 'post-design-tokens.png',
            'accessibility-is-a-design-skill' => 'post-accessibility.png',
        );

        $log[] = array('type' => 'info', 'msg' => __('Assigning featured images…', 'milo-arden'));
        $count = 0;

        foreach ($thumbnail_map as $slug => $image_file) {
            // Find the post/page by slug
            $post = get_page_by_path($slug, OBJECT, array('post', 'page'));
            if (!$post) {
                $log[] = array('type' => 'info', 'msg' => sprintf(__('Post not found for slug: %s', 'milo-arden'), $slug));
                continue;
            }

            // Find the attachment
            $attach_id = $this->get_demo_attachment_id($image_file);
            if (!$attach_id) {
                $log[] = array('type' => 'info', 'msg' => sprintf(__('Image not found: %s', 'milo-arden'), $image_file));
                continue;
            }

            set_post_thumbnail($post->ID, $attach_id);
            $count++;
            $log[] = array('type' => 'ok', 'msg' => sprintf(__('Thumbnail: %s → %s', 'milo-arden'), $image_file, $post->post_title));
        }

        $log[] = array('type' => 'ok', 'msg' => sprintf(__('%d featured images assigned.', 'milo-arden'), $count));

        return array('log' => $log, 'error' => $error);
    }

    /* ================================================================
     STEP 2 — WIDGETS
     ================================================================ */

    private function import_widgets()
    {
        $log = array();
        $error = false;
        $file = $this->demo_dir . '/widgets.json';

        if (!file_exists($file)) {
            return array('log' => array(array('type' => 'err', 'msg' => __('widgets.json not found.', 'milo-arden'))), 'error' => true);
        }

        $data = json_decode(file_get_contents($file), true);
        if (!is_array($data)) {
            return array('log' => array(array('type' => 'err', 'msg' => __('Could not parse widgets.json.', 'milo-arden'))), 'error' => true);
        }

        $log[] = array('type' => 'info', 'msg' => __('Importing widgets…', 'milo-arden'));

        $sidebars = get_option('sidebars_widgets', array());
        if (!is_array($sidebars)) {
            $sidebars = array();
        }

        foreach ($data as $sidebar_id => $widgets) {
            if (!is_array($widgets)) {
                continue;
            }

            foreach ($widgets as $widget_key => $widget_data) {
                // Parse widget type and find next available instance number
                $parts = explode('-', $widget_key);
                $instance_no = array_pop($parts);
                $widget_type = implode('-', $parts); // e.g. "text", "search", "recent-posts"

                $all_instances = get_option('widget_' . $widget_type, array());
                if (!is_array($all_instances)) {
                    $all_instances = array();
                }

                // Find next available instance number
                $next = empty($all_instances) ? 1 : max(array_keys(array_filter($all_instances, 'is_array'))) + 1;

                $all_instances[$next] = $widget_data;
                update_option('widget_' . $widget_type, $all_instances);

                // Add to sidebar
                if (!isset($sidebars[$sidebar_id]) || !is_array($sidebars[$sidebar_id])) {
                    $sidebars[$sidebar_id] = array();
                }
                $sidebars[$sidebar_id][] = $widget_type . '-' . $next;

                $log[] = array('type' => 'ok', 'msg' => sprintf(__('Widget: %s → %s', 'milo-arden'), $widget_type . '-' . $next, $sidebar_id));
            }
        }

        wp_set_sidebars_widgets($sidebars);
        $log[] = array('type' => 'ok', 'msg' => __('Widgets imported successfully.', 'milo-arden'));

        return array('log' => $log, 'error' => $error);
    }

    /* ================================================================
     STEP 3 — CUSTOMIZER
     ================================================================ */

    private function import_customizer()
    {
        $log = array();
        $error = false;
        $file = $this->demo_dir . '/customizer.json';

        if (!file_exists($file)) {
            return array('log' => array(array('type' => 'err', 'msg' => __('customizer.json not found.', 'milo-arden'))), 'error' => true);
        }

        $data = json_decode(file_get_contents($file), true);
        if (!is_array($data) || empty($data['mods'])) {
            return array('log' => array(array('type' => 'err', 'msg' => __('Could not parse customizer.json.', 'milo-arden'))), 'error' => true);
        }

        $log[] = array('type' => 'info', 'msg' => __('Importing Customizer settings…', 'milo-arden'));

        // Resolve dynamic placeholders
        $home_page = get_page_by_path('home');
        $blog_page = get_page_by_path('blog');

        // Resolve logo attachment via the mapping system
        $logo_attach_id = $this->get_demo_attachment_id('logo.png');

        $replacements = array(
            '{{home_page_id}}' => $home_page ? $home_page->ID : 0,
            '{{blog_page_id}}' => $blog_page ? $blog_page->ID : 0,
            '{{logo_attachment_id}}' => $logo_attach_id ? $logo_attach_id : 0,
        );

        if ($logo_attach_id) {
            $log[] = array('type' => 'ok', 'msg' => sprintf(__('Custom logo → attachment ID %d', 'milo-arden'), $logo_attach_id));
        }

        $count = 0;
        foreach ($data['mods'] as $key => $value) {
            // Skip comment keys
            if (strpos($key, '__') === 0) {
                continue;
            }

            // Skip nav_menu_locations — handled in assign_menus()
            if ('nav_menu_locations' === $key) {
                continue;
            }

            // Resolve placeholders in values
            if (is_string($value)) {
                $value = strtr($value, $replacements);
            }

            set_theme_mod($key, $value);
            $count++;
        }

        $log[] = array('type' => 'ok', 'msg' => sprintf(__('Customizer: %d settings applied.', 'milo-arden'), $count));

        return array('log' => $log, 'error' => $error);
    }

    /* ================================================================
     STEP 4 — ACF FIELDS
     ================================================================ */

    private function import_acf()
    {
        $log = array();
        $error = false;
        $file = $this->demo_dir . '/acf-fields.json';

        if (!file_exists($file)) {
            return array('log' => array(array('type' => 'err', 'msg' => __('acf-fields.json not found.', 'milo-arden'))), 'error' => true);
        }

        if (!function_exists('update_field')) {
            $log[] = array('type' => 'info', 'msg' => __('ACF not active — importing as raw post meta.', 'milo-arden'));
        }

        $data = json_decode(file_get_contents($file), true);
        if (!is_array($data)) {
            return array('log' => array(array('type' => 'err', 'msg' => __('Could not parse acf-fields.json.', 'milo-arden'))), 'error' => true);
        }

        // Find the Home page
        $home_page = get_page_by_path('home');
        if (!$home_page) {
            return array('log' => array(array('type' => 'err', 'msg' => __('Home page not found. Import content first.', 'milo-arden'))), 'error' => true);
        }

        $page_id = $home_page->ID;
        $log[] = array('type' => 'info', 'msg' => sprintf(__('Importing ACF data to page ID %d…', 'milo-arden'), $page_id));

        $count = 0;
        foreach ($data as $field_name => $field_value) {
            // Skip info/comment keys
            if (strpos($field_name, '__') === 0) {
                continue;
            }

            if (function_exists('update_field')) {
                // Use ACF's update_field for proper repeater serialization
                update_field($field_name, $field_value, $page_id);
            }
            else {
                // Raw post meta fallback — stores as serialized data
                if (is_array($field_value)) {
                    // For repeaters, store count + individual sub-field rows
                    $row_count = count($field_value);
                    update_post_meta($page_id, $field_name, $row_count);

                    foreach ($field_value as $i => $row) {
                        if (is_array($row)) {
                            foreach ($row as $sub_key => $sub_val) {
                                update_post_meta($page_id, $field_name . '_' . $i . '_' . $sub_key, $sub_val);
                            }
                        }
                    }
                }
                else {
                    update_post_meta($page_id, $field_name, $field_value);
                }
            }
            $count++;
        }

        $log[] = array('type' => 'ok', 'msg' => sprintf(__('ACF: %d fields imported.', 'milo-arden'), $count));

        return array('log' => $log, 'error' => $error);
    }

    /* ================================================================
     STEP 5 — MENUS
     ================================================================ */

    private function assign_menus()
    {
        $log = array();
        $error = false;

        $log[] = array('type' => 'info', 'msg' => __('Assigning menu locations…', 'milo-arden'));

        $locations = get_registered_nav_menus();
        $menus = wp_get_nav_menus();

        if (empty($menus)) {
            // Create menus from WXR nav_menu terms
            $menu_map = array(
                'Primary Nav' => array('primary', 'primary-menu'),
                'Footer Work' => array('footer-work'),
                'Footer Contact' => array('footer-contact'),
                'Footer Elsewhere' => array('footer-elsewhere'),
            );

            $file = $this->demo_dir . '/demo-content.xml';
            if (file_exists($file)) {
                $this->create_menus_from_xml($file, $menu_map, $log);
            }

            // Refresh
            $menus = wp_get_nav_menus();
        }

        // Auto-map by slug matching
        $location_assignments = array();
        $slug_location_map = array(
            'primary-nav' => array('primary', 'primary-menu'),
            'footer-work' => array('footer-work', 'footer-menu'),
            'footer-contact' => array('footer-contact'),
            'footer-elsewhere' => array('footer-elsewhere'),
        );

        foreach ($menus as $menu) {
            foreach ($slug_location_map as $slug_pattern => $target_locations) {
                if (stripos($menu->slug, str_replace('-', '', $slug_pattern)) !== false ||
                stripos($menu->slug, $slug_pattern) !== false ||
                stripos(sanitize_title($menu->name), $slug_pattern) !== false) {
                    foreach ($target_locations as $loc) {
                        if (isset($locations[$loc])) {
                            $location_assignments[$loc] = $menu->term_id;
                            $log[] = array('type' => 'ok', 'msg' => sprintf(__('Menu "%s" → %s', 'milo-arden'), $menu->name, $loc));
                        }
                    }
                }
            }
        }

        if (!empty($location_assignments)) {
            set_theme_mod('nav_menu_locations', $location_assignments);
        }

        $log[] = array('type' => 'ok', 'msg' => sprintf(__('%d menu locations assigned.', 'milo-arden'), count($location_assignments)));

        return array('log' => $log, 'error' => $error);
    }

    /**
     * Parse the WXR file and create nav menus + items from nav_menu_item entries.
     */
    private function create_menus_from_xml($file, $menu_map, &$log)
    {
        $xml = simplexml_load_file($file, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (!$xml) {
            return;
        }

        $ns = array(
            'wp' => 'http://wordpress.org/export/1.2/',
            'dc' => 'http://purl.org/dc/elements/1.1/',
        );

        // First pass: create menu terms
        $created_menus = array(); // slug => menu_id

        foreach ($xml->channel->item as $item) {
            $wp = $item->children($ns['wp']);
            if ('nav_menu_item' !== (string)$wp->post_type) {
                continue;
            }

            foreach ($item->category as $cat) {
                if ('nav_menu' === (string)$cat['domain']) {
                    $menu_slug = (string)$cat['nicename'];
                    if (!isset($created_menus[$menu_slug])) {
                        $menu_name = (string)$cat;
                        $existing = wp_get_nav_menu_object($menu_name);
                        if ($existing) {
                            $created_menus[$menu_slug] = $existing->term_id;
                        }
                        else {
                            $new_menu = wp_create_nav_menu($menu_name);
                            if (!is_wp_error($new_menu)) {
                                $created_menus[$menu_slug] = $new_menu;
                                $log[] = array('type' => 'ok', 'msg' => sprintf(__('Created menu: %s', 'milo-arden'), $menu_name));
                            }
                        }
                    }
                }
            }
        }

        // Second pass: add menu items
        foreach ($xml->channel->item as $item) {
            $wp = $item->children($ns['wp']);
            if ('nav_menu_item' !== (string)$wp->post_type) {
                continue;
            }

            $title = (string)$item->title;
            $url = '';
            $type = 'custom';

            // Extract meta
            $meta = array();
            foreach ($wp->postmeta as $pm) {
                $mkey = (string)$pm->children($ns['wp'])->meta_key;
                $mval = (string)$pm->children($ns['wp'])->meta_value;
                $meta[$mkey] = $mval;
            }

            $url = isset($meta['_menu_item_url']) ? $meta['_menu_item_url'] : '#';

            // Find which menu this belongs to
            $menu_id = 0;
            foreach ($item->category as $cat) {
                if ('nav_menu' === (string)$cat['domain']) {
                    $slug = (string)$cat['nicename'];
                    if (isset($created_menus[$slug])) {
                        $menu_id = $created_menus[$slug];
                    }
                }
            }

            if ($menu_id) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $title,
                    'menu-item-url' => $url,
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'custom',
                ));
            }
        }
    }

    /* ================================================================
     STEP 6 — HOMEPAGE SETTINGS
     ================================================================ */

    private function set_homepage()
    {
        $log = array();
        $error = false;

        $home = get_page_by_path('home');
        $blog = get_page_by_path('blog');

        if ($home) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home->ID);
            $log[] = array('type' => 'ok', 'msg' => sprintf(__('Front page set to "Home" (ID %d).', 'milo-arden'), $home->ID));
        }
        else {
            $log[] = array('type' => 'err', 'msg' => __('Could not find "Home" page.', 'milo-arden'));
            $error = true;
        }

        if ($blog) {
            update_option('page_for_posts', $blog->ID);
            $log[] = array('type' => 'ok', 'msg' => sprintf(__('Posts page set to "Blog" (ID %d).', 'milo-arden'), $blog->ID));
        }
        else {
            $log[] = array('type' => 'err', 'msg' => __('Could not find "Blog" page.', 'milo-arden'));
            $error = true;
        }

        return array('log' => $log, 'error' => $error);
    }

    /* ================================================================
     AJAX — UNDO / RESET
     ================================================================ */

    public function ajax_undo()
    {
        check_ajax_referer('milo_undo_demo', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied.', 'milo-arden'));
        }

        $log = array();
        $ids = get_option(self::UNDO_KEY, array());
        $errors = 0;

        if (empty($ids)) {
            wp_send_json_success(array(
                'log' => array(array('type' => 'info', 'msg' => __('No imported content found to remove.', 'milo-arden'))),
                'errors' => 0,
            ));
        }

        $log[] = array('type' => 'info', 'msg' => sprintf(__('Removing %d imported items…', 'milo-arden'), count($ids)));

        foreach ($ids as $post_id) {
            $post = get_post($post_id);
            if (!$post) {
                continue;
            }

            $result = wp_delete_post($post_id, true); // force delete, skip trash
            if ($result) {
                $log[] = array('type' => 'ok', 'msg' => sprintf(__('Deleted: %s (ID %d)', 'milo-arden'), $post->post_title, $post_id));
            }
            else {
                $log[] = array('type' => 'err', 'msg' => sprintf(__('Could not delete ID %d', 'milo-arden'), $post_id));
                $errors++;
            }
        }

        // Reset reading settings
        update_option('show_on_front', 'posts');
        update_option('page_on_front', 0);
        update_option('page_for_posts', 0);
        $log[] = array('type' => 'ok', 'msg' => __('Reading settings reset.', 'milo-arden'));

        // Clear nav menu locations
        set_theme_mod('nav_menu_locations', array());
        $log[] = array('type' => 'ok', 'msg' => __('Menu locations cleared.', 'milo-arden'));

        // Remove all widgets from sidebars
        wp_set_sidebars_widgets(array('wp_inactive_widgets' => array()));
        $log[] = array('type' => 'ok', 'msg' => __('Widgets cleared.', 'milo-arden'));

        // Delete the tracking option
        delete_option(self::UNDO_KEY);
        $log[] = array('type' => 'ok', 'msg' => __('Undo tracking data removed.', 'milo-arden'));

        flush_rewrite_rules();

        wp_send_json_success(array('log' => $log, 'errors' => $errors));
    }
}

// Instantiate — only in admin
if (is_admin()) {
    new Milo_Demo_Importer();
}
