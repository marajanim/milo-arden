<?php
/**
 * CTA / Contact section partial.
 * Content driven by Appearance → Customize → CTA / Contact Section.
 * NOTE: This partial is also rendered in footer.php — remove it from
 *       here if you prefer it inside the footer file instead.
 *
 * @package MiloArden
 */

/**
 * The CTA block is already output in footer.php.
 * This file acts as the explicit template-parts hook
 * called from index.php/front-page.php.
 *
 * If footer.php is already rendering the CTA, remove
 * the get_template_part( 'template-parts/cta' ) call
 * from index.php to avoid duplication.
 */

// The CTA HTML lives in footer.php (printed before <footer>).
// Nothing to render here — this file is intentionally a no-op placeholder
// so the get_template_part() call in index.php doesn't trigger a 404 notice.
//
// To move the CTA out of footer.php and into this partial, cut the
// .cta-wrap block from footer.php and paste it here.
