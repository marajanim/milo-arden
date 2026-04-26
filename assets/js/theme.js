/**
 * Milo Arden — assets/js/theme.js
 *
 * All theme JavaScript. Enqueued via wp_enqueue_script() in functions.php
 * with: no dependencies (vanilla JS), in footer, and MILO_VERSION for cache-busting.
 *
 * Sections:
 *  1. Scroll-reveal  — IntersectionObserver-based fade-up for .reveal elements
 */

(function () {
    'use strict';

    /* ── 1. Scroll Reveal ─────────────────────────────────────── */
    function initReveal() {
        var elems = document.querySelectorAll('.reveal');

        // Graceful degradation — if IntersectionObserver isn't supported,
        // immediately show all elements so nothing stays invisible.
        if (!('IntersectionObserver' in window)) {
            elems.forEach(function (el) {
                el.classList.add('in');
            });
            return;
        }

        var io = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in');
                        io.unobserve(entry.target); // fire once per element
                    }
                });
            },
            {
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px',
            }
        );

        elems.forEach(function (el) {
            io.observe(el);
        });
    }

    /* ── Init ────────────────────────────────────────────────── */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initReveal);
    } else {
        // DOM already parsed (script loaded async / in footer)
        initReveal();
    }

})();
