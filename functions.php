<?php
/**
 * Milo Arden — functions.php
 *
 * Theme setup, asset enqueuing, nav menus, Customizer settings,
 * and Custom Post Type registration.
 *
 * @package MiloArden
 */

if (!defined('ABSPATH')) {
	exit;
}

/* =============================================================
 1. THEME CONSTANTS
 ============================================================= */
define('MILO_VERSION', '1.0.0');
define('MILO_DIR', get_template_directory());
define('MILO_URI', get_template_directory_uri());


/* =============================================================
 2. THEME SETUP
 ============================================================= */
function milo_theme_setup()
{

	/* Make theme translation-ready */
	load_theme_textdomain('milo-arden', MILO_DIR . '/languages');

	/* Let WordPress manage the <title> tag */
	add_theme_support('title-tag');

	/* Featured images on all post types */
	add_theme_support('post-thumbnails');

	/* HTML5 semantic markup */
	add_theme_support('html5', array(
		'search-form', 'comment-form', 'comment-list',
		'gallery', 'caption', 'script', 'style',
	));

	/* Custom logo — shown in nav and footer */
	add_theme_support('custom-logo', array(
		'height' => 26,
		'width' => 26,
		'flex-height' => true,
		'flex-width' => true,
		'header-text' => array('site-title'),
	));

	/* Selective refresh for widgets */
	add_theme_support('customize-selective-refresh-widgets');

	/* Editor colour palette mirroring CSS tokens */
	add_theme_support('editor-color-palette', array(
			array('name' => __('Green Dark', 'milo-arden'), 'slug' => 'green-dark', 'color' => '#0E2B1A'),
			array('name' => __('Green Accent', 'milo-arden'), 'slug' => 'green-accent', 'color' => '#C6F25D'),
			array('name' => __('Paper', 'milo-arden'), 'slug' => 'paper', 'color' => '#F5F2EA'),
			array('name' => __('Ink', 'milo-arden'), 'slug' => 'ink', 'color' => '#0A0A0A'),
			array('name' => __('Muted', 'milo-arden'), 'slug' => 'muted', 'color' => '#6A6860'),
	));

	/* Register nav menu locations */
	register_nav_menus(array(
		'primary' => __('Primary Navigation (Hero)', 'milo-arden'),
		'footer-work' => __('Footer — Work', 'milo-arden'),
		'footer-contact' => __('Footer — Contact', 'milo-arden'),
		'footer-elsewhere' => __('Footer — Elsewhere', 'milo-arden'),
	));
}
add_action('after_setup_theme', 'milo_theme_setup');


/* =============================================================
 3. ASSETS — ENQUEUE STYLES & SCRIPTS
 ============================================================= */
function milo_enqueue_assets()
{

	/* ── 1. Google Fonts ─────────────────────────────────────
	 *  Registered separately so child themes / plugins can
	 *  dequeue without touching main stylesheet.
	 * ──────────────────────────────────────────────────────── */
	wp_register_style(
		'milo-google-fonts',
		'https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap',
		array(),
		null // no version — Google manages cache-busting for fonts
	);
	wp_enqueue_style('milo-google-fonts');

	/* ── 2. WordPress required stylesheet (header only) ──────
	 *  style.css contains only the theme header comment block.
	 *  WordPress requires this file to identify the theme;
	 *  it carries zero visual styles.
	 * ──────────────────────────────────────────────────────── */
	wp_enqueue_style(
		'milo-style',
		get_stylesheet_uri(), // → style.css
		array(),
		MILO_VERSION
	);

	/* ── 3. Main theme stylesheet ────────────────────────────
	 *  All custom CSS: tokens, components, layout, responsive.
	 *  Depends on Google Fonts so webfonts are declared first.
	 * ──────────────────────────────────────────────────────── */
	wp_enqueue_style(
		'milo-theme',
		MILO_URI . '/assets/css/theme.css',
		array('milo-google-fonts'), // dependency chain
		MILO_VERSION
	);

	/* ── 4. Theme JavaScript ─────────────────────────────────
	 *  Vanilla JS — no jQuery or other library dependency.
	 *  Loaded in the footer after the DOM so no defer needed.
	 *  Uses MILO_VERSION for automatic cache-busting on deploy.
	 * ──────────────────────────────────────────────────────── */
	wp_register_script(
		'milo-theme-js',
		MILO_URI . '/assets/js/theme.js',
		array(), // no dependencies
		MILO_VERSION,
		true // load in <footer> — after DOM is parsed
	);
	wp_enqueue_script('milo-theme-js');
}
add_action('wp_enqueue_scripts', 'milo_enqueue_assets');



/* =============================================================
 4. CUSTOMIZER — THEME OPTIONS
 ============================================================= */
function milo_customizer_settings($wp_customize)
{

	/* ── HERO SECTION ──────────────────────────────────────── */
	$wp_customize->add_section('milo_hero', array(
		'title' => __('Hero Section', 'milo-arden'),
		'priority' => 30,
	));

	$hero_fields = array(
		'milo_hero_eyebrow' => array('label' => __('Eyebrow text', 'milo-arden'), 'default' => 'Available · Q3 2026'),
		'milo_hero_heading_before' => array('label' => __('Heading (before accent)', 'milo-arden'), 'default' => 'Design-engineering for teams that'),
		'milo_hero_heading_accent' => array('label' => __('Heading accent word', 'milo-arden'), 'default' => 'ship'),
		'milo_hero_heading_after' => array('label' => __('Heading (after accent)', 'milo-arden'), 'default' => '.'),
		'milo_hero_lede' => array('label' => __('Lead paragraph', 'milo-arden'), 'default' => 'Independent designer & front-end engineer. I help founders turn rough product ideas into polished, fast, considered software — from first sketch to production.'),
		'milo_hero_cta_primary_label' => array('label' => __('Primary CTA label', 'milo-arden'), 'default' => 'Book a call'),
		'milo_hero_cta_primary_url' => array('label' => __('Primary CTA URL', 'milo-arden'), 'default' => '#contact'),
		'milo_hero_cta_ghost_label' => array('label' => __('Ghost CTA label', 'milo-arden'), 'default' => 'See the work'),
		'milo_hero_cta_ghost_url' => array('label' => __('Ghost CTA URL', 'milo-arden'), 'default' => '#work'),
		'milo_hero_star_rating' => array('label' => __('Star rating text', 'milo-arden'), 'default' => '5.0 rating'),
		'milo_hero_collaborators' => array('label' => __('Collaborators text', 'milo-arden'), 'default' => 'from 34 collaborators'),
	);

	foreach ($hero_fields as $id => $args) {
		$wp_customize->add_setting($id, array('default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control($id, array('label' => $args['label'], 'section' => 'milo_hero', 'type' => 'text'));
	}

	/* ── LOGOS SECTION ─────────────────────────────────────── */
	$wp_customize->add_section('milo_logos', array(
		'title' => __('Logos Section', 'milo-arden'),
		'priority' => 35,
	));

	$logos_fields = array(
		'milo_logos_label' => array('label' => __('Section label', 'milo-arden'), 'default' => 'Trusted by teams who ship'),
		'milo_logos_names' => array('label' => __('Client names (comma-separated)', 'milo-arden'), 'default' => 'Stripe,Ledger,Thread,Margin,Halftone,Fieldnote'),
	);

	foreach ($logos_fields as $id => $args) {
		$wp_customize->add_setting($id, array('default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control($id, array('label' => $args['label'], 'section' => 'milo_logos', 'type' => 'text'));
	}

	/* ── SERVICES / WHAT I BUILD SECTION ───────────────────── */
	$wp_customize->add_section('milo_services', array(
		'title' => __('Services / What I Build', 'milo-arden'),
		'priority' => 38,
	));

	$services_fields = array(
		'milo_services_eyebrow' => array('label' => __('Eyebrow text', 'milo-arden'), 'default' => 'What I build'),
		'milo_services_heading' => array('label' => __('Section heading', 'milo-arden'), 'default' => 'Everything you need to take a product from idea to ship.'),
		'milo_services_lede' => array('label' => __('Lead paragraph', 'milo-arden'), 'default' => 'I work as a small, senior team of one — research, design, and engineering under a single person. Less handoff, more craft.'),
		'milo_services_card_eyebrow' => array('label' => __('Card eyebrow', 'milo-arden'), 'default' => 'Foundation'),
		'milo_services_card_title' => array('label' => __('Card title', 'milo-arden'), 'default' => 'Product design & systems'),
		'milo_services_card_desc' => array('label' => __('Card description', 'milo-arden'), 'default' => 'Design systems, component libraries, and full product flows that stay consistent as teams scale.'),
		'milo_services_card_number' => array('label' => __('Card stat number', 'milo-arden'), 'default' => '64'),
		'milo_services_card_unit' => array('label' => __('Card stat unit', 'milo-arden'), 'default' => '+'),
		'milo_services_card_chip' => array('label' => __('Card chip label', 'milo-arden'), 'default' => 'Shipped'),
		'milo_services_quote' => array('label' => __('Quote text', 'milo-arden'), 'default' => '"The kind of collaborator you build a company around."'),
		'milo_services_quote_desc' => array('label' => __('Quote description', 'milo-arden'), 'default' => 'Seven years of work across startups, labs, and agencies — shipped, documented, and loved.'),
		'milo_services_quote_name' => array('label' => __('Quote author name', 'milo-arden'), 'default' => 'Elena Vasquez'),
		'milo_services_quote_role' => array('label' => __('Quote author role', 'milo-arden'), 'default' => 'Founder, Ledger'),
	);

	foreach ($services_fields as $id => $args) {
		$wp_customize->add_setting($id, array('default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control($id, array('label' => $args['label'], 'section' => 'milo_services', 'type' => 'text'));
	}

	/* ── PORTFOLIO SECTION ─────────────────────────────────── */
	$wp_customize->add_section('milo_portfolio', array(
		'title' => __('Portfolio Section', 'milo-arden'),
		'priority' => 40,
	));

	$portfolio_fields = array(
		'milo_portfolio_eyebrow' => array('label' => __('Eyebrow text', 'milo-arden'), 'default' => 'Selected work'),
		'milo_portfolio_heading' => array('label' => __('Section heading', 'milo-arden'), 'default' => 'Where ideas take shape.'),
		'milo_portfolio_lede' => array('label' => __('Lead paragraph', 'milo-arden'), 'default' => 'Five recent projects that show how design and engineering meet on my desk.'),
	);

	foreach ($portfolio_fields as $id => $args) {
		$wp_customize->add_setting($id, array('default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control($id, array('label' => $args['label'], 'section' => 'milo_portfolio', 'type' => 'text'));
	}

	/* ── STATS SECTION ─────────────────────────────────────── */
	$wp_customize->add_section('milo_stats', array(
		'title' => __('Stats Section', 'milo-arden'),
		'priority' => 50,
	));

	$stats_header_fields = array(
		'milo_stats_eyebrow' => array('label' => __('Eyebrow text', 'milo-arden'), 'default' => 'By the numbers'),
		'milo_stats_heading' => array('label' => __('Section heading', 'milo-arden'), 'default' => 'Seven years, measured.'),
		'milo_stats_lede' => array('label' => __('Lead paragraph', 'milo-arden'), 'default' => "Work I've been proud to put my name on, and the teams I've put it on with."),
	);

	foreach ($stats_header_fields as $id => $args) {
		$wp_customize->add_setting($id, array('default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control($id, array('label' => $args['label'], 'section' => 'milo_stats', 'type' => 'text'));
	}

	for ($i = 1; $i <= 3; $i++) {
		$wp_customize->add_setting("milo_stat_{$i}_number", array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control("milo_stat_{$i}_number", array('label' => sprintf(__('Stat %d number', 'milo-arden'), $i), 'section' => 'milo_stats', 'type' => 'text'));

		$wp_customize->add_setting("milo_stat_{$i}_label", array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control("milo_stat_{$i}_label", array('label' => sprintf(__('Stat %d label', 'milo-arden'), $i), 'section' => 'milo_stats', 'type' => 'text'));
	}

	/* ── TESTIMONIALS SECTION ──────────────────────────────── */
	$wp_customize->add_section('milo_testimonials', array(
		'title' => __('Testimonials Section', 'milo-arden'),
		'priority' => 52,
	));

	$testimonials_fields = array(
		'milo_testimonials_eyebrow' => array('label' => __('Eyebrow text', 'milo-arden'), 'default' => 'Kind words'),
		'milo_testimonials_heading' => array('label' => __('Section heading', 'milo-arden'), 'default' => 'Loved by the teams I work with.'),
		'milo_testimonials_lede' => array('label' => __('Lead paragraph', 'milo-arden'), 'default' => "A few lines from founders and collaborators I've shipped with."),
	);

	foreach ($testimonials_fields as $id => $args) {
		$wp_customize->add_setting($id, array('default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control($id, array('label' => $args['label'], 'section' => 'milo_testimonials', 'type' => 'text'));
	}

	/* ── EXPERIENCE SECTION ────────────────────────────────── */
	$wp_customize->add_section('milo_experience', array(
		'title' => __('Experience Section', 'milo-arden'),
		'priority' => 54,
	));

	$experience_fields = array(
		'milo_experience_eyebrow' => array('label' => __('Eyebrow text', 'milo-arden'), 'default' => 'Background'),
		'milo_experience_heading' => array('label' => __('Section heading', 'milo-arden'), 'default' => "Where I've been."),
	);

	foreach ($experience_fields as $id => $args) {
		$wp_customize->add_setting($id, array('default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control($id, array('label' => $args['label'], 'section' => 'milo_experience', 'type' => 'text'));
	}

	/* ── FAQ SECTION ───────────────────────────────────────── */
	$wp_customize->add_section('milo_faq', array(
		'title' => __('FAQ Section', 'milo-arden'),
		'priority' => 56,
	));

	$faq_fields = array(
		'milo_faq_eyebrow' => array('label' => __('Eyebrow text', 'milo-arden'), 'default' => 'Questions'),
		'milo_faq_heading' => array('label' => __('Section heading', 'milo-arden'), 'default' => 'Common questions.'),
	);

	foreach ($faq_fields as $id => $args) {
		$wp_customize->add_setting($id, array('default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control($id, array('label' => $args['label'], 'section' => 'milo_faq', 'type' => 'text'));
	}

	/* ── CTA / CONTACT SECTION ─────────────────────────────── */
	$wp_customize->add_section('milo_cta', array(
		'title' => __('CTA / Contact Section', 'milo-arden'),
		'priority' => 60,
	));

	$cta_fields = array(
		'milo_cta_eyebrow' => array('label' => __('Eyebrow text', 'milo-arden'), 'default' => 'Ready to start?'),
		'milo_cta_heading' => array('label' => __('Heading', 'milo-arden'), 'default' => "Let's build something that matters."),
		'milo_cta_lede' => array('label' => __('Lead paragraph', 'milo-arden'), 'default' => "I'm currently booking projects for Q3 2026. Drop a line and I'll reply within a day."),
		'milo_cta_button_label' => array('label' => __('Button label', 'milo-arden'), 'default' => 'Book a call'),
		'milo_cta_button_url' => array('label' => __('Button URL', 'milo-arden'), 'default' => 'mailto:hello@milo.studio'),
	);

	foreach ($cta_fields as $id => $args) {
		$wp_customize->add_setting($id, array('default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control($id, array('label' => $args['label'], 'section' => 'milo_cta', 'type' => 'text'));
	}

	/* ── FOOTER SECTION ────────────────────────────────────── */
	$wp_customize->add_section('milo_footer', array(
		'title' => __('Footer', 'milo-arden'),
		'priority' => 70,
	));

	$footer_fields = array(
		'milo_footer_brand_desc' => array('label' => __('Brand description', 'milo-arden'), 'default' => 'Independent design-engineering studio based in New York. Shipping calm, considered software for founders and small teams since 2018.'),
		'milo_contact_email' => array('label' => __('Contact email', 'milo-arden'), 'default' => 'hello@milo.studio'),
		'milo_social_readcv' => array('label' => __('Read.cv URL', 'milo-arden'), 'default' => '#'),
		'milo_social_linkedin' => array('label' => __('LinkedIn URL', 'milo-arden'), 'default' => '#'),
		'milo_social_github' => array('label' => __('GitHub URL', 'milo-arden'), 'default' => '#'),
		'milo_social_arena' => array('label' => __('Are.na URL', 'milo-arden'), 'default' => '#'),
	);

	foreach ($footer_fields as $id => $args) {
		$wp_customize->add_setting($id, array('default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field'));
		$wp_customize->add_control($id, array('label' => $args['label'], 'section' => 'milo_footer', 'type' => 'text'));
	}
}
add_action('customize_register', 'milo_customizer_settings');


/* =============================================================
 5. CUSTOM POST TYPES
 ============================================================= */

/** Projects -------------------------------------------------- */
function milo_register_cpt_projects()
{
	$labels = array(
		'name' => __('Projects', 'milo-arden'),
		'singular_name' => __('Project', 'milo-arden'),
		'add_new_item' => __('Add New Project', 'milo-arden'),
		'menu_name' => __('Projects', 'milo-arden'),
	);
	register_post_type('milo_project', array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
		'menu_icon' => 'dashicons-portfolio',
		'rewrite' => array('slug' => 'work'),
		'show_in_rest' => true,
	));
}
add_action('init', 'milo_register_cpt_projects');

/** Testimonials ---------------------------------------------- */
function milo_register_cpt_testimonials()
{
	$labels = array(
		'name' => __('Testimonials', 'milo-arden'),
		'singular_name' => __('Testimonial', 'milo-arden'),
		'add_new_item' => __('Add New Testimonial', 'milo-arden'),
	);
	register_post_type('milo_testimonial', array(
		'labels' => $labels,
		'public' => false,
		'show_ui' => true,
		'supports' => array('title', 'editor', 'custom-fields'),
		'menu_icon' => 'dashicons-format-quote',
		'show_in_rest' => true,
	));
}
add_action('init', 'milo_register_cpt_testimonials');

/** Experience ------------------------------------------------ */
function milo_register_cpt_experience()
{
	$labels = array(
		'name' => __('Experience', 'milo-arden'),
		'singular_name' => __('Experience Entry', 'milo-arden'),
		'add_new_item' => __('Add Experience Entry', 'milo-arden'),
	);
	register_post_type('milo_experience', array(
		'labels' => $labels,
		'public' => false,
		'show_ui' => true,
		'supports' => array('title', 'custom-fields'),
		'menu_icon' => 'dashicons-businessman',
		'show_in_rest' => true,
	));
}
add_action('init', 'milo_register_cpt_experience');

/** FAQ ------------------------------------------------------- */
function milo_register_cpt_faq()
{
	$labels = array(
		'name' => __('FAQ', 'milo-arden'),
		'singular_name' => __('FAQ Item', 'milo-arden'),
		'add_new_item' => __('Add FAQ Item', 'milo-arden'),
	);
	register_post_type('milo_faq', array(
		'labels' => $labels,
		'public' => false,
		'show_ui' => true,
		'supports' => array('title', 'editor', 'custom-fields'),
		'menu_icon' => 'dashicons-editor-help',
		'show_in_rest' => true,
	));
}
add_action('init', 'milo_register_cpt_faq');


/* =============================================================
 6. HELPER: Customizer value with fallback
 ============================================================= */
function milo_get($key, $fallback = '')
{
	return esc_html(get_theme_mod($key, $fallback));
}

/* Sanitize URL wrapper */
function milo_get_url($key, $fallback = '#')
{
	return esc_url(get_theme_mod($key, $fallback));
}
