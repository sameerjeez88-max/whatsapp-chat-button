(function ($) {
    'use strict';
    $(function () {
        // Lightweight color picker fallback (uses native input if present)
        var $field = $('.wcb-color-field');
        if ($field.length && $field.attr('type') === 'text') {
            $field.attr('type', 'color');
        }
    });
})(jQuery);