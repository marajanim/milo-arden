<?php
/**
 * Milo Arden — functions.php
 *
 * Theme setup, asset enqueuing, nav menus, Customizer settings,
 * and Custom Post Type registration.
 *
 * @package MiloArden
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* =============================================================
   1. THEME CONSTANTS
   ============================================================= */
define( 'MILO_VERSION', '1.0.0' );
define( 'MILO_DIR',     get_template_directory() );
define( 'MILO_URI',     get_template_directory_uri() );


/* =============================================================
   2. THEME SETUP
   ============================================================= */
function milo_theme_setup() {

	/* Make theme translation-ready */
	load_theme_textdomain( 'milo-arden', MILO_DIR . '/languages' );

	/* Let WordPress manage the <title> tag */
	add_theme_support( 'title-tag' );

	/* Featured images on all post types */
	add_theme_support( 'post-thumbnails' );

	/* HTML5 semantic markup */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
		'gallery', 'caption', 'script', 'style',
	) );

	/* Custom logo — shown in nav and footer */
	add_theme_support( 'custom-logo', array(
		'height'      => 26,
		'width'       => 26,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title' ),
	) );

	/* Selective refresh for widgets */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/* Editor colour palette mirroring CSS tokens */
	add_theme_support( 'editor-color-palette', array(
		array( 'name' => __( 'Green Dark',   'milo-arden' ), 'slug' => 'green-dark',   'color' => '#0E2B1A' ),
		array( 'name' => __( 'Green Accent', 'milo-arden' ), 'slug' => 'green-accent', 'color' => '#C6F25D' ),
		array( 'name' => __( 'Paper',        'milo-arden' ), 'slug' => 'paper',        'color' => '#F5F2EA' ),
		array( 'name' => __( 'Ink',          'milo-arden' ), 'slug' => 'ink',          'color' => '#0A0A0A' ),
		array( 'name' => __( 'Muted',        'milo-arden' ), 'slug' => 'muted',        'color' => '#6A6860' ),
	) );

	/* Register nav menu locations */
	register_nav_menus( array(
		'primary'   => __( 'Primary Navigation (Hero)', 'milo-arden' ),
		'footer-work'    => __( 'Footer — Work',        'milo-arden' ),
		'footer-contact' => __( 'Footer — Contact',     'milo-arden' ),
		'footer-elsewhere' => __( 'Footer — Elsewhere', 'milo-arden' ),
	) );
}
add_action( 'after_setup_theme', 'milo_theme_setup' );


/* =============================================================
   3. ASSETS — ENQUEUE STYLES & SCRIPTS
   ============================================================= */
function milo_enqueue_assets() {

	/* ── Google Fonts ──────────────────────────────────────── */
	wp_enqueue_style(
		'milo-google-fonts',
		'https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap',
		array(),
		null   // no version — Google manages cache-busting
	);

	/* ── Main stylesheet ───────────────────────────────────── */
	wp_enqueue_style(
		'milo-style',
		get_stylesheet_uri(),           // points to style.css in theme root
		array( 'milo-google-fonts' ),
		MILO_VERSION
	);

	/* ── Scroll-reveal script ──────────────────────────────── */
	wp_enqueue_script(
		'milo-main',
		MILO_URI . '/assets/js/main.js',
		array(),                        // no dependencies (vanilla JS)
		MILO_VERSION,
		true                            // load in footer
	);
}
add_action( 'wp_enqueue_scripts', 'milo_enqueue_assets' );


/* =============================================================
   4. CUSTOMIZER — THEME OPTIONS
   ============================================================= */
function milo_customizer_settings( $wp_customize ) {

	/* ── HERO SECTION ──────────────────────────────────────── */
	$wp_customize->add_section( 'milo_hero', array(
		'title'    => __( 'Hero Section', 'milo-arden' ),
		'priority' => 30,
	) );

	$hero_fields = array(
		'milo_hero_eyebrow'        => array( 'label' => __( 'Eyebrow text',          'milo-arden' ), 'default' => 'Available · Q3 2026' ),
		'milo_hero_heading_before' => array( 'label' => __( 'Heading (before accent)','milo-arden' ), 'default' => 'Design-engineering for teams that' ),
		'milo_hero_heading_accent' => array( 'label' => __( 'Heading accent word',    'milo-arden' ), 'default' => 'ship' ),
		'milo_hero_heading_after'  => array( 'label' => __( 'Heading (after accent)', 'milo-arden' ), 'default' => '.' ),
		'milo_hero_lede'           => array( 'label' => __( 'Lead paragraph',         'milo-arden' ), 'default' => 'Independent designer & front-end engineer. I help founders turn rough product ideas into polished, fast, considered software — from first sketch to production.' ),
		'milo_hero_cta_primary_label' => array( 'label' => __( 'Primary CTA label',  'milo-arden' ), 'default' => 'Book a call' ),
		'milo_hero_cta_primary_url'   => array( 'label' => __( 'Primary CTA URL',    'milo-arden' ), 'default' => '#contact' ),
		'milo_hero_cta_ghost_label'   => array( 'label' => __( 'Ghost CTA label',    'milo-arden' ), 'default' => 'See the work' ),
		'milo_hero_cta_ghost_url'     => array( 'label' => __( 'Ghost CTA URL',      'milo-arden' ), 'default' => '#work' ),
		'milo_hero_star_rating'    => array( 'label' => __( 'Star rating text',       'milo-arden' ), 'default' => '5.0 rating' ),
		'milo_hero_collaborators'  => array( 'label' => __( 'Collaborators text',     'milo-arden' ), 'default' => 'from 34 collaborators' ),
	);

	foreach ( $hero_fields as $id => $args ) {
		$wp_customize->add_setting( $id, array( 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( $id, array( 'label' => $args['label'], 'section' => 'milo_hero', 'type' => 'text' ) );
	}

	/* ── STATS SECTION ─────────────────────────────────────── */
	$wp_customize->add_section( 'milo_stats', array(
		'title'    => __( 'Stats Section', 'milo-arden' ),
		'priority' => 50,
	) );

	for ( $i = 1; $i <= 3; $i++ ) {
		$wp_customize->add_setting( "milo_stat_{$i}_number", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "milo_stat_{$i}_number", array( 'label' => sprintf( __( 'Stat %d number', 'milo-arden' ), $i ), 'section' => 'milo_stats', 'type' => 'text' ) );

		$wp_customize->add_setting( "milo_stat_{$i}_label", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "milo_stat_{$i}_label", array( 'label' => sprintf( __( 'Stat %d label', 'milo-arden' ), $i ), 'section' => 'milo_stats', 'type' => 'text' ) );
	}

	/* ── CTA / CONTACT SECTION ─────────────────────────────── */
	$wp_customize->add_section( 'milo_cta', array(
		'title'    => __( 'CTA / Contact Section', 'milo-arden' ),
		'priority' => 60,
	) );

	$cta_fields = array(
		'milo_cta_eyebrow'      => array( 'label' => __( 'Eyebrow text',     'milo-arden' ), 'default' => 'Ready to start?' ),
		'milo_cta_heading'      => array( 'label' => __( 'Heading',          'milo-arden' ), 'default' => "Let's build something that matters." ),
		'milo_cta_lede'         => array( 'label' => __( 'Lead paragraph',   'milo-arden' ), 'default' => "I'm currently booking projects for Q3 2026. Drop a line and I'll reply within a day." ),
		'milo_cta_button_label' => array( 'label' => __( 'Button label',     'milo-arden' ), 'default' => 'Book a call' ),
		'milo_cta_button_url'   => array( 'label' => __( 'Button URL',       'milo-arden' ), 'default' => 'mailto:hello@milo.studio' ),
	);

	foreach ( $cta_fields as $id => $args ) {
		$wp_customize->add_setting( $id, array( 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( $id, array( 'label' => $args['label'], 'section' => 'milo_cta', 'type' => 'text' ) );
	}

	/* ── FOOTER SECTION ────────────────────────────────────── */
	$wp_customize->add_section( 'milo_footer', array(
		'title'    => __( 'Footer', 'milo-arden' ),
		'priority' => 70,
	) );

	$footer_fields = array(
		'milo_footer_brand_desc'  => array( 'label' => __( 'Brand description',  'milo-arden' ), 'default' => 'Independent design-engineering studio based in New York. Shipping calm, considered software for founders and small teams since 2018.' ),
		'milo_contact_email'      => array( 'label' => __( 'Contact email',       'milo-arden' ), 'default' => 'hello@milo.studio' ),
		'milo_social_readcv'      => array( 'label' => __( 'Read.cv URL',         'milo-arden' ), 'default' => '#' ),
		'milo_social_linkedin'    => array( 'label' => __( 'LinkedIn URL',        'milo-arden' ), 'default' => '#' ),
		'milo_social_github'      => array( 'label' => __( 'GitHub URL',          'milo-arden' ), 'default' => '#' ),
		'milo_social_arena'       => array( 'label' => __( 'Are.na URL',          'milo-arden' ), 'default' => '#' ),
	);

	foreach ( $footer_fields as $id => $args ) {
		$wp_customize->add_setting( $id, array( 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( $id, array( 'label' => $args['label'], 'section' => 'milo_footer', 'type' => 'text' ) );
	}
}
add_action( 'customize_register', 'milo_customizer_settings' );


/* =============================================================
   5. CUSTOM POST TYPES
   ============================================================= */

/** Projects -------------------------------------------------- */
function milo_register_cpt_projects() {
	$labels = array(
		'name'               => __( 'Projects',        'milo-arden' ),
		'singular_name'      => __( 'Project',         'milo-arden' ),
		'add_new_item'       => __( 'Add New Project',  'milo-arden' ),
		'menu_name'          => __( 'Projects',        'milo-arden' ),
	);
	register_post_type( 'milo_project', array(
		'labels'        => $labels,
		'public'        => true,
		'has_archive'   => true,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'menu_icon'     => 'dashicons-portfolio',
		'rewrite'       => array( 'slug' => 'work' ),
		'show_in_rest'  => true,
	) );
}
add_action( 'init', 'milo_register_cpt_projects' );

/** Testimonials ---------------------------------------------- */
function milo_register_cpt_testimonials() {
	$labels = array(
		'name'          => __( 'Testimonials',          'milo-arden' ),
		'singular_name' => __( 'Testimonial',           'milo-arden' ),
		'add_new_item'  => __( 'Add New Testimonial',   'milo-arden' ),
	);
	register_post_type( 'milo_testimonial', array(
		'labels'       => $labels,
		'public'       => false,
		'show_ui'      => true,
		'supports'     => array( 'title', 'editor', 'custom-fields' ),
		'menu_icon'    => 'dashicons-format-quote',
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'milo_register_cpt_testimonials' );

/** Experience ------------------------------------------------ */
function milo_register_cpt_experience() {
	$labels = array(
		'name'          => __( 'Experience',            'milo-arden' ),
		'singular_name' => __( 'Experience Entry',      'milo-arden' ),
		'add_new_item'  => __( 'Add Experience Entry',  'milo-arden' ),
	);
	register_post_type( 'milo_experience', array(
		'labels'       => $labels,
		'public'       => false,
		'show_ui'      => true,
		'supports'     => array( 'title', 'custom-fields' ),
		'menu_icon'    => 'dashicons-businessman',
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'milo_register_cpt_experience' );

/** FAQ ------------------------------------------------------- */
function milo_register_cpt_faq() {
	$labels = array(
		'name'          => __( 'FAQ',                 'milo-arden' ),
		'singular_name' => __( 'FAQ Item',            'milo-arden' ),
		'add_new_item'  => __( 'Add FAQ Item',        'milo-arden' ),
	);
	register_post_type( 'milo_faq', array(
		'labels'       => $labels,
		'public'       => false,
		'show_ui'      => true,
		'supports'     => array( 'title', 'editor', 'custom-fields' ),
		'menu_icon'    => 'dashicons-editor-help',
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'milo_register_cpt_faq' );


/* =============================================================
   6. HELPER: Customizer value with fallback
   ============================================================= */
function milo_get( $key, $fallback = '' ) {
	return esc_html( get_theme_mod( $key, $fallback ) );
}

/* Sanitize URL wrapper */
function milo_get_url( $key, $fallback = '#' ) {
	return esc_url( get_theme_mod( $key, $fallback ) );
}
