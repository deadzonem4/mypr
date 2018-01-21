(function($) {
    'use strict';

    $(document).ready(function() {
        $('.es-search__wrapper select:not(.es-select2-tags)').esDropDown();

        $('.es-search__wrapper form').on('reset', function() {
            var $selectBox = $( '.js-es-location' );
            $selectBox.find( 'option:first' ).attr( 'selected', 'selected' );
            $selectBox.closest( '.es-dropdown-wrap' ).find( 'li.active' ).removeClass( 'active' );
            $selectBox.trigger( 'change' );

            $('.es-search__field input').val('');

            $('.es-select2-tags, .es-search__wrapper select').val( null ).trigger( 'change' );
        });

        $(' .es-select2-tags ').select2({
            tags: true
        });
    });
})(jQuery);
