(function () {
    'use strict';
    // Placeholder for future analytics / click tracking
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.wcb-button');
        if (btn && typeof gtag === 'function') {
            gtag('event', 'whatsapp_click', { event_category: 'engagement' });
        }
    });
})();