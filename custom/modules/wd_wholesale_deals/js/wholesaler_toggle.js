(function ($) {
    function toggleWholesalerFields() {
        var isWholesaler = $('#is_wholesaler').is(':checked') || $('#is_wholesaler').val() === '1';
        $('.wholesaler-only').closest('tr').toggle(isWholesaler);
    }

    $(document).ready(function () {
        toggleWholesalerFields();
        $('#is_wholesaler').on('change', toggleWholesalerFields);
    });
})(jQuery);
