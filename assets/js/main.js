/**
 * Milo Arden — main.js
 *
 * Scroll-reveal: when a .reveal element enters the viewport
 * it gets the .in class, triggering the CSS fade-up transition.
 * Each element is unobserved after firing so the animation runs once.
 */
(function () {
    'use strict';

    if (!('IntersectionObserver' in window)) {
        // Graceful degradation — just show everything immediately
        document.querySelectorAll('.reveal').forEach(function (el) {
            el.classList.add('in');
        });
        return;
    }

    var io = new IntersectionObserver(
        function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in');
                    io.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px',
        }
    );

    document.querySelectorAll('.reveal').forEach(function (el) {
        io.observe(el);
    });
})();
