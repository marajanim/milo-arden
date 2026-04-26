/**
 * Milo Arden — Demo Import AJAX Handler
 *
 * Handles the "Import Demo" and "Undo" buttons on the
 * Appearance → Import Demo Data admin page.
 *
 * @package MiloArden
 */

(function ($) {
    'use strict';

    var cfg = window.miloDemoImport || {};
    var $btn = $('#milo-import-btn');
    var $undoBtn = $('#milo-undo-btn');
    var $progress = $('#milo-progress');
    var $bar = $('#milo-progress-bar');
    var $log = $('#milo-progress-log');
    var $complete = $('#milo-complete');

    /* ── Helpers ─────────────────────────────────────────── */

    function logLine(type, msg) {
        var cls = 'step-' + (type || 'info');
        var prefix = type === 'ok' ? '✓' : type === 'err' ? '✗' : '›';
        $log.append('<div class="' + cls + '">' + prefix + ' ' + msg + '</div>');
        // Auto-scroll to bottom
        $log.scrollTop($log[0].scrollHeight);
    }

    function setBar(pct) {
        $bar.css('width', Math.min(pct, 100) + '%');
    }

    function getSelectedSteps() {
        var steps = [];
        $('input[name="milo_import[]"]:checked').each(function () {
            steps.push($(this).val());
        });
        return steps;
    }

    function lockUI() {
        $btn.prop('disabled', true).text(cfg.strings.importing);
        if ($undoBtn.length) $undoBtn.prop('disabled', true);
        $progress.slideDown(200);
        $complete.hide();
        $log.empty();
        setBar(0);
    }

    function unlockUI() {
        $btn.prop('disabled', false).text('🚀 Import Demo Data');
        if ($undoBtn.length) $undoBtn.prop('disabled', false);
    }

    /* ── Import ──────────────────────────────────────────── */

    $btn.on('click', function (e) {
        e.preventDefault();

        var steps = getSelectedSteps();
        if (!steps.length) {
            alert('Please select at least one option to import.');
            return;
        }

        if (!confirm(cfg.strings.confirm)) return;

        lockUI();

        var totalSteps = steps.length + 1; // +1 for rewrite flush logged by PHP
        var currentStep = 0;

        logLine('info', 'Starting import (' + steps.length + ' steps)…');
        setBar(5);

        // Simulate incremental progress while waiting
        var progressTimer = setInterval(function () {
            currentStep++;
            var pct = Math.min(5 + (currentStep * (80 / totalSteps)), 85);
            setBar(pct);
        }, 1200);

        $.ajax({
            url: cfg.ajaxUrl,
            type: 'POST',
            data: {
                action: 'milo_import_demo',
                nonce: cfg.importNonce,
                steps: steps
            },
            timeout: 300000, // 5 minutes
            success: function (response) {
                clearInterval(progressTimer);

                if (response.success && response.data) {
                    // Render all log entries
                    var entries = response.data.log || [];
                    for (var i = 0; i < entries.length; i++) {
                        logLine(entries[i].type, entries[i].msg);
                    }

                    if (response.data.errors > 0) {
                        setBar(100);
                        logLine('err', cfg.strings.failed + ' (' + response.data.errors + ' error(s))');
                    } else {
                        setBar(100);
                        logLine('ok', cfg.strings.complete);
                        $complete.slideDown(200);
                    }
                } else {
                    setBar(100);
                    logLine('err', response.data || 'Unknown error.');
                }

                unlockUI();
            },
            error: function (xhr, status, err) {
                clearInterval(progressTimer);
                setBar(100);
                logLine('err', 'AJAX error: ' + (err || status));
                unlockUI();
            }
        });
    });

    /* ── Undo ────────────────────────────────────────────── */

    $undoBtn.on('click', function (e) {
        e.preventDefault();

        if (!confirm(cfg.strings.confirmUndo)) return;

        lockUI();
        $btn.text(cfg.strings.undoing);
        logLine('info', cfg.strings.undoing);
        setBar(20);

        $.ajax({
            url: cfg.ajaxUrl,
            type: 'POST',
            data: {
                action: 'milo_undo_demo',
                nonce: cfg.undoNonce
            },
            timeout: 120000,
            success: function (response) {
                if (response.success && response.data) {
                    var entries = response.data.log || [];
                    for (var i = 0; i < entries.length; i++) {
                        logLine(entries[i].type, entries[i].msg);
                    }

                    setBar(100);

                    if (response.data.errors > 0) {
                        logLine('err', 'Undo completed with ' + response.data.errors + ' error(s).');
                    } else {
                        logLine('ok', cfg.strings.undone);
                    }
                } else {
                    logLine('err', response.data || 'Unknown error.');
                    setBar(100);
                }

                unlockUI();
            },
            error: function (xhr, status, err) {
                setBar(100);
                logLine('err', 'AJAX error: ' + (err || status));
                unlockUI();
            }
        });
    });

})(jQuery);
